<?php get_header(); ?>
<article class="row" role="main">
	<section class="large-9 columns">
		<h2>Resultat de la recherche pour <span class="ug-color"><?=$_GET['s']?></span></h2>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- post -->

        <article class="clearfix ug-subcategory-article">
        	<div class="crop left">
	            <a href="<?php the_permalink(); ?>" class="picture">
	                <?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
	            </a>
            </div>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br><small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small></h3>
        </article>
        <hr>
        <?php endwhile; ?>
        <!-- post navigation -->
        <?php else: ?>
        <!-- no posts found -->
        <p class="lead">Pas de resultats pour <strong><?=$_GET['s']?></strong></p>
        <?php endif; ?>
	</section>
	<section class="large-3 columns">
		<?php get_sidebar(); ?>
	</section>
</article>
<?php get_footer(); ?>
