<aside class="ug-sidebar">
	<p class="lead text-center"><em>Recevez nos bons plans secrets !</em></p>
	<form action="#" class="ug-newsletter-form" id="ug-form-newsletter-sidebar" name="ug-form-newsletter-sidebar" method="post" data-abide>
		<div class="row collapse">
			<div class="small-10 columns">
				<input type="email" placeholder="Entrez votre e-mail" name="ug-email" required>
                <input type="hidden" name="id" value="55904">
				<small class="error">Email invalide ou vide</small>
			</div>
			<div class="small-2 columns">
				<button type="submit" class="button secondary prefix">&rarr;</button>
			</div>
		</div>
	</form>
	<p class="no-spam-description"><small class="ug-color">Gratuit et un seul mail tous les 10 jours !</small></p>
	<div data-alert class="alert-box ug-form-alert">
		<span></span>
		<a href="#" class="close">&times;</a>
	</div>
	<hr>
	<a href="http://journalduluxe.fr"><img src="<?= get_template_directory_uri() . '/images/pub.jpg' ?>" alt=""></a>
	<?php (is_active_sidebar('sidebar-1')) ? dynamic_sidebar( 'sidebar-1' ) : ''; ?>
	<hr>
	<h4>Suivez UrbanGirl</h4>
	<ul class="small-block-grid-3 ug-social-list text-center">
		<li>
			<a href="https://twitter.com/intent/user?screen_name=urbangirlco" class="social-link icon-twitter"></a>
			<p><em class="twitter-share-count"><?= twitter_count(); ?></em></p>
		</li>
		<li>
			<a href="http://www.facebook.com/urbangirlfr" class="social-link icon-facebook"></a>
			<p><em class="facebook-share-count"><?= fb_count(); ?></em></p>
		</li>
		<li>
			<a href="https://plus.google.com/share?url=http%3A%2F%2Furbangirl.fr" class="social-link icon-google-plus"></a>
			<p><em class="google-share-count"><?= gplus_count(); ?></em></p>
		</li>
	</ul>
	<hr>
	<script src="http://widget.hellocoton.fr/friends/urbangirl/250px" type="text/javascript" async></script>
	<hr>
	<h4>Annonceurs</h4>
	<p>Cliquez <a href="<?= get_page_link(get_page_by_title( 'contact' )->ID); ?>">ici</a> pour nous contacter.</p>
    <hr>
    <h4>Les derniers articles</h4>
    <ul class="no-bullet ug-article-list">
        <?php
            $args = (isset($categories_to_display)) ? array('post_type' => 'post', 'include' => $categories_to_display, 'posts_per_page' => 15) : array('post_type' => 'post', 'posts_per_page' => 15);
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
    <hr>
    <img src="http://dummyimage.com/300x300/222/ffffff.png&text=votre+pub+ici" alt="">
</aside>
