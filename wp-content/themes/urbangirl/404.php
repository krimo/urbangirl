<?php get_header(); ?>
<article class="row" role="main">
	<section class="large-9 columns">
		<h1>404 - Makeup not found.</h1>
		<p><?php var_dump($_SERVER['REQUEST_URI']); ?></p>
        <img src="http://www.cgarena.com/gallery/3d/description/fullimages/gollum_fin2.jpg" alt="">
	</section>
	<section class="large-3 columns">
		<?php get_sidebar(); ?>
	</section>
</article>
<?php get_footer(); ?>
