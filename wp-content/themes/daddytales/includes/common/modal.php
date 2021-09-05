<?php
/**
 * Modal window.
 *
 * @package WordPress
 * @subpackage industrialcyber
 */
?>

<div id="modal-wrapper" class="modal-wrapper">
	<form class="dt-form modal">
		<fieldset>
			<div class="dt-form-field">
				<label for="subject">
					<?php esc_html_e( 'Тема', 'daddytales' ) ?>
					<span class="dt-form-required">*</span>
				</label>
				<input id="subject" name="subject" class="input" type="text" />
			</div>

			<div class="dt-form-field">
				<label for="message">
					<?php esc_html_e( 'Сообщение', 'daddytales' ) ?>
					<span class="dt-form-required">*</span>
				</label>
				<textarea id="message" name="message" class="textarea"></textarea>
			</div>

			<div class="dt-form-field dt-form-field_button">
				<button class="button black icon" type="submit">
					<?php esc_html_e( 'Отправить', 'daddytales' ) ?>
					<i class="fas fa-paper-plane"></i>
				</button>
			</div>

			<?php wp_nonce_field( 'dt_ajax_modal', 'dt_modal_nonce' ) ?>
			<div class="dt-form-field note hidden"></div>

			<div class="disclaimer">
				<?php esc_html_e( 'Мы заботимся о сохранности данных Сообщества портала "Папины Сказки". Ваши данные никогда не будут переданы третьим лицам.', 'daddytales' ) ?>
			</div>
		</fieldset>

		<div class="close-cross modal-close">
			<i class="fas fa-times"></i>
		</div>
	</form><!-- .modal -->
</div><!-- .modal-wrapper -->
