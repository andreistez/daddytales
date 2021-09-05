<?php
/**
 * @package WordPress
 * @subpackage daddytales
 */
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset') ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta content="" name="description" />
	<meta content="" name="keywords" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="HandheldFriendly" content="true" />

	<title>
		<?php
		global $page, $paged;
		$uri = get_template_directory_uri();

		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );

		if( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";

		if( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'daddytales' ), max( $paged, $page ) );
		?>
	</title>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $uri ?>/favicon/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $uri ?>/favicon/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $uri ?>/favicon/favicon-16x16.png" />
	<link rel="manifest" href="<?php echo $uri ?>/favicon/site.webmanifest" />
	<link rel="mask-icon" href="<?php echo $uri ?>/favicon/safari-pinned-tab.svg" color="#5bbad5" />
	<meta name="msapplication-TileColor" content="#da532c" />
	<meta name="theme-color" content="#ffffff" />
	<!-- /Favicon -->

	<!-- Preloader styles. -->
    <style>
        .lds-ring {
            display: flex;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 100500;
            background-color: #fff;
            justify-content: center;
            align-items: center
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #ffd556;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #ffd556 transparent transparent transparent
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }
    </style>
    <!-- /Preloader styles. -->

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700;900&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet" />
	<!-- /Google Fonts -->

	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>
	<?php wp_body_open() ?>

	<!-- Preloader -->
	<div class = "lds-ring"><div></div><div></div><div></div><div></div></div>

	<?php
	/**
	 * Header settings.
	 *
	 * @see Appearance -> Customize -> Header Settings.
	 */
	$header_logo = fw_get_db_customizer_option( 'header_logo' );
	?>

	<div class="wrapper">
		<?php
		// Hide header on Login/Registration/Lostpass/Activation pages.
		if(
			! is_page_template( 'page-template-login.php' )
			&& ! is_page_template( 'page-template-lostpass.php' )
			&& ! is_page_template( 'page-template-register.php' )
			&& ! is_page_template( 'page-template-activate.php' )
		){
			?>
			<header class="header">
				<div class="fw-container">
					<div class="header-inner">
						<?php
						if( $header_logo ){
							?>
							<div class="header-logo">
								<a href="<?php echo home_url( '/' ) ?>" title="<?php esc_attr_e( 'На Главную', 'daddytales' ) ?>">
									<?php echo wp_get_attachment_image( $header_logo['attachment_id'] ) ?>
								</a>
							</div>
							<?php
						}
						?>

						<div class="header-right">
							<div class="header-right-top">
								<?php
								get_search_form();
								get_template_part( 'includes/common/auth', 'buttons' );
								?>
							</div>

							<div id="header-nav-wrapper" class="header-nav-wrapper">
								<div class="header-nav__mobile">
									<i class="fas fa-bars"></i>
								</div>

								<?php
								wp_nav_menu(
									[
										'theme_location'	=> 'header_menu',
										'container'			=> 'nav',
										'container_class'	=> 'header-nav',
										'container_id'		=> 'header-nav'
									]
								)
								?>

								<div class="close-cross header-nav__close">
									<i class="fas fa-times"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<?php
		}
		?>
