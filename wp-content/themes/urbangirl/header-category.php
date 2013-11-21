<?php
    $category_slug = is_subcategory() ? get_category(get_category(get_query_var('cat'))->parent)->slug : get_category(get_query_var('cat'))->slug;
    if (in_array($category_slug, array('beaute', 'maman'))) {
        $logo_slug = 'logo-alt-black.png';
    } else {
        $logo_slug = 'logo-alt.png';
    }

    $ugMetaTable = array(
        'mode' => array('Magazine mode féminin','urbangirl-mode.fr est le magazine féminin dédié à la mode et au prêt-à-porter: conseils, astuces look, on vous dit tout !'),
        'beaute' => array('Magazine beauté féminin','Le magazine beauté dédié aux soins beauté, au sport, au bien-être, aux astuces make up et tout ce qui intéresse les femmes !'),
        'gastronomie' => array('Magazine gastronomie vin et cocktails','Le magazine Urban Girl dédié à la gastronomie et aux recettes tendances présente quotidiennement des articles sur les meilleurs produits et les recettes de coktails du moment'),
        'deco' => array('Magazine de décoration d\'intérieur','Le magazine Urban Girl spécialisé dans l\'aménagement intérieur et extérieur propose chaque jour des articles sur la décoration et les tendances du moment'),
        'maman' => array('Magazine maman et enfants','Le magazine Maman Urban Girl propose des articles pour les mamans et futures mamans: grossesses, bébé, enfants et adolescents'),
        'mariage' => array('Magazine mariage','Le magazine mariage Urban Girl s\'adresse aux futures mariées à la recherche d\'informations pour l\'organisation du mariage, les tendances robes et accessoires, et toutes les actus mariage'),
        'couple' => array('Magazine couple séduction et amour','Le magazine Urban Girl dédié au couple propose chaque semaine des conseils pour les relations de couple mais aussi pour les célibataires'),
        'actualites' => array('Magazine d\'actualités pour les femmes','Le magazine Urbangirl Actualités propose des bons plans, bonnes adresses, actualités technologie et tout ce qui intéresse les femmes !'),
        'bonnes-adresses' => array('Guide des sorties à Paris, Lyon et Marseille','Les meilleures adresses à Paris, Lyon et Marseille sont présentées sur le magazine des sorties UrbanGirl.')
    );

    $ugPageTitle = $ugMetaTable[$category_slug][0];
    $ugMetaDesc = $ugMetaTable[$category_slug][1];
?>
<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <script>!function(a,b,c,d,e){function g(a,c,d,e){var f=b.getElementsByTagName("script")[0];a.src=e,a.id=c,a.setAttribute("class",d),f.parentNode.insertBefore(a,f)}a.Mobify={points:[+new Date]};var f=/((; )|#|&|^)mobify=(\d)/.exec(location.hash+"; "+b.cookie);if(f&&f[3]){if(!+f[3])return}else if(!c())return;b.write('<plaintext style="display:none">'),setTimeout(function(){var c=a.Mobify=a.Mobify||{};c.capturing=!0;var f=b.createElement("script"),h="mobify",i=function(){var c=new Date;c.setTime(c.getTime()+3e5),b.cookie="mobify=0; expires="+c.toGMTString()+"; path=/",a.location=a.location.href};f.onload=function(){if(e)if("string"==typeof e){var c=b.createElement("script");c.onerror=i,g(c,"main-executable",h,mainUrl)}else a.Mobify.mainExecutable=e.toString(),e()},f.onerror=i,g(f,"mobify-js",h,d)})}(window,document,function(){var a=/webkit|msie\s10|(firefox)[\/\s](\d+)|(opera)[\s\S]*version[\/\s](\d+)|3ds/i.exec(navigator.userAgent);return a?a[1]&&+a[2]<4?!1:a[3]&&+a[4]<11?!1:!0:!1},

// path to mobify.js
"//cdn.mobify.com/mobifyjs/build/mobify-2.0.0.min.js",

// calls to APIs go here
function() {
  var capturing = window.Mobify && window.Mobify.capturing || false;

  if (capturing) {
    Mobify.Capture.init(function(capture){
      var capturedDoc = capture.capturedDoc;

      var images = capturedDoc.querySelectorAll("img, picture");
      Mobify.ResizeImages.resize(images);
        
      // Render source DOM to document
      capture.renderCapturedDoc();
    });
  }
});
</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?= $ugPageTitle; ?> | <?php bloginfo('name'); ?></title>
    <meta name="description" content="<?= $ugMetaDesc; ?>">

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <script src="<?= get_template_directory_uri().'/js/' ?>modernizr.min.js"></script>

</head>

<body class="ug-category ug-page ug-<?= is_subcategory() ? get_category(get_category(get_query_var('cat'))->parent)->slug : get_category(get_query_var('cat'))->slug; ?>">

    <div id="top" style="position:absolute;top:0;left:0;width:100%;height:0;"></div>

    <header class="ug-header">
        <a href="#" class="ug-menu-toggle show-for-small icon-menu"></a>

        <div class="row">
            <div class="large-12 columns ug-category-bg">
                <hgroup class="logo">
                    <h1 class="ug-title"><a href="<?php bloginfo('url'); ?>"><img src="<?= get_template_directory_uri().'/images/'.$logo_slug ?>" alt="UrbanGirl.fr"></a> <span class="ug-category-title"><a href="<?= get_category_link(get_category(get_query_var('cat'))->cat_ID); ?>"><?php single_cat_title(); ?></a></span></h1>
                    <h2 class="subheader ug-subheader">Le Webzine Féminin Haut de Gamme</h2>
                </hgroup>

                <?php get_template_part('ug-nav'); ?>
            </div>
        </div>

        <?php if(is_category()) { ?>
        <nav class="ug-category-subnav">
            <div class="row">
                <div class="large-12 columns">
                    <ul class="inline-list">
                        <li class="ug-category-subnav-title"><h5><?= (!is_subcategory()) ? get_category(get_query_var('cat'))->name : get_category(get_category(get_query_var('cat'))->parent)->name; ?> :</h5></li>
                        <?php
                            if (!is_subcategory()) {
                                foreach (get_categories('child_of='.get_category(get_query_var('cat'))->cat_ID) as $cat) {
                                    echo '<li><a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></li>';
                                }
                            } else {
                                $selfCategoryId = get_category(get_query_var('cat'))->cat_ID;
                                foreach (get_categories('child_of='.get_category(get_category(get_query_var('cat'))->parent)->cat_ID.'&hide_empty=0') as $cat) {
                                    if ($selfCategoryId === $cat->cat_ID) {
                                        echo '<li><a class="active" href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></li>';
                                    } else {
                                        echo '<li><a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></li>';
                                    }
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php } ?>

        <?php get_template_part('ug-search-form'); ?>
    </header>
