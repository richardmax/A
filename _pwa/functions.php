<?php

add_filter( 'web_app_manifest', function( $manifest ) {
    $manifest['display'] = 'standalone';
	$manifest['orientation'] = 'portrait';
    return $manifest;
} );


add_theme_support(
	'service_worker',
	array(
		/*'wp-site-icon'         => false,
		'wp-custom-logo'       => true,
		'wp-custom-background' => true,
		*/
		'wp-fonts'             => true,
		'wp-styles'             => true,
	)
);


?>