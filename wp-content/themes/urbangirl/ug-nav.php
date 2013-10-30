<nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
    <div class="cbp-hsinner">
        <ul class="cbp-hsmenu">
            <li class="ug-menu-icon"><a href="<?php bloginfo('url'); ?>" class="icon-house tip-top" data-tooltip data-options="disable-for-touch:true" title="Revenir à la page d'accueil"></a></li>
            <?php if(!is_user_logged_in()) { ?>
            <li class="ug-menu-icon"><a href="<?= get_page_link('10938'); ?>" class="icon-user tip-top" data-tooltip data-options="disable-for-touch:true" title="Vos mesures"></a></li>
            <?php } ?>

            <?php
                $categories = get_categories('exclude=1,4029');

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
                                        <?php //get_template_part('ug-article-panel'); ?>
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
