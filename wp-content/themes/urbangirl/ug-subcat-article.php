<article class="clearfix ug-subcategory-article">
	<div class="crop left">
        <a href="<?php the_permalink(); ?>" class="picture">
            <?php (has_post_thumbnail() && the_post_thumbnail() !== NULL) ? the_post_thumbnail() : displayBackupImage(); ?>
        </a>
    </div>
    <h3>
    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
        <?php if (!is_old_post()) { ?>
    	<small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small>
        <?php } ?>
    </h3>
</article>