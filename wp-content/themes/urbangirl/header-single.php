<?php
    $category_slug = get_the_category()[0]->slug;

    $cslug = is_subcategory() ? get_category(get_category(get_query_var('cat'))->parent)->slug : get_category(get_query_var('cat'))->slug;

    if (in_array($category_slug, array('beaute', 'maman'))) {
        $logo_slug = 'logo-alt-black.png';
    } else {
        $logo_slug = 'logo-alt.png';
    }

    $ugMetaTable = array(
        'mode' => array('urbangirl-mode.fr','urbangirl-mode.fr est le magazine féminin dédié à la mode et au prêt-à-porter: conseils, astuces look, on vous dit tout !'),
        'beaute' => array('urbangirl-beaute.fr','Le magazine beauté dédié aux soins beauté, au sport, au bien-être, aux astuces make up et tout ce qui intéresse les femmes !'),
        'gastronomie' => array('urbangirl-gastronomie.fr','Le magazine Urban Girl dédié à la gastronomie et aux recettes tendances présente quotidiennement des articles sur les meilleurs produits et les recettes de coktails du moment'),
        'deco' => array('urbangirl-deco.fr','Le magazine Urban Girl spécialisé dans l\'aménagement intérieur et extérieur propose chaque jour des articles sur la décoration et les tendances du moment'),
        'maman' => array('urbangirl-maman.fr','Le magazine Maman Urban Girl propose des articles pour les mamans et futures mamans: grossesses, bébé, enfants et adolescents'),
        'mariage' => array('urbangirl-mariage.fr','Le magazine mariage Urban Girl s\'adresse aux futures mariées à la recherche d\'informations pour l\'organisation du mariage, les tendances robes et accessoires, et toutes les actus mariage'),
        'couple' => array('urbangirl-couple.fr','Le magazine Urban Girl dédié au couple propose chaque semaine des conseils pour les relations de couple mais aussi pour les célibataires'),
        'actualites' => array('urbangirl-actualites.fr','Le magazine Urbangirl Actualités propose des bons plans, bonnes adresses, actualités technologie et tout ce qui intéresse les femmes !'),
        'bonnes-adresses' => array('urbangirl-sorties.fr','Les meilleures adresses à Paris, Lyon et Marseille sont présentées sur le magazine des sorties UrbanGirl.')
    );

    $ugPageTitle = $ugMetaTable[$cslug][0];
    $ugMetaDesc = $ugMetaTable[$cslug][1];
?>
<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta property="og:image" content="<?= (has_post_thumbnail()) ? wp_get_attachment_thumb_url(get_post_thumbnail_id()) : displayBackupImage(true); ?>" />

    <title><?php the_title(); ?> | <?= $ugPageTitle; ?></title>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <script src="<?= get_template_directory_uri().'/js/' ?>modernizr.min.js"></script>

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
