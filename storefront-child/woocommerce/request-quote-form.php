<?php
/**
 * Form to Request a quote
 *
 * @package YITH WooCommerce Request A Quote
 * @since   1.0.0
 * @version 1.5.3
 * @author  YITH
 */

?>
<div class="yith-ywraq-mail-form-wrapper mel-devis-form--container">
	<h3>Envoi du devis</h3>

	<form id="yith-ywraq-mail-form" name="yith-ywraq-mail-form" action="<?php echo esc_url( YITH_Request_Quote()->get_raq_page_url() ); ?>" method="post">

			<p class="form-row form-row-wide validate-required " id="rqa_name_row">
				<label for="rqa-name" class="">Votre petit nom ?*</label>
				<input type="text" class="input-text " name="rqa_name" id="rqa-name" placeholder="Insérez votre nom" value="" required>
			</p>

			<p class="form-row form-row-wide validate-required" id="rqa_email_row">
				<label for="rqa-email" class="">Votre courriel ?*</label>
				<input type="email" class="input-text " name="rqa_email" id="rqa-email" placeholder="Insérez votre adresse mail" value="" required>
			</p>

		<p class="form-row" id="rqa_message_row">
			<label for="rqa-message" class="">Votre message ?</label>
			<textarea name="rqa_message" class="input-text " id="rqa-message" placeholder="Un petit message à nous faire passer ? N’hésites pas :)"></textarea>
		</p>

		<p class="form-row mel-devis-form--submit">
			<input type="hidden" id="raq-mail-wpnonce" name="raq_mail_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'send-request-quote' ) ); ?>">
			<button class="button raq-send-request mel-devis-form-submit-button" type="submit" value="Recevoir mon devis">Recevoir mon devis</button>
		</p>

	</form>
</div>
