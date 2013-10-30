<article class="ug-panel">
    <ul class="ug-tag-list">
        <?php
            $post_categories = wp_get_post_categories( $post->ID, array('exclude' => '4029');
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