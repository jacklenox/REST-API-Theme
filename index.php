<?php

// Set up Mustache
$m = new Mustache_Engine(
	array(
		'loader' => new Mustache_Loader_FilesystemLoader( get_template_directory() . '/views' ),
	)
);

get_header();

$the_loop = array();
$the_post = array();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$the_post['ID']        = get_the_ID();
		ob_start();
		post_class();
		$the_post['post_class']    = ob_get_clean();
		$the_post['title']     = get_the_title();
		$the_post['link'] = get_permalink();
		ob_start();
		the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'rest-api-theme' ) );
		$the_post['content'] = ob_get_clean();
		$the_loop[]                = $the_post;
		$the_post                  = array();
	}
}

echo $m->render(
	'index', array(
		'the-loop' => $the_loop,
	)
);

get_footer();