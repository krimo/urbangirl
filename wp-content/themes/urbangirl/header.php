<?php
    global $current_user;
    global $categories_to_display;

    get_currentuserinfo();

    $ug_preferences_array = array(
        'gourmande-switch' => ''.get_category_by_slug('gastronomie')->term_id,
        'romantique-switch' => get_category_by_slug('couple')->term_id . ',' . get_category_by_slug('mariage')->term_id,
        'geekette-switch' => ''.get_category_by_slug('actualites')->term_id,
        'sportive-switch' => ''.get_category_by_slug('sport')->term_id,
        'maman-switch' => ''.get_category_by_slug('maman')->term_id,
        'fashion-switch' => ''.get_category_by_slug('mode')->term_id,
        'beauty-switch' => ''.get_category_by_slug('beaute')->term_id,
        'weight-switch' => get_category_by_slug('gastronomie')->term_id . ',' . get_category_by_slug('gourmand-leger')->term_id,
        'deals-switch' => ''.get_category_by_slug('bonnes-adresses')->term_id,
    );

    // Building the categories list to display given the choices of the user
    if (is_user_logged_in() || isset($_COOKIE['ug_preferences'])) {
        $user_preferences = (is_user_logged_in()) ? queryToArray(get_user_meta(get_current_user_id(), 'my_ug', true)) : queryToArray($_COOKIE['ug_preferences']);
        $categories_to_display = '1';

        if ($user_preferences) {
            foreach ($ug_preferences_array as $k => $v) {
                if (array_key_exists($k, $user_preferences)) {
                    $categories_to_display .= ','.$v;
                }
            }

            $t = explode(',', $categories_to_display);

            if (sizeof($t) <= 2) {
                $categories_to_display .= ',53,15';
            }
        } else {
            $categories_to_display = 'all';
        }

    }

    // No thanks updates preferences too
    if ($_POST['ug-update-blank']) {
        $theArray = $_POST;

        unset($theArray['ug-update-blank']);

        if (isset($_COOKIE['ug_preferences'])) {
            setcookie('ug_preferences', "", time()-3600);
        }

        setcookie('ug_preferences', rawurldecode(http_build_query($theArray)));
        header('Location:'.home_url());
    }

    // Create user and prefs
    if (isset($_POST['ug-save-name'])) {

        $username = $_POST['ug-save-name'];
        $email = $_POST['ug-save-email'];
        $user_prefs = $_POST['ug-preferences'];

        if( null == username_exists( $email ) ) {

            // Generate the password and create the user
            $password = wp_generate_password( 12, false );
            $user_id = wp_create_user( $email, $password, $email );

            // Set the nickname
            wp_update_user(
                array(
                    'ID'           =>    $user_id,
                    'nickname'     =>    $username,
                    'display_name' =>    $username
                )
            );

            update_user_meta( $user_id, 'my_ug', $user_prefs );

            // Set the role
            $user = new WP_User( $user_id );
            $user->set_role( 'subscriber' );

            wp_set_auth_cookie($user_id);

            if (isset($_COOKIE['ug_preferences'])) {
                setcookie('ug_preferences', "", time()-3600);
            }

            header('Location:'.home_url());

        }
    }

    // Update user prefs
    if (is_user_logged_in() && isset($_POST['ug-update'])) {
        $str;
        foreach ($_POST as $k => $v) {
            if ($k !== 'ug-update') {
                $str .= $k.'='.$v.'&';
            }
        }
        update_user_meta( get_current_user_id(), 'my_ug', substr($str, 0, -1));
        header('Location:'.home_url());
    }

    // Authenticate user
    if (isset($_POST['ug-login-name'])) {
        $username = $_POST['ug-login-name'];
        $email = $_POST['ug-login-email'];

        if (email_exists($email)) {

            if (isset($_COOKIE['ug_preferences'])) {
                setcookie('ug_preferences', "", time()-3600);
            }

            wp_set_auth_cookie(email_exists($email));
            header('Location:'.home_url());
        }
    }

    // Kick out user
    if (isset($_GET['logmeout'])) {

        if (isset($_COOKIE['ug_preferences'])) {
            setcookie('ug_preferences', "", time()-3600);
        }

        wp_clear_auth_cookie();
        header('Location:'.home_url());
    }

    // Send contact email
    if (isset($_POST['ug-contact-name'])) {
        var_dump(wp_mail( 'krimo.hafsaoui@gmail.com', 'Un message de : '.$_POST['ug-contact-name'], $_POST['ug-contact-message']));
    }
?>
<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <title><?= (is_home()) ? get_bloginfo('name') : ucfirst($pagename) . ' | ' . get_bloginfo('name'); ?></title>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <script src="<?= get_template_directory_uri().'/js/' ?>modernizr.min.js"></script>
</head>

<body class="ug-home ug-page">

    <?php
        /** Promo image plugin display **/
        if (is_home() || is_front_page()) {
            echo ugadbg_display_image();
        }
    ?>

    <div id="top" style="position:absolute;top:0;left:0;width:100%;height:0;"></div>

    <header class="ug-header">
        <a href="#" class="ug-menu-toggle show-for-small icon-menu"></a>

        <div class="row">
            <div class="large-12 columns">
                <hgroup class="logo">
                    <h1 class="ug-title"><a href="<?php bloginfo('url'); ?>"><img src="<?= get_template_directory_uri().'/images/' ?>logo-alt.png" alt="UrbanGirl.fr" class="ug-logo"></a></h1>
                    <h2 class="subheader ug-subheader">Le Webzine Féminin Haut de Gamme</h2>
                </hgroup>

                <?php if (is_user_logged_in()) { ?>
                    <div class="text-center">
                        <a href="#" class="button" data-reveal-id="ug-logged-in-modal">Bonjour <strong><?= ucfirst($current_user->display_name); ?></strong>, accédez à vos préférences &rarr;</a>
                        <small><a href="?logmeout">Se déconnecter</a></small>
                    </div>
                <?php } ?>

                <?php get_template_part('ug-nav'); ?>
            </div>
        </div>

        <?php get_template_part('ug-search-form'); ?>
    </header>
