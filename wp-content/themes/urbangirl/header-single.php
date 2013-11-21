<?php
    $category_slug = get_the_category()[0]->slug;
    if (in_array($category_slug, array('beaute', 'maman'))) {
        $logo_slug = 'logo-alt-black.png';
    } else {
        $logo_slug = 'logo-alt.png';
    }
?>
<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta property="og:image" content="<?= (has_post_thumbnail()) ? wp_get_attachment_thumb_url(get_post_thumbnail_id()) : displayBackupImage(true); ?>" />
    <meta property="og:description" content="<?php the_excerpt(); ?>" />

    <title><?php the_title(); ?> | <?php bloginfo('name'); ?></title>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <script src="<?= get_template_directory_uri().'/js/' ?>modernizr.min.js"></script>

    <?php wp_head(); ?>
</head>
<?php
    $chooseCat = array();
    foreach (get_the_category() as $c) {
        array_push($chooseCat, $c->term_id);
    }

    if (sizeof($chooseCat) > 0) {
        $chooseCatId = min($chooseCat);

        $theSlug = (get_category($chooseCatId)->category_parent > 0) ? get_category(get_category($chooseCatId)->parent)->slug : get_category($chooseCatId)->slug;
        $theName = get_category($chooseCatId)->name;   
    }
?>
<body class="ug-category ug-page ug-<?= $theSlug; ?>">

    <div id="top" style="position:absolute;top:0;left:0;width:100%;height:0;"></div>

    <header class="ug-header">
        <a href="#" class="ug-menu-toggle show-for-small icon-menu"></a>

        <div class="row">
            <div class="large-12 columns ug-category-bg">
                <hgroup class="logo">
                    <h1 class="ug-title"><a href="<?php bloginfo('url'); ?>"><img src="<?= get_template_directory_uri().'/images/'.$logo_slug ?>" alt="UrbanGirl.fr"></a> <span class="ug-category-title"><a href="<?= get_category_link(get_the_category()[0]->cat_ID); ?>"><?= $theName; ?></a></span></h1>
                    <h2 class="subheader ug-subheader">Le Webzine Féminin Haut de Gamme</h2>
                </hgroup>

                <?php get_template_part('ug-nav'); ?>
            </div>
        </div>

        <?php get_template_part('ug-search-form'); ?>
    </header>
