<?php get_header(); ?>
<article class="row" role="main">
	<section class="large-8 columns">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
		<!-- post navigation -->
		<?php else: ?>
		<p class="lead">Pas de contenu.</p>
		<?php endif; ?>

        <div class="ajax-message"></div>

		<form data-abide class="ug-contact-form" method="post" action="#">
			<div class="name-field">
				<label>Nom complet <small>obligatoire</small></label>
				<input type="text" name="ug-contact-name" required pattern="[a-zA-Z]+">
				<small class="error">Ce champ est requis et doit être une chaîne de caractères.</small>
			</div>
			<div class="row">
				<div class="large-6 columns">
					<div class="email-field">
						<label>E-mail <small>obligatoire</small></label>
						<input type="email" name="ug-contact-email" required>
						<small class="error">Une adresse e-mail est necessaire.</small>
					</div>
				</div>
				<div class="large-6 columns">
					<div class="url-field">
						<label>Site web</label>
						<input type="url" name="ug-contact-url">
						<small class="error">URL invalide.</small>
					</div>
				</div>
			</div>
			<div class="subject-field">
				<label>Sujet <small>obligatoire</small></label>
				<input type="text" name="ug-contact-subject" required>
				<small class="error">Un sujet est nécessaire.</small>
			</div>
			<div class="message-field">
				<label>Votre message <small>obligatoire</small></label>
				<textarea rows="10" name="ug-contact-message" required></textarea>
				<small class="error">Merci de remplir votre message !</small>
			</div>
			<button type="submit">Envoyer &rarr;</button>
            <input type="text" name="ug-spam" style="display:none;">
            <div class="ajax-message"></div>
		</form>
	</section>
	<section class="large-4 columns">
		<?php get_sidebar(); ?>
	</section>
</article>
<?php get_footer(); ?>
