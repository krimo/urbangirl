<?php get_header(); ?>
<!-- Main article -->
<article class="row" role="main">
	<div class="large-9 columns">
		<?php if (!is_user_logged_in()) { ?>
		<section class="home-section row">
			<div class="large-7 columns">
                <?php get_template_part( 'ug-personalize' ); ?>
				<hr>
				<p>Parce que nous n'avons pas le temps de perdre du temps, UrbanGirl vous propose une navigation innovante et sur-mesure. Indiquez-nous votre profil grâce aux indications ci-dessus, puis naviguez à votre gré !</p>
			</div>
			<div class="large-5 columns">
				<h4 class="ug-home-title"><span>Articles du jour</span></h4>
					<?php
						$args = array(
							'post_type' => 'post',
                            'include' => $categories_to_display,
							'posts_per_page' => 3
						);
						$query = new WP_Query($args);
						$i = 1;
						while ($query->have_posts()) : $query->the_post();
					?>

					<article class="ug-panel">
						<ul class="ug-tag-list">
							<?php
								$post_categories = wp_get_post_categories( $post->ID, array('exclude' => '4029') );
								foreach ($post_categories as $c) {
									echo '<li><a href="'.get_category_link( get_cat_ID(get_category( $c )->name) ).'">'.get_category( $c )->name.'</a></li>';
								}
							?>
						</ul>

						<div class="crop">
						<?php (has_post_thumbnail() && the_post_thumbnail() !== NULL) ? the_post_thumbnail() : displayBackupImage(); ?>
						</div>

						<footer class="ug-panel-inner">
							<p><em><?= 'il y a '.human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></p>
							<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
						</footer>
					</article>
					<?php if ($i !== 3) { ?>
					<hr>
					<?php } $i++; ?>
					<?php endwhile; ?>
			</div>
		</section>
		<hr class="home-hr">
		<?php } ?>

		<section class="home-section row" id="custom-content-begin">
			<div class="large-12 columns">
				<h3 class="ug-home-title"><span>Les Articles les Plus Lus</span></h3>
				<div class="swiper-outer">
					<a href="#" class="swiper-nav swiper-prev">&lsaquo;</a>
					<div class="ug-panel">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php
                                    if (isset($categories_to_display)) {
                                        $args = array('post_type' => 'post','posts_per_page' => 5, 'cat' => $categories_to_display,'meta_key' => 'ug_post_views_count', 'orderby' => 'meta_value_num');
                                    } else {
                                        $args = array('post_type' => 'post','posts_per_page' => 5,'meta_key' => 'ug_post_views_count', 'orderby' => 'meta_value_num');
                                    }
									$query = new WP_Query($args);
									while ($query->have_posts()) : $query->the_post();
								?>
								<div class="swiper-slide">
									<div class="crop">
										<?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
									</div>

									<div class="home-slider-caption">
										<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
										<p><?php the_excerpt(); ?> <br> <a href="<?php echo get_permalink(); ?>">Lire l'article &raquo;</a></p>
									</div>
								</div>
								<?php endwhile; ?>
							</div>
						</div>
					</div>
					<a href="#" class="swiper-nav swiper-next">&rsaquo;</a>
				</div>
			</div>
		</section>

		<hr class="home-hr">

		<?php

		$categories = (isset($categories_to_display) && $categories_to_display !== 'all') ? get_categories('include='.$categories_to_display) : get_categories();

		foreach ($categories as $cat) { if ($cat->count >= 4 && $cat->parent == '0') { ?>
		<section class="home-section row">
			<div class="large-12 columns">
				<h3 class="ug-home-title"><span><a href="<?= get_category_link($cat); ?>"><?= (is_user_logged_in()) ? 'Vos articles '.$cat->name : $cat->name;?></a></span></h3>
				<div class="row">
					<div class="large-6 columns">
						<?php
							$args = array(
								'post_type' => 'post',
								'category_name' => $cat->slug,
								'posts_per_page' => 1
							);
							$query = new WP_Query($args);
							while ($query->have_posts()) : $query->the_post();
						?>
						<article class="ug-panel">
							<ul class="ug-tag-list">
								<?php
									$post_categories = wp_get_post_categories( $post->ID, array('exclude' => '4029') );
									foreach ($post_categories as $c) {
										echo '<li><a href="'.get_category_link( get_cat_ID(get_category( $c )->name) ).'">'.get_category( $c )->name.'</a></li>';
									}
								?>
							</ul>

							<div class="crop crop-large">
							<?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
							</div>

							<footer class="ug-panel-inner">
								<p><em><?= 'il y a '.human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></p>
								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							</footer>
						</article>
						<?php endwhile; ?>
					</div>
					<div class="large-6 columns">
						<ul class="ug-article-list">
							<?php
								$args = array(
									'post_type' => 'post',
									'category_name' => $cat->slug,
									'posts_per_page' => 3,
									'offset' => 1
								);
								$query = new WP_Query($args);
								while ($query->have_posts()) : $query->the_post();
							?>
							<li>
								<article class="clearfix">
                                        <a href="<?php echo get_permalink(); ?>" class="left picture">
                                            <div class="crop crop-small">
                                                <?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
                                            </div>
                                        </a>
									<h5><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a> <br><small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small></h5>
								</article>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<hr class="home-hr">
		<?php }} ?>

	</div>
	<div class="large-3 columns">
		<?php get_sidebar(); ?>
	</div>
</article>
<?php get_footer(); ?>
