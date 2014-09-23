<?php
/**
 * Load Mustache
 */
require get_template_directory() . '/libs/mustache.php/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

/**
 * AJAX url_to_postid handler
 */
add_action( 'wp_ajax_nopriv_get_post_id', 'rest_api_theme_get_post_id' );

function rest_api_theme_get_post_id() {
	if ( isset( $_POST['data'] ) ) {
		$post_id = url_to_postid( $_POST['data'] );
		wp_send_json_success( $post_id );
	}
}

function rest_api_theme_scripts() {
	wp_enqueue_style( 'rest-api-theme-style', get_stylesheet_uri() );

	wp_register_script( 'rest-api-theme-mustache', get_template_directory_uri() . '/libs/mustache.js', '20140629', true );
	wp_register_script( 'rest-api-theme-script', get_template_directory_uri() . '/js/rest-api-theme.js', array( 'backbone', 'underscore', 'jquery', 'rest-api-theme-mustache' ), '20140629', true );
	$script_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
	wp_localize_script( 'rest-api-theme-script', 'script_data', $script_array );
	wp_localize_script( 'rest-api-theme-script', 'rest_api_theme_data', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'rest-api-theme-script' );
}
add_action( 'wp_enqueue_scripts', 'rest_api_theme_scripts' );