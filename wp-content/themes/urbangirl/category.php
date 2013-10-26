<?php get_header('category'); ?>

<!-- Main section -->
<article role="main">
    <section class="row">
        <div class="large-12 columns">
            <h4 class="ug-home-title"><span>Les Derniers Articles</span></h4>
            <div class="swiper-outer">
                <a href="#" class="swiper-nav swiper-prev" onclick="globalSwiper.swipePrev();">&lsaquo;</a>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="swiper-slide">
                            <article class="ug-panel">
                                <ul class="ug-tag-list">
                                    <?php
                                        $post_categories = wp_get_post_categories( $post->ID );
                                        foreach ($post_categories as $c) {
                                            echo '<li><a href="'.get_category_link( get_cat_ID(get_category( $c )->name) ).'">'.get_category( $c )->name.'</a></li>';
                                        }
                                    ?>
                                </ul>

                                <div class="crop">
                                    <?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
                                </div>

                                <footer class="ug-panel-inner">
                                    <p><em><?= 'il y a '.human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></p>
                                    <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                                </footer>
                            </article>
                        </div>
                        <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="#" class="swiper-nav swiper-next" onclick="globalSwiper.swipeNext();">&rsaquo;</a>
            </div>
            <hr class="home-hr">
        </div>
    </section>

    <section class="row">
        <div class="large-8 columns">
            <div class="row">
                <?php
                $categories = get_categories('child_of='.get_category(get_query_var('cat'))->cat_ID.'&number=2');
                foreach ($categories as $cat) { ?>
                <div class="large-6 columns">
                    <h4 class="ug-home-title"><span><?=$cat->name;?></span></h4>
                    <ul class="ug-article-list">

                        <?php
                            $args = array(
                                'post_type' => 'post',
                                'category_name' => $cat->slug,
                                'posts_per_page' => 3
                            );
                            $query = new WP_Query($args);
                            while ($query->have_posts()) : $query->the_post();
                        ?>

                        <li>
                            <article class="clearfix">
                                <a href="<?php the_permalink(); ?>" class="left picture">
                                    <div class="crop crop-small">
                                        <?php (has_post_thumbnail()) ? the_post_thumbnail() : displayBackupImage(); ?>
                                    </div>
                                </a>
                                <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <br><small>publié il y a <em><?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small></h5>
                            </article>
                        </li>

                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <div class="section-container tabs" data-section="tabs">
                        <?php
                        $categories = get_categories('child_of='.get_category(get_query_var('cat'))->cat_ID);
                        foreach ($categories as $cat) { if ($cat->count >= 2) { ?>
                        <section>
                            <p class="title" data-section-title><a href="#"><?=$cat->name;?></a></p>
                            <div class="content" data-section-content>
                                <div class="row">
                                    <?php
                                        $args = array(
                                            'post_type' => 'post',
                                            'category_name' => $cat->slug,
                                            'posts_per_page' => 2
                                        );
                                        $query = new WP_Query($args);
                                        while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <div class="large-6 columns">
                                        <article class="ug-panel">
                                            <ul class="ug-tag-list">
                                                <?php
                                                    $post_categories = wp_get_post_categories( $post->ID );
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
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </section>
                        <?php }} ?>
                    </div>
                </div>
            </div>
            <section class="category-intro">
                <div class="row">
                    <hr class="home-hr">
                    <div class="large-3 columns">
                        <img src="<?= get_template_directory_uri().'/images/' ?>category-img.png" alt="beauty">
                    </div>
                    <div class="large-9 columns">
                        <div class="ug-category-description">
                            <?= (category_description()) ? category_description() : '<p class="lead">Bienvenue sur la categorie '.single_cat_title('',false).'</p>'; ?>
                        </div>
                        <div class="ug-category-read-more"><button class="ug-button-inverse medium">+</button></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="large-4 columns">
            <?php get_sidebar(); ?>
        </div>
    </section>
</article>

<?php get_footer(); ?>