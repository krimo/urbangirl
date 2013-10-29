<?php get_header('single'); ?>
<!-- Main article -->
<article class="row" role="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php ug_set_post_views(get_the_ID()); ?>
    <aside class="large-4 columns hide-for-small">
        <figure>
            <?php
                if (get_the_post_thumbnail()) {
                    echo get_the_post_thumbnail();
                } else {
                    displayBackupImage();
                }
            ?>
            <figcaption><?= (get_post(get_post_thumbnail_id())->post_excerpt) ? get_post(get_post_thumbnail_id())->post_excerpt : the_title('','',false);?></figcaption>
        </figure>
        <a href="<?= get_page_link('11021'); ?>"><img src="<?= get_template_directory_uri().'/images/' ?>my-ug.png" alt=""></a>
        <hr>
        <div id="sticky">
            <h5 class="ug-home-title"><span>Partager cet article</span></h5>
            <ul class="small-block-grid-3 ug-social-list text-center" >
                <li><a href="http://twitter.com/share?url=<?php the_permalink();?>" class="social-link icon-twitter" target="_blank"></a></li>
                <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>" class="social-link icon-facebook"></a></li>
                <li><a href="https://plus.google.com/share?url=<?php the_permalink();?>" class="social-link icon-googleplus"></a></li>
            </ul>
        </div>
    </aside>
    <article class="large-8 columns ug-single-article">
        <header>
            <h1><?php the_title(); ?></h1>
            <p class="ug-article-meta"><em>par</em> <?= ucfirst(get_the_author()); ?> <em>il y a</em> <?= human_time_diff( get_the_time('U'), current_time('timestamp') ); ?> &bull; <?php echo get_the_category_list(", "); ?></p>
        </header>
        <hr>

        <?php the_content(); ?>

        <footer>

        <hr class="home-hr">

            <h4 class="ug-home-title"><span>Partagez cet article</span></h4>
            <section class="row ug-share-article">
                <div class="large-5 columns">
                    <ul class="inline-list">
                        <li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-via="urbangirlco" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a></li>
                        <li>
                            <iframe src="//www.facebook.com/plugins/like.php?href='<?= urlencode(the_permalink()); ?>'&amp;width=The+pixel+width+of+the+plugin&amp;height=65&amp;colorscheme=light&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:65px;" allowTransparency="true"></iframe>
                            <!-- <div class="fb-like" data-href="" data-width="50" data-height="" data-colorscheme="light" data-layout="box_count" data-action="like" data-show-faces="false" data-send="false"></div> -->
                        </li>
                        <li><div class="g-plusone" data-annotation="bubble" data-size="tall" data-width="50" data-lang="fr"></div></li>
                    </ul>
                </div>
                <div class="large-7 columns">
                    <button class="large expand button" data-reveal-id="ug-share-modal">Envoyer cet article à vos amies &rarr;</button>
                </div>
            </section>

            <hr class="home-hr">

            <!-- Afficher l'auteur seulement si une description est présente -->
            <?php if (get_the_author_meta('description')) { ?>
            <div class="panel">
                <div class="row">
                    <div class="large-3 columns">
                        <img src="<?= get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>" alt="">
                    </div>
                    <div class="large-9 columns">
                        <h4>A propos de <?php the_author(); ?></h4>
                        <p class="panel-paragraph"><?php the_author_meta('description'); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <h4 class="ug-home-title"><span>Vous aimerez aussi</span></h4>
            <div class="row">
                <?php
                $args = array( 'posts_per_page' => 2, 'orderby' => 'rand' );
                $rand_posts = get_posts( $args );
                foreach ( $rand_posts as $post ) : setup_postdata( $post ); ?>
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

                        <div class="crop">
                            <?php (has_post_thumbnail() && the_post_thumbnail() !== NULL) ? the_post_thumbnail() : displayBackupImage(); ?>
                        </div>

                        <footer class="ug-panel-inner">
                            <p><em><?= 'il y a '.human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></p>
                            <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                        </footer>
                    </article>
                </div>
                <?php endforeach; wp_reset_postdata();?>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <p><small>Crédits photos : <?= '<a href="'.get_post_meta(get_the_ID(), 'ug-photo-credits', true).'">'.get_post_meta(get_the_ID(), 'ug-photo-credits', true).'</a>'; ?></small></p>
                </div>
            </div>
        </footer>
    </article>
    <?php endwhile; else: ?>
    <p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>
</article>

<div class="ug-panel bottom-page-prompt large">
    <div class="row">
        <div class="large-12 columns">
            <h4>A découvrir sur UrbanGirl</h4>
            <ul class="ug-article-list">
                <?php
                $args = array( 'posts_per_page' => 2, 'orderby' => 'rand', 'meta_key' => 'ug-featured-post', 'meta_value' => '1' );
                $rand_posts = get_posts( $args );
                foreach ( $rand_posts as $post ) : setup_postdata( $post );?>
                    <li>
                        <article class="clearfix">
                            <a href="<?php the_permalink() ?>" class="left picture">
                                <div class="crop crop-small">
                                    <?php (has_post_thumbnail() && the_post_thumbnail() !== NULL) ? the_post_thumbnail() : displayBackupImage(); ?>
                                </div>
                            </a>
                            <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <br><small>publié il y a <em><?=human_time_diff( get_the_time('U'), current_time('timestamp') ); ?></em></small></h5>
                        </article>
                    </li>
                <?php endforeach;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div>
    <a href="#" class="close-prompt">&#215;</a>
</div>

<div id="ug-share-modal" class="reveal-modal medium">
    <div class="row">
        <div class="large-5 columns">
            <img src="<?= get_template_directory_uri().'/images/share-with-friends.jpg' ?>" alt="">
        </div>
        <div class="large-7 columns">
            <h4>Partagez cet article avec vos amies</h4>
            <p>Il vous suffit de renseigner des adresses e-mail separées par une virgule (,)</p>
            <hr>
            <form action="#" method="post" id="ug-share-article-form" data-abide>
                <input type="text" name="share-this-article" placeholder="email1@email.com,email2@email.com..." pattern="^((\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*)*([,])*)*$" required>
                <small class="error">Vous n'avez pas respecté le format.</small>
                <button class="button expand" type="submit">Envoyer &rarr;</button>
            </form>
        </div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>

<?php get_footer(); ?>
