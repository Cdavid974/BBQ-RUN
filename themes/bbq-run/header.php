<?php
/**
 * En-tête du thème enfant BBQ RUN.
 *
 * La structure conserve les points d'entrée attendus par WordPress et Astra,
 * tout en remplaçant leur en-tête par une navigation légère et personnalisée.
 *
 * @package BBQ_RUN
 */

// Empêche l'accès direct au fichier en dehors de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bbq_run_logo_url = get_stylesheet_directory_uri() . '/assets/images/logo/logo-principal.svg';
$bbq_run_cart_url = bbq_run_woo_page_url( 'cart' );
$bbq_run_account_url = bbq_run_woo_page_url( 'myaccount' );
$bbq_run_cart_count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<?php astra_head_top(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php astra_head_bottom(); ?>
</head>
<body <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content">
		<?php esc_html_e( 'Aller au contenu', 'bbq-run' ); ?>
	</a>

	<header id="masthead" class="site-header bbq-header">
		<div class="bbq-header__inner">
			<!-- Le logo existant garde ses proportions et son dessin d'origine. -->
			<a class="bbq-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — <?php esc_attr_e( 'Accueil', 'bbq-run' ); ?>">
				<img src="<?php echo esc_url( $bbq_run_logo_url ); ?>" width="292" height="48" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>

			<!-- Le menu desktop reste modifiable depuis Apparence > Menus. -->
			<nav class="bbq-header__nav" aria-label="<?php esc_attr_e( 'Navigation principale', 'bbq-run' ); ?>">
				<?php bbq_run_primary_menu( 'bbq-primary-menu', 'bbq-menu' ); ?>
			</nav>

			<div class="bbq-header__tools" aria-label="<?php esc_attr_e( 'Outils du site', 'bbq-run' ); ?>">
				<!-- Le formulaire reste utilisable sans JavaScript grâce à details/summary. -->
				<details class="bbq-search">
					<summary class="bbq-icon-button" aria-label="<?php esc_attr_e( 'Ouvrir la recherche', 'bbq-run' ); ?>">
						<?php echo bbq_run_search_icon(); // Icône SVG fixe définie dans inc/layout.php. ?>
					</summary>
					<form class="bbq-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label class="screen-reader-text" for="bbq-header-search"><?php esc_html_e( 'Rechercher sur le site', 'bbq-run' ); ?></label>
						<input id="bbq-header-search" type="search" name="s" placeholder="<?php esc_attr_e( 'Rechercher…', 'bbq-run' ); ?>">
						<button type="submit" aria-label="<?php esc_attr_e( 'Lancer la recherche', 'bbq-run' ); ?>">
							<?php echo bbq_run_search_icon(); // Icône SVG fixe définie dans inc/layout.php. ?>
						</button>
					</form>
				</details>

				<?php if ( $bbq_run_account_url ) : ?>
					<a class="bbq-icon-button bbq-account" href="<?php echo esc_url( $bbq_run_account_url ); ?>" aria-label="<?php esc_attr_e( 'Mon compte', 'bbq-run' ); ?>">
						<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="3.5"></circle><path d="M4.5 20c.6-4 3.1-6 7.5-6s6.9 2 7.5 6"></path></svg>
					</a>
				<?php endif; ?>

				<?php if ( $bbq_run_cart_url ) : ?>
					<a class="bbq-icon-button bbq-cart" href="<?php echo esc_url( $bbq_run_cart_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Panier : %d article(s)', 'bbq-run' ), $bbq_run_cart_count ) ); ?>">
						<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 4h2l2.1 11.1a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 9H6"></path><circle cx="10" cy="20" r="1"></circle><circle cx="18" cy="20" r="1"></circle></svg>
						<span class="bbq-cart__count" aria-hidden="true"><?php echo esc_html( $bbq_run_cart_count ); ?></span>
					</a>
				<?php endif; ?>

				<!-- Sur mobile, le menu s'ouvre nativement et reste fonctionnel sans script. -->
				<details class="bbq-mobile-menu">
					<summary class="bbq-icon-button bbq-menu-toggle" aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'bbq-run' ); ?>">
						<span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span>
					</summary>
					<nav class="bbq-mobile-menu__panel" aria-label="<?php esc_attr_e( 'Menu mobile', 'bbq-run' ); ?>">
						<?php bbq_run_primary_menu( 'bbq-mobile-primary-menu', 'bbq-menu bbq-menu--mobile' ); ?>
					</nav>
				</details>
			</div>
		</div>
	</header>

	<?php astra_content_before(); ?>
	<div id="content" class="site-content">
		<div class="ast-container">
		<?php astra_content_top(); ?>
