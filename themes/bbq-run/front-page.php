<?php
/** Page d'accueil BBQ RUN : une entrée simple vers l'univers du feu de bois. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$bbq_home_image_url = trailingslashit( wp_upload_dir()['baseurl'] ) . '2026/10/QG7A5386-e1695222327818.jpg';
$bbq_home_image_id  = attachment_url_to_postid( $bbq_home_image_url );
$bbq_home_cta_url   = bbq_run_woo_page_url( 'shop' );
$bbq_home_cta_label = __( 'Découvrir la boutique', 'bbq-run' );

if ( ! $bbq_home_cta_url ) {
	$bbq_home_page = get_page_by_path( 'braai', OBJECT, 'page' );
	if ( $bbq_home_page && 'publish' === $bbq_home_page->post_status ) {
		$bbq_home_cta_url   = get_permalink( $bbq_home_page );
		$bbq_home_cta_label = __( 'Découvrir nos braais', 'bbq-run' );
	} else {
		$bbq_home_contact = bbq_run_footer_pages()['contact'];
		if ( $bbq_home_contact ) {
			$bbq_home_cta_url   = get_permalink( $bbq_home_contact );
			$bbq_home_cta_label = __( 'Nous contacter', 'bbq-run' );
		}
	}
}
?>
	<main id="primary" class="site-main bbq-home">
		<section class="bbq-hero bbq-section-dark" aria-labelledby="bbq-hero-title">
			<?php if ( $bbq_home_image_id ) : ?>
				<?php
				echo wp_get_attachment_image(
					$bbq_home_image_id,
					'full',
					false,
					array(
						'class'         => 'bbq-hero__image',
						'alt'           => '',
						'aria-hidden'   => 'true',
						'width'         => 2000,
						'height'        => 1333,
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'decoding'      => 'async',
					)
				); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WordPress génère et échappe la balise image.
				?>
			<?php else : ?>
				<img class="bbq-hero__image" src="<?php echo esc_url( $bbq_home_image_url ); ?>" width="2000" height="1333" alt="" aria-hidden="true" loading="eager" fetchpriority="high" decoding="async">
			<?php endif; ?>
			<div class="bbq-hero__shade" aria-hidden="true"></div>
			<div class="bbq-hero__content">
				<p class="bbq-hero__eyebrow"><?php esc_html_e( 'BBQ RUN', 'bbq-run' ); ?></p>
				<h1 id="bbq-hero-title"><?php esc_html_e( 'Le goût du feu,', 'bbq-run' ); ?><br><?php esc_html_e( 'le plaisir du partage.', 'bbq-run' ); ?></h1>
				<p class="bbq-hero__lead"><?php esc_html_e( 'Découvrez l’univers BBQ RUN et la cuisine au feu de bois.', 'bbq-run' ); ?></p>
				<?php if ( $bbq_home_cta_url ) : ?>
					<a class="bbq-hero__button" href="<?php echo esc_url( $bbq_home_cta_url ); ?>"><?php echo esc_html( $bbq_home_cta_label ); ?></a>
				<?php endif; ?>
			</div>
		</section>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php
			// Elementor doit trouver the_content() même lorsque la page est encore vide.
			$bbq_home_preview = class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode();
			?>
			<?php if ( $bbq_home_preview || trim( get_the_content() ) ) : ?>
				<section class="bbq-home__content">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</section>
			<?php endif; ?>
		<?php endwhile; ?>
	</main>
<?php

get_footer();
