<?php $t =& peTheme(); ?>
<?php $layout =& $t->layout; ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<?php if ( is_page() && $t->options->get( 'contactSubject' ) && ! empty( $meta->contact->show ) && 'yes' === $meta->contact->show ) : ?>

	<section id="section-contact" class="contact">

		<?php if ( $t->options->get( 'contactSectionTitle' ) ) : ?>

			<div class="row title">
				<h2><?php echo $t->options->get( 'contactSectionTitle' ); ?></h2>
				<hr>
			</div>

		<?php endif; ?>

		<div class="row">

			<div class="six col <?php echo ( $t->options->get( 'contactSectionText' ) ) ? 'offset-by-one' : 'offset-by-three'; ?>">


				<!-- Succes message after sending the form, see also the php file around line 90 -->
				<div id="message" class="c-message"></div>

				<form method="post" name="contactform" id="contactform" class="form c-form peThemeContactForm">
					<fieldset>
						<input name="author" type="text" id="name" placeholder="<?php _e( 'Name' ,'Pixelentity Theme/Plugin'); ?>" />
						<input name="email" type="text" id="email" placeholder="<?php _e( 'E-Mail' ,'Pixelentity Theme/Plugin'); ?>" />
						<textarea name="message" id="comments" placeholder="<?php _e( 'Nachricht' ,'Pixelentity Theme/Plugin'); ?>"></textarea>
						<input type="submit" class="submit btn outline" id="submit" value="<?php _e( 'Nachricht senden' ,'Pixelentity Theme/Plugin'); ?>" />
					</fieldset>

				<div id="contactFormSent" class="formSent response-message"><?php echo $t->options->get( 'msgOK' ); ?></div>
				<div id="contactFormError" class="formError response-message"><?php echo $t->options->get( 'msgKO' ); ?></div>

				</form>
			</div>

			<?php if ( $t->options->get( 'contactSectionText' ) ) : ?>

				<div class="four col text-left">

					<?php echo $t->options->get( 'contactSectionText' ); ?>

				</div>

			<?php endif; ?>

		</div>
	</section>

<?php endif; ?>

<div class="back-top-wrap">
	<a href="#top" class="scrollto"><i class="back-top fa fa-chevron-up"></i></a>
</div>

<?php /*if ( $t->options->get( 'footerSocialLinks' ) ) : */?><!--

	<footer class="social-footer">
		<div class="row">
			<div class="twelve col sf-icons">

				<?php /*$t->content->socialLinks( $t->options->get( 'footerSocialLinks' ), 'footer' ); */?>

				<p class="uber"><?php /*_e( 'Connect with us' ,'Pixelentity Theme/Plugin'); */?></p>
			</div>
		</div>
	</footer>

--><?php /*endif; */?>


<footer class="footer">
	<div class="row">
		<div class="twelve col">
			<p><?php echo $t->options->get( 'footerCopyright' ); ?></p>
		</div>
	</div>
</footer>

<?php $t->footer->wp_footer(); ?>

</body>
</html>
