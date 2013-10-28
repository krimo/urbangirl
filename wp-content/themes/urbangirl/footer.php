    <div class="row">
        <div class="large-12 columns">
            <!-- <ul class="breadcrumbs">
                <li><a href="#">Acceuil</a></li>
                <li><a href="#">Bonnes Adresses</a></li>
                <li><a href="#">Paris</a></li>
            </ul> -->
            <p class="text-center">
                <?php if (function_exists('seomix_content_breadcrumb')) seomix_content_breadcrumb(); ?>
            </p>

        </div>
    </div>

    <footer class="ug-footer">
        <div class="row">
            <div class="large-4 columns">
                <ul class="no-bullet">
                    <li><a href="<?= get_page_link(11026); ?>">Qu'est-ce qu'UrbanGirl.fr ?</a></li>
                    <li><a href="<?= get_page_link(11023); ?>">Contact annonceurs</a></li>
                    <li><a href="<?= get_page_link(11029); ?>">Mentions légales</a></li>
                </ul>

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
            </div>
            <div class="large-4 columns">
                <h4>&copy; UrbanGirl.fr</h4>
                <p>Magazine féminin haut de gamme, UrbanGirl.fr propose des articles pour toutes les femmes, en fonction de leurs préférences et leur style de vie. Ce webzine féminin est le meilleur ami des femmes dynamiques !</p>
            </div>
            <div class="large-4 columns">
                <h4>Inscrivez-vous à la newsletter</h4>
                <form action="#" class="ug-newsletter-form" id="ug-form-newsletter-footer" name="ug-form-newsletter-footer" method="post" data-abide>
                    <div class="row collapse">
                        <div class="small-10 columns">
                            <input type="email" placeholder="Entrez votre e-mail" name="ug-email" required>
                            <small class="error">Email invalide ou vide</small>
                        </div>
                        <div class="small-2 columns">
                            <button type="submit" class="button secondary prefix">&rarr;</button>
                        </div>
                    </div>
                </form>
                <a href="<?= get_page_link('11021'); ?>"><img src="<?= get_template_directory_uri().'/images/' ?>my-ug.png" alt=""></a>
            </div>
        </div>
    </footer>

    <?php if (!is_user_logged_in()) { ?>
    <div id="save-email-modal" class="reveal-modal save-email-modal small">
        <div class="save-email-modal-inner">
            <form action="#" class="custom" id="ug-modal-save-form" method="post" data-abide>
                <div class="row">
                    <div class="large-12 columns">
                        <h4>Enregistrer vos préférences ?</h4>
                        <div class="name-field">
                            <input type="text" placeholder="Entrez votre prénom" name="ug-save-name" required>
                            <small class="error">Le prénom est obligatoire</small>
                        </div>
                        <div class="email-field">
                            <input type="email" placeholder="Entrez votre adresse e-mail" name="ug-save-email" required>
                            <input type="hidden" name="id" value="55904">
                            <small class="error">Une adresse e-mail est necéssaire.</small>
                        </div>
                        <input type="hidden" name="ug-preferences" id="ug-preferences-input" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 columns">
                        <button class="button secondary expand" type="button" id="no-thanks" onclick="$('a.close-reveal-modal').trigger('click');">Non, merci.</button>
                    </div>
                    <div class="large-6 columns">
                        <button class="button expand" type="submit">Oui !</button>
                    </div>
                </div>
                <footer class="row">
                    <div class="large-12 columns">
                        <p class="text-center"><small><strong>Deja inscrite ? <a href="#" data-dropdown="login-drop">identifiez-vous</a> pour retrouver vos preferences !</strong></small></p>
                    </div>
                </footer>
            </form>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <?php } ?>

    <?php if (is_user_logged_in()) { ?>

    <?php if (is_home() || is_front_page()) { ?>
    <div class="ug-panel bottom-page-prompt">
        <p><em>Vous n'avez pas trouvé d'articles à votre goût ? <a href="#" data-reveal-id="ug-logged-in-modal">Modifiez</a> vos préférences !</em></p>
        <a href="#" class="close-prompt">&#215;</a>
    </div>
    <?php } ?>

    <div id="ug-logged-in-modal" class="reveal-modal medium">
        <div class="row">
            <div class="large-6 columns">
                <?php get_template_part( 'ug-personalize' ); ?>
            </div>
            <div class="large-6 columns">
                <h4>Retrouvez vos preferences</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, necessitatibus, vel quas laborum maxime inventore dolore esse sint quis eaque sed recusandae accusantium ratione voluptate porro illum minus facilis dolores.</p>
                <hr>
                <h4>Inscrivez-vous a notre newsletter</h4>
                <form action="#" class="custom" data-abide>
                    <input type="text" placeholder="Votre adresse email">
                    <select name="city" id="city">
                        <option value="0">Indiquez votre ville (si applicable)</option>
                        <option value="lyon">Lyon</option>
                        <option value="paris">Paris</option>
                    </select>
                    <button class="button expand" type="submit">Je m'inscris &rarr;</button>
                </form>
            </div>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    <?php } ?>

    <a href="#top" id="ug-scroll-top-btn">&uarr;</a>

    <?php
        require_once('Mobile_Detect.php');
        $detect = new Mobile_Detect;

        if ($detect->isMobile()) {
            $slidesToDisplay = '1';
        } else {
            (is_category()) ? $slidesToDisplay = '3' : $slidesToDisplay = '2';
        }
    ?>

    <div id="slidesnumber" style="display:none;"><?= $slidesToDisplay; ?></div>
    <div id="authentication" style="display:none;"><?= (is_user_logged_in()) ? '1' : '0'; ?></div>

    <script type="text/javascript">
        var templateDirUri = "<?= get_template_directory_uri() ?>";
    </script>
    <script src="<?= get_template_directory_uri().'/js/vendor/' ?>jquery.js"></script>
    <script src="<?= get_template_directory_uri().'/js/' ?>dependencies.min.js"></script>
    <script src="<?= get_template_directory_uri().'/js/' ?>main.js"></script>
</body>
</html>
