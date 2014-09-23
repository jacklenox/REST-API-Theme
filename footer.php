<?php

// Set up Mustache
$m = new Mustache_Engine(
	array(
		'loader' => new Mustache_Loader_FilesystemLoader( get_template_directory() . '/views' ),
	)
);

// Prepare content for template
ob_start();
wp_footer();
$wp_footer = ob_get_clean();

echo $m->render(
	'footer', array(
		'site-info-url' => __( 'http://wordpress.org/', 'rest-api-theme' ),
		'site-info-text' => __( 'Proudly powered by WordPress', 'rest-api-theme' ),
		'theme-credit' => __( 'Theme: REST API Theme by Jack Lenox.', 'rest-api-theme' ),
		'wp-footer' => $wp_footer,
	)
);