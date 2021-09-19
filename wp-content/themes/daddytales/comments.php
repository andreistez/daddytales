<?php
/**
 * Comments template.
 *
 * @package WordPress
 * @subpackage daddytales
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if( post_password_required() ) return;

if( is_user_logged_in() ){
	$current_user		= wp_get_current_user();
	$current_user_login	= $current_user->user_login;
}	else {
	$current_user_login = '';
}
?>

<div id="comments" class="comments-area white-wrapper">
	<?php
	$comments_args = [
		'logged_in_as'	=> '<p class="logged-in-as">' . sprintf( __( 'Вы вошли как <a href="/profile">%s</a>. <a class="dt-logout" href="#" title="Выйти из аккаунта">Выйти?</a>', 'daddytales' ), $current_user_login ) . '</p>',
		'comment_field'	=> '<p class="comment-form-comment"><label for="comment">' . __( 'Ваш комментарий', 'daddytales' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
		'submit_button'	=> '<button class="button black hover-yellow icon" type="submit">' . esc_html__( 'Оставить своё важное мнение', 'daddytales' ) . '<i class="fas fa-paper-plane"></i></button>'
	];
	comment_form( $comments_args );

	if( have_comments() ){
		?>
		<h4 class="comments-title">
			<?php
			$comments_count = get_comments_number();
			if( $comments_count == 1 ) esc_html_e( 'Один комментарий к записи:', 'daddytales' );
			else printf( esc_html__( 'Комментарии (%d):', 'daddytales' ), $comments_count );
			?>
		</h4>

		<?php the_comments_navigation() ?>

		<ul class="comment-list">
			<?php
			wp_list_comments(
				[
					'style'			=> 'ul',
					'type'			=> 'comment',
					'reply_text'	=> esc_html__( 'Ответить на комментарий', 'daddytales' ),
					'callback'		=> 'dt_theme_comments',
					'echo'			=> true
				]
			);
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments - show note.
		if( ! comments_open() ){
			?>
			<p class="no-comments">
				<?php esc_html_e( 'Комментарии закрыты.', 'daddytales' ) ?>
			</p>
			<?php
		}
	}	else {
		?>
		<div class="no-comments-yet">
			<?php esc_html_e( 'К этой записи пока нет комментариев. Будьте первым!', 'daddytales' ) ?>
		</div>
		<?php
	}
	?>
</div><!-- #comments -->

