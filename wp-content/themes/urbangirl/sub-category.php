<?php get_header('category'); ?>
<article class="row" role="main">
    <section class="large-8 columns">
        <?= (category_description()) ? category_description() : '<p class="lead">Bienvenue sur la categorie <em>'.single_cat_title('',false).'</em></p>'; ?>

        <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $wp_query = new WP_Query('posts_per_page=15&cat='.get_query_var('cat').'&paged='.$paged);
            // query_posts('posts_per_page=15&cat='.get_query_var('cat').'&paged='.$paged);
            if ( have_posts() ) : while ( have_posts() ) : the_post();
        ?>
        <!-- post -->
        <?php get_template_part('ug-subcat-article'); ?>
        <hr>
        <?php endwhile; wp_reset_query(); ?>
        <!-- post navigation -->
        <?php
            $prev = get_previous_posts_link();
            $next = get_next_posts_link();

            $sitesArray = array(
                get_bloginfo('url').'/actualites' => 'http://urbangirl-actualites.fr',
                get_bloginfo('url').'/mode' => 'http://urbangirl-mode.fr',
                get_bloginfo('url').'/beaute' => 'http://urbangirl-beaute.fr',
                get_bloginfo('url').'/mariage' => 'http://urbangirl-mariage.fr',
                get_bloginfo('url').'/maman' => 'http://urbangirl-maman.fr',
                get_bloginfo('url').'/couple' => 'http://urbangirl-couple.fr',
                get_bloginfo('url').'/gastronomie' => 'http://urbangirl-gastronomie.fr',
                get_bloginfo('url').'/deco' => 'http://urbangirl-decoration.fr',
                get_bloginfo('url').'/bonnes-adresses' => 'http://urbangirl-sorties.fr'
            );

            foreach ($sitesArray as $k => $v) {
                $prev = str_replace($k, $v, $prev);
                $next = str_replace($k, $v, $next);
            }

            $prev = str_replace('<a', '<a class="button secondary"', $prev);
            $next = str_replace('<a', '<a class="button secondary"', $next);

            echo $prev . ' &nbsp; ' . $next;
        ?>
        <?php else: ?>
        <!-- no posts found -->
        <?php endif; ?>
    </section>
    <section class="large-4 columns">
        <?php get_sidebar(); ?>
    </section>
</article>
<?php get_footer(); ?>
