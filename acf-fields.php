<?php


function my_acf_notice() { ?>
  <div class="update-nag notice">
      <p><?php _e( 'Please install Advanced Custom Fields, it is required for this software to work properly!', 'my_plugin_textdomain' ); ?></p>
  </div> <?php
}

// ADD OPTIONS PAGE 
$option_args = array(
	'page_title' => 'Options',
	'menu_title' => '',
	'menu_slug' => '',
	'capability' => 'edit_posts',
	'position' => false,
	'parent_slug' => '',
	'icon_url' => false,
	'redirect' => true,
	'post_id' => 'options',
	'autoload' => false,
);

// ensure acf is running
if( function_exists( 'the_field' ) ) {
	acf_add_options_page( $option_args );


	// start insert exported acf fields here ===============================================================================================================












	// end insert exported acf fields here ===============================================================================================================


}else{
	add_action( 'admin_notices', 'my_acf_notice' );
}