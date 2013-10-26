<?php
/*
Template Name: My Ug
*/
get_header(); ?>
<article class="row" role="main">
	<section class="large-5 columns">
		<?php get_template_part( 'ug-personalize' ); ?>
	</section>
	<section class="large-7 columns">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
		<!-- post navigation -->
		<?php else: ?>
		<p class="lead">Pas de contenu.</p>
		<?php endif; ?>
	</section>
</article>
<?php get_footer(); ?>
