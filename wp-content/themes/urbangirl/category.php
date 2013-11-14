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
                            <?php get_template_part('ug-article-panel'); ?>
                        </div>
                        <?php endwhile; else: ?>
                        <p><?php _e('Pas d\'articles ici...'); ?></p>
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
                $categories = get_categories('child_of='.get_category(get_query_var('cat'))->cat_ID);
                $displayedCats = array();
                $i = 0;
                foreach ($categories as $cat) { if ($cat->count >= 1 && $i<2) {
                    $i++;
                    array_push($displayedCats, $cat->cat_ID);
                ?>
                <div class="large-6 columns">
                    <h4 class="ug-home-title"><span><a href="<?= get_category_link($cat); ?>"><?=$cat->name;?></a></span></h4>
                    <ul class="ug-article-list">

                        <?php
                            $args = array(
                                'post_type' => 'post',
                                'category_name' => $cat->slug,
                                'posts_per_page' => 6
                            );
                            $query = new WP_Query($args);
                            while ($query->have_posts()) : $query->the_post();
                        ?>

                        <li>
                            <?php get_template_part('ug-article-small'); ?>
                        </li>

                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php } } ?>
            </div>
            <hr class="home-hr">
            <div class="row">
                <?php foreach ($categories as $cat) { if ($cat->count >= 1 && $i>=2 && $i<4 && !in_array($cat->cat_ID, $displayedCats)) { $i++; ?>
                <div class="large-6 columns">
                    <h4 class="ug-home-title"><span><a href="<?= get_category_link($cat); ?>"><?=$cat->name;?></a></span></h4>
                    <ul class="ug-article-list">

                        <?php
                            $args = array(
                                'post_type' => 'post',
                                'category_name' => $cat->slug,
                                'posts_per_page' => 6
                            );
                            $query = new WP_Query($args);
                            while ($query->have_posts()) : $query->the_post();
                        ?>

                        <li>
                            <?php get_template_part('ug-article-small'); ?>
                        </li>

                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php } } ?>
            </div>
            <hr class="home-hr">
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
                                        <?php get_template_part('ug-article-panel') ?>
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
                        <img src="<?= get_template_directory_uri().'/images/' ?>category-img.png" alt="Bienvenue sur la categorie <?php single_cat_title('',false); ?>" class="hide-for-small">
                    </div>
                    <div class="large-9 columns">
                        <div class="ug-category-description">
                            <?= (category_description()) ? category_description() : '<p class="lead">Bienvenue sur la categorie '.single_cat_title('',false).'</p>'; ?>
                        </div>
                        <div class="ug-category-read-more"><button class="ug-button-inverse medium">+</button></div>
                    </div>
                </div>
            </section>
            <hr class="home-hr show-for-small">
        </div>
        <div class="large-4 columns">
            <?php get_sidebar(); ?>
        </div>
    </section>
</article>

<?php get_footer(); ?>
