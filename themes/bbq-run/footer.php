<?php
/**
 * Pied de page BBQ RUN, avec les liens réels disponibles dans WordPress.
 *
 * @package BBQ_RUN
 */

// Bloque l'accès direct au fichier en dehors de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bbq_run_footer_logo = get_stylesheet_directory_uri() . '/assets/images/logo/logo-principal.svg';
$bbq_run_footer_pages = bbq_run_footer_pages();
$bbq_run_contact_page = $bbq_run_footer_pages['contact'];
$bbq_run_legal_pages  = $bbq_run_footer_pages['legal'];
$bbq_run_shop_url = bbq_run_woo_page_url( 'shop' );
$bbq_run_footer_columns = 2 + ( $bbq_run_shop_url ? 1 : 0 ) + ( $bbq_run_legal_pages ? 1 : 0 ) + ( $bbq_run_contact_page ? 1 : 0 );
?>
		<?php astra_content_bottom(); ?>
		</div><!-- .ast-container -->
	</div><!-- #content -->
	<?php astra_content_after(); ?>

	<footer id="colophon" class="site-footer bbq-footer">
		<div class="bbq-footer__inner">
			<div class="bbq-footer__columns bbq-footer__columns--<?php echo esc_attr( $bbq_run_footer_columns ); ?>">
				<section class="bbq-footer__brand" aria-labelledby="bbq-footer-brand-title">
					<h2 class="screen-reader-text" id="bbq-footer-brand-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
					<a class="bbq-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo esc_url( $bbq_run_footer_logo ); ?>" width="292" height="48" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
					<p><?php esc_html_e( 'Le goût du feu, le plaisir du partage.', 'bbq-run' ); ?></p>
				</section>

				<section class="bbq-footer__column" aria-labelledby="bbq-footer-links-title">
					<h2 id="bbq-footer-links-title"><?php esc_html_e( 'Liens rapides', 'bbq-run' ); ?></h2>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'bbq-footer',
							'menu_id'        => 'bbq-footer-menu',
							'menu_class'     => 'bbq-footer__list',
							'container'      => false,
							'fallback_cb'    => 'bbq_run_footer_menu_fallback',
							'depth'          => 1,
						)
					);
					?>
				</section>

				<?php if ( $bbq_run_shop_url ) : ?>
				<section class="bbq-footer__column" aria-labelledby="bbq-footer-shop-title">
					<h2 id="bbq-footer-shop-title"><?php esc_html_e( 'La boutique', 'bbq-run' ); ?></h2>
					<?php if ( taxonomy_exists( 'product_cat' ) && $bbq_run_shop_url ) : ?>
						<?php
						$bbq_run_categories = get_terms(
							array(
								'taxonomy'   => 'product_cat',
								'hide_empty' => false,
								'parent'     => 0,
								'number'     => 5,
							)
						);
						?>
						<?php if ( ! is_wp_error( $bbq_run_categories ) && $bbq_run_categories ) : ?>
							<ul class="bbq-footer__list">
								<?php foreach ( $bbq_run_categories as $bbq_run_category ) : ?>
									<li><a href="<?php echo esc_url( get_term_link( $bbq_run_category ) ); ?>"><?php echo esc_html( $bbq_run_category->name ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<ul class="bbq-footer__list"><li><a href="<?php echo esc_url( $bbq_run_shop_url ); ?>"><?php esc_html_e( 'Voir la boutique', 'bbq-run' ); ?></a></li></ul>
						<?php endif; ?>
					<?php endif; ?>
				</section>
				<?php endif; ?>

				<?php if ( $bbq_run_legal_pages ) : ?>
				<section class="bbq-footer__column" aria-labelledby="bbq-footer-useful-title">
					<h2 id="bbq-footer-useful-title"><?php esc_html_e( 'Informations', 'bbq-run' ); ?></h2>
					<ul class="bbq-footer__list">
						<?php foreach ( $bbq_run_legal_pages as $bbq_run_legal_page ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $bbq_run_legal_page ) ); ?>"><?php echo esc_html( get_the_title( $bbq_run_legal_page ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</section>
				<?php endif; ?>

				<?php if ( $bbq_run_contact_page ) : ?>
					<section class="bbq-footer__column bbq-footer__contact" aria-labelledby="bbq-footer-contact-title">
						<h2 id="bbq-footer-contact-title"><?php esc_html_e( 'Nous contacter', 'bbq-run' ); ?></h2>
						<a class="bbq-footer__contact-link" href="<?php echo esc_url( get_permalink( $bbq_run_contact_page ) ); ?>"><?php esc_html_e( 'Accéder à la page contact', 'bbq-run' ); ?> <span aria-hidden="true">&rarr;</span></a>
					</section>
				<?php endif; ?>
			</div>

			<div class="bbq-footer__bottom">
				<p class="bbq-footer__copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'Tous droits réservés.', 'bbq-run' ); ?></p>
			</div>
		</div>
	</footer>
	</div><!-- #page -->

<?php
// Conserve les points d'insertion Astra et WordPress utilisés par les extensions.
astra_body_bottom();
wp_footer();
?>
</body>
</html>
