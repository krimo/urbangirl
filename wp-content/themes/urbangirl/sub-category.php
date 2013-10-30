<?php get_header('category'); ?>
<article class="row" role="main">
    <section class="large-8 columns">
        <?= (category_description()) ? category_description() : '<p class="lead">Bienvenue sur la categorie '.single_cat_title('',false).'</p>'; ?>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- post -->
        <article class="clearfix ug-subcategory-article">
        	<div class="crop left">
	            <a href="<?php the_permalink(); ?>" class="picture">
	                <?php (has_post_thumbnail() && the_post_thumbnail() !== NULL) ? the_post_thumbnail() : displayBackupImage(); ?>
	            </a>
            </div>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br><small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small></h3>
        </article>
        <hr>
        <?php endwhile; ?>
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
                get_bloginfo('url').'/bonnes-adresses' => 'http://urbangirl-sorties.fr',
                get_bloginfo('url').'/non-classe' => 'http://96.30.54.222/~urbangi/non-classe',
            );

            foreach ($sitesArray as $k => $v) {
                $prev = str_replace($k, $v, $prev);
                $next = str_replace($k, $v, $next);
            }

            echo $prev . ' &bull; ' . $next;
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
