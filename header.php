<?php

// Set up Mustache
$m = new Mustache_Engine(
	array(
		'loader' => new Mustache_Loader_FilesystemLoader( get_template_directory() . '/views' ),
	)
);

// Prepare content for template
ob_start();
language_attributes();
$language_attributes = ob_get_clean();
ob_start();
wp_title( '|', true, 'right' );
$wp_title = ob_get_clean();
ob_start();
wp_head();
$wp_head = ob_get_clean();
ob_start();
body_class();
$body_class = ob_get_clean();
ob_start();
wp_nav_menu( array( 'theme_location' => 'primary' ) );
$wp_nav_menu = ob_get_clean();

echo $m->render(
	'header', array(
		'language-attributes' => $language_attributes,
		'charset'             => get_bloginfo( 'charset' ),
		'wp-title'            => $wp_title,
		'pingback-url'        => get_bloginfo( 'pingback_url' ),
		'wp-head'             => $wp_head,
		'body-class'          => $body_class,
		'skip-to-content'     => __( 'Skip to content', 'rest-api-theme' ),
		'site-url'            => home_url( '/' ),
		'site-name'           => get_bloginfo( 'name' ),
		'site-description'    => get_bloginfo( 'description' ),
		'primary-menu'        => __( 'Primary Menu', 'rest-api-theme' ),
		'nav-menu'            => $wp_nav_menu,
	)
);