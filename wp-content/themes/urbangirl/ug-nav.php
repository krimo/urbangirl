<nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
    <div class="cbp-hsinner">
        <ul class="cbp-hsmenu">
            <li><a href="<?php bloginfo('url'); ?>" class="icon-home tip-top" data-tooltip data-options="disable-for-touch:true" title="Revenir à la page d'accueil"></a></li>
            <?php if(!is_user_logged_in()) { ?>
            <li><a href="<?= get_page_link('10938'); ?>" class="icon-user tip-top" data-tooltip data-options="disable-for-touch:true" title="Vos mesures"></a></li>
            <?php } ?>

            <?php
                $categories = get_categories('exclude=1');

                foreach ($categories as $c) { if ($c->parent == '0') {
            ?>
            <li>
                <?php
                    echo '<a href="'.get_category_link($c->cat_ID).'">'.$c->name.'</a>';
                    
                    $subCategories = get_categories('child_of='.$c->cat_ID.'&hide_empty=0');

                    if ($subCategories) {
                ?>
                <div class="cbp-hssubmenu">
                    <div class="ug-inner-submenu">
                        <div class="row">
                            <div class="large-4 columns">
                                <ul class="ug-menu-list">
                                    <?php
                                        foreach ($subCategories as $subCat) {
                                            if ($subCat->count >= 1 ) {
                                                echo '<li><a href="'.get_category_link($subCat->cat_ID).'">'.$subCat->name.'</a></li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="large-8 columns">
                                <div class="row">
                                    <?php
                                        $my_query = new WP_Query('category_name='.$c->slug.'&posts_per_page=2');
                                        while ($my_query->have_posts()) : $my_query->the_post();
                                    ?>

                                    <div class="large-6 columns">
                                    <article class="ug-panel">
                                        <ul class="ug-tag-list">
                                            <?php
                                                $post_categories = wp_get_post_categories( $post->ID );
                                                foreach ($post_categories as $theCat) {
                                                    echo '<li><a href="'.get_category_link( get_cat_ID(get_category($theCat)->name) ).'">'.get_category( $theCat )->name.'</a></li>';
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

                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </li>
            <?php }} ?>
        </ul>
    </div>
</nav>
