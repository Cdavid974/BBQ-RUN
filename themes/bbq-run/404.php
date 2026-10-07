<?php
/**
 * Page affichée quand WordPress ne trouve pas l'adresse demandée.
 *
 * @package BBQ_RUN
 */

// Bloque l'accès direct au fichier en dehors de WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Le thème enfant réutilise l'en-tête du parent via le mécanisme de template WordPress.
get_header();
?>

<!-- tabindex=-1 permet de placer le focus clavier sur le contenu principal si nécessaire. -->
<main id="primary" class="site-main bbq-404" tabindex="-1">
	<section class="bbq-404__hero" aria-labelledby="bbq-404-title">
		<div class="bbq-404__content">
			<p class="bbq-404__eyebrow"><?php esc_html_e( 'Erreur 404', 'bbq-run' ); ?></p>
			<h1 id="bbq-404-title"><?php esc_html_e( 'Cette page a quitté le feu.', 'bbq-run' ); ?></h1>
			<p class="bbq-404__message">
				<?php esc_html_e( 'La page que vous cherchez est introuvable. Elle a peut-être changé d’adresse. Essayez une recherche ou revenez à l’accueil pour retrouver le menu.', 'bbq-run' ); ?>
			</p>

			<!-- Les helpers d'échappement sécurisent les valeurs avant leur insertion dans le HTML. -->
			<a class="bbq-404__home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Retour à l’accueil', 'bbq-run' ); ?>
				<span aria-hidden="true">&rarr;</span>
			</a>

			<div class="bbq-404__search-wrap">
				<h2><?php esc_html_e( 'Que recherchez-vous ?', 'bbq-run' ); ?></h2>
				<!-- Le paramètre s est celui que WordPress utilise pour lancer une recherche. -->
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="bbq-404-search" class="screen-reader-text"><?php esc_html_e( 'Rechercher sur le site', 'bbq-run' ); ?></label>
					<input type="search" id="bbq-404-search" class="search-field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Votre recherche…', 'bbq-run' ); ?>" />
					<button type="submit" class="search-submit"><?php esc_html_e( 'Rechercher', 'bbq-run' ); ?></button>
				</form>
				<!-- La zone annoncera les erreurs de validation aux lecteurs d'écran. -->
				<p class="bbq-404__search-error" id="bbq-404-search-error" aria-live="polite" aria-atomic="true"></p>
			</div>
		</div>

		<!-- L'illustration est décorative ; son contenu est masqué aux technologies d'assistance. -->
		<div class="bbq-404__art" aria-hidden="true">
			<svg class="bbq-404__illustration" viewBox="0 0 520 440" role="presentation" focusable="false">
				<circle cx="260" cy="218" r="183" fill="#0e0e0f" />
				<circle cx="260" cy="218" r="159" fill="none" stroke="#8c6732" stroke-width="1.5" stroke-dasharray="3 9" />
				<!-- Une flamme stylisée rappelle la cuisson au barbecue. -->
				<path d="M260 77c13 33 46 43 46 83 0 17-8 30-20 39 3-26-11-43-29-55 4 25-30 38-30 73 0 24 16 43 39 48-10 9-24 14-39 14-39 0-69-29-69-67 0-27 18-47 39-67 20-20 40-41 63-68Z" fill="#eb9932" />
				<path d="M260 162c8 18 25 25 25 47 0 20-13 35-31 35s-32-13-32-31c0-14 9-24 19-35 7-7 14-14 19-24Z" fill="#fff" />
				<!-- Grille et pieds dessinés en traits simples pour rester légers. -->
				<path d="M151 263h218M165 279h190M180 296h160M192 312l-19 46m155-46 19 46" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="7" />
				<path d="M175 263c6 24 24 38 45 38h80c21 0 39-14 45-38" fill="none" stroke="#eb9932" stroke-linecap="round" stroke-width="7" />
				<path d="M211 352h98" fill="none" stroke="#8c6732" stroke-linecap="round" stroke-width="7" />
				<circle cx="112" cy="158" r="5" fill="#eb9932" />
				<circle cx="401" cy="198" r="4" fill="#fff" />
				<path d="M375 118v16m-8-8h16M130 324v13m-7-6h14" stroke="#eb9932" stroke-linecap="round" stroke-width="3" />
			</svg>
			<span class="bbq-404__number">404</span>
		</div>
	</section>

	<?php
	// Cette requête facultative propose trois articles récents quand le site en possède.
	$bbq_404_recent_posts = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	?>
	<?php if ( $bbq_404_recent_posts->have_posts() ) : ?>
		<section class="bbq-404__recent" aria-labelledby="bbq-404-recent-title">
			<div class="bbq-404__recent-heading">
				<p class="bbq-404__eyebrow"><?php esc_html_e( 'À découvrir', 'bbq-run' ); ?></p>
				<h2 id="bbq-404-recent-title"><?php esc_html_e( 'Les dernières nouvelles', 'bbq-run' ); ?></h2>
			</div>
			<ul class="bbq-404__posts">
				<?php foreach ( $bbq_404_recent_posts->posts as $bbq_404_post ) : ?>
					<li class="bbq-404__post">
						<a href="<?php echo esc_url( get_permalink( $bbq_404_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $bbq_404_post->ID ) ); ?></a>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $bbq_404_post->ID ) ); ?>"><?php echo esc_html( get_the_date( '', $bbq_404_post->ID ) ); ?></time>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
