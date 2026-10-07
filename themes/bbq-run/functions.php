<?php
/**
 * Enqueue the BBQ RUN child theme stylesheet after Astra's stylesheet.
 */
function bbq_run_enqueue_styles() {
	wp_enqueue_style(
		'bbq-run-style',
		get_stylesheet_uri(),
		array( 'astra-theme-css' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'bbq_run_enqueue_styles', 15 );
