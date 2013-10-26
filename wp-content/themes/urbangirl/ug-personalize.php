<article class="ug-personalization-module">
	<header>
		<img src="<?= get_template_directory_uri().'/images/' ?>my-ug-header.png" alt="">
	</header>
	<section class="ug-personalization-inner">
		<p>Dites-nous qui vous êtes, nous vous proposerons des articles qui correspondent à vos intérêts.</p>
		<?php if (is_user_logged_in()) { ?>
			<div class="ug-personalization-data" style="display:none"><?= get_user_meta(get_current_user_id(), 'my_ug', true); ?></div>
		<?php } else if (isset($_COOKIE['ug_preferences'])) { ?>
			<div class="ug-personalization-data" style="display:none;"><?= $_COOKIE['ug_preferences']; ?></div>
		<?php } ?>
		<form action="#" class="ug-personalization-form" method="post">
			<ul class="no-bullet">
				<li class="clearfix">
					<label class="switch-btn-label" for="gourmande-switch">Gourmande &amp; Gastronome</label>
					<input type="checkbox" class="ug-switch-btn" name="gourmande-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Romantique</label>
					<input type="checkbox" class="ug-switch-btn" name="romantique-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Geekette</label>
					<input type="checkbox" class="ug-switch-btn" name="geekette-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Sportive</label>
					<input type="checkbox" class="ug-switch-btn" name="sportive-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Maman</label>
					<input type="checkbox" class="ug-switch-btn" name="maman-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Fashion-addict</label>
					<input type="checkbox" class="ug-switch-btn" name="fashion-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Beauty-addict</label>
					<input type="checkbox" class="ug-switch-btn" name="beauty-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Attentive a sa ligne</label>
					<input type="checkbox" class="ug-switch-btn" name="weight-switch">
				</li>
				<li class="clearfix">
					<label class="switch-btn-label">Bon plans / sorties</label>
					<input type="checkbox" class="ug-switch-btn" name="deals-switch">
				</li>
				<li class="clearfix">
					<button class="button medium left expand" <?= (is_user_logged_in()) ? 'type="submit"' : 'type="button" data-reveal-id="save-email-modal"'; ?> name="ug-update"><?= (is_user_logged_in()) ? 'Modifier' : 'Et voilà !' ?> &rarr;</button>
				</li>
			</ul>
			<?php if (is_user_logged_in()) { ?>
			<input type="hidden" name="ug-update" value="1">
			<?php } else { ?>
			<input type="hidden" name="ug-update-blank" value="1">
			<?php } ?>
		</form>
	</section>
	<footer>
		<?php if (!is_user_logged_in()) { ?>
		<p class="text-center"><small><strong>Deja inscrite ? <a href="#" data-dropdown="login-drop">identifiez-vous</a> pour retrouver vos preferences !</strong></small></p>
		<div id="login-drop" class="f-dropdown small content" data-dropdown-content>
			<div class="row">
				<div class="large-12 columns">
					<form action="#" id="ug-login-form" data-abide method="post">
						<div class="name-field">
							<input type="text" placeholder="Votre prénom" name="ug-login-name" required>
							<small class="error">Merci d'entrer votre prénom</small>
						</div>
						<div class="email-field">
							<input type="email" placeholder="Votre adresse email" name="ug-login-email" required>
							<small class="error">Merci d'entrer une adresse e-mail valide</small>
						</div>
						<button class="button expand" type="submit">Vos mesures &rarr;</button>
					</form>
				</div>
			</div>
		</div>
		<?php } else { ?>
		<p class="text-center"><small><em>Vous pouvez modifier vos préférences à tout moment.</em></small></p>
		<?php } ?>
	</footer>
</article>
