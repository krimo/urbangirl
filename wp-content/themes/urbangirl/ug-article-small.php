<article class="clearfix">
    <a href="<?php the_permalink(); ?>" class="left picture">
        <div class="crop crop-small">
            <?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
        </div>
    </a>
    <h5>
    	<a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br>
    	<small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small>
    </h5>
</article>