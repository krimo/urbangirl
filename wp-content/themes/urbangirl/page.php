<?php get_header(); ?>
<article class="row" role="main">
	<section class="large-9 columns">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
		<!-- post navigation -->
		<?php else: ?>
		<p class="lead">Pas de contenu.</p>
		<?php endif; ?>
	</section>
	<section class="large-3 columns">
		<?php get_sidebar(); ?>
	</section>
</article>
<?php get_footer(); ?>