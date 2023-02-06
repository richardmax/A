<?php

// todo 1 - add required pages by default
// todo 2 - ensure code only runs once if re setup by using if ( ! function_exists( 'geobubble_plugins_activate' ) ) :
// todo 3 - dont use description as a identifier in the api code. and dont use decription re icon urls either - too hacky

/* THIS RUNS ON ALL NEW SITES / APPS CRAETD -------- */

/* REMOVES SAMPLE CONTENT = must use on the main root blog */

/*
function execute_site_actions( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    switch_to_blog($blog_id);

    // Find and delete the WP default 'Sample Page'
    $defaultPage = get_page_by_title( 'Sample Page' );
    wp_delete_post( $defaultPage->ID, $bypass_trash = true );

    // Find and delete the WP default 'Hello world!' post
    $defaultPost = get_posts( array( 'title' => 'Hello World!' ) );
    wp_delete_post( $defaultPost[0]->ID, $bypass_trash = true );

    restore_current_blog();
}

add_action( 'wpmu_new_blog', 'execute_site_actions', 10, 6 );
*/




//Remove WPAUTOP from ACF TinyMCE Editor - ie. <p> tags that wrap evertthing
function acf_wysiwyg_remove_wpautop() {
    remove_filter('acf_the_content', 'wpautop' );
}
add_action('acf/init', 'acf_wysiwyg_remove_wpautop');




if ( ! function_exists( 'geobubble_pages_and_menus' ) ) :
function geobubble_pages_and_menus() {
	
// Find and delete the WP default 'Sample Page'
$defaultPage = get_page_by_title( 'Sample Page' );
if($defaultPage){
	wp_delete_post( $defaultPage->ID );
}
	
$defaultPost = get_page_by_title( 'Hello world!', 'OBJECT', 'post' );
if($defaultPost){
	wp_delete_post( $defaultPost->ID );
}
	

// DYNAMIC MENUS ======================================

	$name = 'App Menu';
	$menu_exists = wp_get_nav_menu_object($name);
	
	if( !$menu_exists){
		$menu_id = wp_create_nav_menu($name);
		$menu = get_term_by( 'name', $name, 'nav_menu' );
		
		wp_update_nav_menu_item($menu->term_id, 0, array(
			'menu-item-title' =>  __('Dashboard'),
			'menu-item-classes' => 'dashboard',
			'menu-item-description' => '/wp-content/themes/wordpress.theme-communio/_media/svgs/icon-nav-dashboard-1.svg',
			'menu-item-url' => '/wp-admin',
			'menu-item-target' => 'wordpress-admin', /*used to identify native wp so can load in iframe in webapp */
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish'));
		
		 $options = (array) get_option( 'nav_menu_options' );
			if ( ! isset( $options['auto_add'] ) ) {
				$options['auto_add'] = array();
			}
			$options['auto_add'][] = $menu_id;
			update_option( 'nav_menu_options', $options );
		
			//then you set the wanted theme  location
			$locations = get_theme_mod('nav_menu_locations');
			$locations['app'] = $menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		
	}

	$name1 = 'User Menu';
	$menu_exists1 = wp_get_nav_menu_object($name1);
	
	if( !$menu_exists1){
		$menu_id1 = wp_create_nav_menu($name1);
		$menu1 = get_term_by( 'name', $name1, 'nav_menu' );
		
		wp_update_nav_menu_item($menu1->term_id, 0, array(
			'menu-item-title' =>  __('Profile'),
			'menu-item-classes' => 'profile',
			'menu-item-description' => '/wp-content/themes/wordpress.theme-communio/_media/svgs/icon-nav-user-profile-1.svg',
			'menu-item-url' => '/wp-admin/profile.php',
			'menu-item-target' => 'wordpress-admin', /*used to identify native wp so can load in iframe in webapp */
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish'));
		
		wp_update_nav_menu_item($menu1->term_id, 0, array(
			'menu-item-title' =>  __('Content'),
			'menu-item-classes' => 'content',
			'menu-item-description' => '/wp-content/themes/wordpress.theme-communio/_media/svgs/icon-nav-user-content-1.svg',
			'menu-item-url' => '/wp-admin/edit.php',
			'menu-item-target' => 'wordpress-admin', /*used to identify native wp so can load in iframe in webapp */
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish'));
		
		wp_update_nav_menu_item($menu1->term_id, 0, array(
			'menu-item-title' =>  __('Comments'),
			'menu-item-classes' => 'comments',
			'menu-item-description' => '/wp-content/themes/wordpress.theme-communio/_media/svgs/icon-nav-comments-1.svg',
			'menu-item-url' => '/wp-admin/edit-comments.php',
			'menu-item-target' => 'wordpress-admin', /*used to identify native wp so can load in iframe in webapp */
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish'));
		
			//then you set the wanted theme  location
			$locations1 = get_theme_mod('nav_menu_locations');
			$locations1['user'] = $menu1->term_id;
			set_theme_mod( 'nav_menu_locations', $locations1 );

	}


}

add_action( 'after_setup_theme', 'geobubble_pages_and_menus' );
endif; // geobubble_pages_and_menus

if ( ! function_exists( 'geobubble_plugins_activate' ) ) :
function geobubble_plugins_activate() {
	
	function run_activate_plugin( $plugin ) {
	$current = get_option( 'active_plugins' );
	$plugin = plugin_basename( trim( $plugin ) );

		 if ( !in_array( $plugin, $current ) ) {
			 $current[] = $plugin;
			  sort( $current );
			  do_action( 'activate_plugin', trim( $plugin ) );
			  update_option( 'active_plugins', $current );
			  do_action( 'activate_' . trim( $plugin ) );
			  do_action( 'activated_plugin', trim( $plugin) );
		   }

		return null;
	 }
	//ACF related
	run_activate_plugin( 'advanced-custom-fields-pro/acf.php' );
	//run_activate_plugin( 'geo-acf-to-rest-api/class-acf-to-rest-api.php' );
	run_activate_plugin( 'wp.plugin-communio-api/class-acf-to-rest-api.php' );
	run_activate_plugin( 'advanced-custom-fields-number-slider/acf-number-slider.php' );
//	run_activate_plugin( 'acf-gravityforms-add-on/acf-gravityforms-add-on.php' );
	//run_activate_plugin( 'acf-accordion/acf-accordion.php' );
	
	// forums
	run_activate_plugin( 'bbpress/bbpress.php' );
	// feedback form
	run_activate_plugin( 'contact-form-7/wp-contact-form-7.php' );
	// social networks
	run_activate_plugin( 'dpSocialTimeline/dpSocialTimeline.php' );
	// GeoBubble Table
	//run_activate_plugin( 'geobubble-table/geobubble-table.php' );
	// Forms
	run_activate_plugin( 'gravityforms/gravityforms.php' );
	// Load more posts via ajax in wp-admin
	run_activate_plugin( 'infinite-wp-list-tables-master/infinite-wp-list-tables.php' );
	// Social Login
	run_activate_plugin( 'wordpress-social-login/wp-social-login.php' );
	// chatroom
	run_activate_plugin( 'wordpress-chat/wordpress-chat.php' );
	// wp imports
	run_activate_plugin( 'wordpress-importer/wordpress-importer.php' );
	// local avatars
	run_activate_plugin( 'wp-user-avatar/wp-user-avatar.php' );
	// show media from current user only
	run_activate_plugin( 'wp-users-media/index.php' );
	

}

add_action( 'after_setup_theme', 'geobubble_plugins_activate' );
endif; // geobubble_plugins_activate

/* remove wordpress heartbeat ------------ */
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
wp_deregister_script('heartbeat');
}







// user body class - front and back (back not working though)
if ( is_user_logged_in() ) {
    add_filter('body_class','add_role_to_body');
    add_filter('admin_body_class','add_role_to_body');
}
function add_role_to_body($classes) {
    $current_user = new WP_User(get_current_user_id());
    $user_role = array_shift($current_user->roles);
    if (is_admin()) {
        $classes .= 'user-'. $user_role;
    } else {
        $classes[] = 'user-'. $user_role;
    }
    return $classes;
}



add_post_type_support('forum', array('thumbnail'));
add_post_type_support('topic', array('thumbnail'));










// set default image sizes
update_option('thumbnail_size_w', 320);
update_option('thumbnail_size_h', 320);
update_option('medium_size_w', 620);
update_option('medium_size_h', 620);
update_option('large_size_w', 1920);
update_option('large_size_h', 1920);

// featured image sizes
set_post_thumbnail_size( 620, 620 );

//REMOVE IMAGE LINKS
update_option('image_default_link_type','none');


/* start Jetpack Compatibility File */

/*function mashboardv1jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'container',
		   'type'           => 'scroll',
		   'click_handle'    => false,
		   'wrapper' => true,
		'render'    => 'mashboardv1infinite_scroll_render',
		'footer'    => true,
	) );
}
add_action( 'after_setup_theme', 'mashboardv1jetpack_setup' );

function mashboardv1infinite_scroll_render() {
	while ( have_posts() ) {
		global $post_id;
		the_post();
		$post_id++;
		get_template_part( '_mashboard/post' );
	}
}


if(is_home()){
	require_once 'infinite-scroll-from-jetpack/infinity.php';
}

*/











// add acf google maps key
function my_acf_init() { 
   // acf_update_setting('google_api_key', 'AIzaSyBn5g-o3PZywPwdbVKvFA09dVOr7Lq5QHw');
	 acf_update_setting('google_api_key', 'AIzaSyC2XkAEUTf8ef-WcPN-YFBjSNesnkgRI3I');
}
add_action('acf/init', 'my_acf_init');

add_action('register_form','myplugin_register_form');
    function myplugin_register_form (){ ?>
       <p class='new-message'>Welcome. Please log in to continue or register for access. You can use Social Login / Registration too.</p>
        <?php
    }

// Change the Login Logo URL
function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
	return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

//Remove the Lost Password Link
function remove_lostpassword_text ( $text ) {
if ($text == 'Lost your password?'){$text = '';}
	return $text;
}
add_filter( 'gettext', 'remove_lostpassword_text' );

//Hide the Login Error Message
add_filter('login_errors',create_function('$a', "return null;"));

// Set “Remember Me” To Checked
function login_checked_remember_me() {
	add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
		

	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

add_action( 'login_init', 'wpse8170_login_init' );
function wpse8170_login_init() {
    wp_dequeue_style( 'nexus_stylesheet' );
	wp_dequeue_style( 'mashboard_make_app' );
	wp_dequeue_style( 'app_skin' );
	wp_dequeue_style( 'app_dynamic' );
}


add_action( 'login_enqueue_scripts', 'wpse8170_login_enqueue_scripts' );
function wpse8170_login_enqueue_scripts() {
    wp_register_style( 'login_stylesheet', get_stylesheet_directory_uri().'/css/login.css', null, '0.1', 'all' );
	wp_enqueue_style( 'login_stylesheet' );
	wp_register_script('login_script', get_template_directory_uri() . '/js/login.js', null, '', true );
	wp_enqueue_script( 'login_script');
	
	$app_subdomain = explode('.', $_SERVER["HTTP_HOST"])[0];
	$app_domain = explode('.', $_SERVER["HTTP_HOST"])[1];
	$app_subdomain_domain = $app_domain . "-" . $app_subdomain;
 	wp_register_style( 'loginbrand_stylesheet', get_stylesheet_directory_uri().'/_custom/' . $app_subdomain_domain . '/login.css', null, '0.1', 'all' );
	wp_enqueue_style( 'loginbrand_stylesheet' );
}


/* remove image links from galleries ----- */
add_shortcode( 'gallery', 'modified_gallery_shortcode' );
function modified_gallery_shortcode($attr) {
    $attr['link']="none";
    $output = gallery_shortcode($attr);
    return $output; 
}






// FROM CUSTOM/GEO ==============================================================================================================








function my_acf_notice_new() { ?>
  <div class="update-nag notice">
      <p><?php _e( 'NEW!!!Please install Advanced Custom Fields, it is required for this software to work properly!', 'my_plugin_textdomain' ); ?></p>
  </div> <?php
}






// ADD OPTIONS PAGE 
$ACFargsxxx = array(
	'page_title' => 'App Options',
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
	acf_add_options_page( $ACFargsxxx );
}else{
	 add_action( 'admin_notices', 'my_acf_notice_new' );
}






// ADD font etc SUPPORT TO UPLOAER
function my_mime_types($mime_types){
	$mime_types['apk'] = 'application/vnd.android.package-archive';
	$mime_types['ipax§'] = 'application/octet-stream';
	$mime_types['zip'] = 'application/zip';
    $mime_types['rar'] = 'application/x-rar-compressed';
    $mime_types['tar'] = 'application/x-tar';
    $mime_types['gz'] = 'application/x-gzip';
    $mime_types['gzip'] = 'application/x-gzip';
    $mime_types['tiff'] = 'image/tiff';
    $mime_types['tif'] = 'image/tiff';
    $mime_types['bmp'] = 'image/bmp';
   	$mime_types['svg'] = 'image/svg+xml';
    $mime_types['psd'] = 'image/vnd.adobe.photoshop';
    $mime_types['ai'] = 'application/postscript';
    $mime_types['indd'] = 'application/x-indesign'; // not official, but might still work
    $mime_types['eps'] = 'application/postscript';
    $mime_types['rtf'] = 'application/rtf';
    $mime_types['txt'] = 'text/plain';
    $mime_types['wav'] = 'audio/x-wav';
    $mime_types['csv'] = 'text/csv';
    $mime_types['xml'] = 'application/xml';
    $mime_types['flv'] = 'video/x-flv';
    $mime_types['swf'] = 'application/x-shockwave-flash';
    $mime_types['vcf'] = 'text/x-vcard';
    $mime_types['html'] = 'text/html';
    $mime_types['htm'] = 'text/html';
    $mime_types['css'] = 'text/css';
    $mime_types['js'] = 'application/javascript';
    $mime_types['ico'] = 'image/x-icon';
    $mime_types['otf'] = 'application/x-font-otf';
    $mime_types['ttf'] = 'application/x-font-ttf';
    $mime_types['woff'] = 'application/x-font-woff';
    $mime_types['ics'] = 'text/calendar';
	$mime_types['json'] = 'application/json';
    return $mime_types;
}
add_filter('upload_mimes', 'my_mime_types', 1, 1);















// category transients start - todo use moreas good for caching ============================================

// clear transient whenever a post updated, created
add_action( 'transition_post_status', 'publish_new_post', 10, 3 );

function publish_new_post() {
   delete_transient( 'category_list' );
}

// category transients end - todo use moreas good for caching ============================================



/* show bubble tyoe in posts admin columns ----------------------- */
if ( !is_super_admin() ) {

    /* show bubble tyoe in admin columns */
    function my_post_columns($columns)
    {
    	$columns = array(
    		'cb'	 	=> '<input type="checkbox" />',
    		'title' 	=> 'Title',
    		'bubbletype'	=>	'Bubble Type',
    		'date'		=>	'Date',
    		'comments'	=>	'Comments',
    	);
    	return $columns;
    }
	
}else{
	
	/* show bubble tyoe in admin columns */
    function my_post_columns($columns)
    {
    	$columns = array(
    		'cb'	 	=> '<input type="checkbox" />',
    		'title' 	=> 'Title',
    		'bubbletype'	=>	'Bubble Type',
    		'author'	=>	'Author',
    		'date'		=>	'Date',
    		'tags'		=>	'Tags',
    		'comments'	=>	'Comments',
    	);
    	return $columns;
    }
	
}

function my_custom_post_columns($column)
{
	global $post;
	if($column == 'bubbletype')
	{
		echo get_field('bubble_type', $post->ID);
	}
}

add_action("manage_posts_custom_column", "my_custom_post_columns");
add_filter("manage_edit-post_columns", "my_post_columns");

/* show bubble tyoe in pages admin columns ----------------------- */
function my_page_columns($columns)
{
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'title' 	=> 'Title',
		'pagetype'	=>	'Page Type',
		'parameter'	=>	'Parameter',
		'date'		=>	'Date',
	);
	return $columns;
}

function my_custom_page_columns($column)
{
	global $post;
	if($column == 'pagetype')
	{
		echo get_field('menu_item_action_type', $post->ID);
	}
	if($column == 'parameter')
	{
		echo htmlspecialchars(get_field('menu_item_action_parameter', $post->ID));
	}
}

add_action("manage_pages_custom_column", "my_custom_page_columns");
add_filter("manage_edit-page_columns", "my_page_columns");












































/*
// custom geo rss
add_action( 'after_setup_theme', 'geo_rss_template' );
function geo_rss_template() {
	add_feed( 'geo', 'my_geo_rss_render' );
}
function my_geo_rss_render() {
	//get_template_part( 'feed', 'short' );
	load_template( TEMPLATEPATH . '/_mashboard/geo-rss.php'); // You'll create a your-custom-feed.php file in your theme's directory
}
*/

// custom geo - just media / websites rss
/*
add_action( 'after_setup_theme', 'mediaweb_rss_template' );
function mediaweb_rss_template() {
	add_feed( 'mediaweb', 'my_mediaweb_rss_render' );
}
function my_mediaweb_rss_render() {
	global $wp_query;
	 $args = array (
			'post_type'              => array( 'post' ),
			'post_status'            => array( 'publish' ),
			'tag'                    => 'geo:kensalwise',
			'meta_key'		=> 'bubble_type',
			'meta_value'	=> array('media'),
			'compare' => 'IN',
	   );
	query_posts($args);
	load_template( TEMPLATEPATH . '/_mashboard/geo-filtered-rss.php'); // You'll create a your-custom-feed.php file in your theme's directory
}
*/



/* custom login  - @GEOBUBBLE - TODO  - MAKE COPY DYNAMIC*/
function wps_login_message( $message ) {
    if ( empty($message) ){
        return "<!-- p class='new-message'>If you have registered you can sign in with your account credentials or via your preferred social network below.</p -->";
    } else {
        return $message;
    }
}
add_filter( 'login_message', 'wps_login_message' );


    
function skin_js_footer() {

	echo "<script>
				jQuery(document).ready(function($) {	 
			
				 if (window.location.href.indexOf('?native') > -1) {
					$( 'body' ).addClass('native');
				 }
				 if(document.referrer.indexOf(window.location.hostname) != -1){
					if (document.referrer.indexOf('?native') > -1) {
						$( 'body' ).addClass('native');
				 	}
				 }
			});
	</script>";
	
	if(!current_user_can('administrator')){
		include 'css/dynamic.css.php';
	}

}
add_action('in_admin_footer', 'skin_js_footer');



// threaded comments
function enable_threaded_comments(){
 if (!is_admin()) {
  if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
   wp_enqueue_script('comment-reply');
  }
}

add_action('get_header', 'enable_threaded_comments');

//remove admin bar
add_filter('show_admin_bar', '__return_false');

/* gallery defaults */
function amethyst_gallery_atts( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '1',
      'size' => 'medium',
    ), $atts );
    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];
    return $out;
}
add_filter( 'shortcode_atts_gallery', 'amethyst_gallery_atts', 10, 3 );

if(is_admin()){
	
function my_acf_admin_head() { ?>



	<script type="text/javascript">
		/* @RICHARDMAX */
		jQuery(document).ready(function() {
			jQuery(".post-new-php").fadeTo("slow", 1, function() {
				// Animation complete.
			});
			// @richardmax - core edit
			function getQueryVariable(variable) {
				//alert(window.location.search.substring(1));
				var query = window.location.search.substring(1);
				var vars = query.split("&");
				for (var i = 0; i < vars.length; i++) {
					var pair = vars[i].split("=");
					if (pair[0] == variable) {
						return pair[1];
					}
				}
				return (false);
			}
			if (getQueryVariable('action') == 'edit') {
				//
			} else {
				if (getQueryVariable('longitude')) {
					document.getElementById('acf-field_52ea3d3eb89fa').value = getQueryVariable('longitude');
				}
				if (getQueryVariable('latitude')) {
					document.getElementById('acf-field_52ea3d1db89f9').value = getQueryVariable('latitude');
				}
			}
			jQuery('.acf-oembed .title-search input').on('input', function() {
				jQuery('#title').val(jQuery(this).val());
			});
			// adverts - image based
			jQuery('#acf-field_5527e823070b6').on('input', function(e, params) {
				jQuery('#title').val(this.value);
			});
			jQuery('#acf-field_56b8a1448d01d-input').on('change', function(e, params) {
				// FORUMS
				//alert(e.target.value); // OR
				//alert(this.value);
				//alert(this.text); // OR
				//alert(params.selected); // also in Panagiotis Kousaris' answer
				//  addressSelect.select2('data').text
			});
			/* questions */
			jQuery('.acf-field[data-name="bubble_title"] textarea').on('input', function() {
				//alert( jQuery(this).val() );
				jQuery('#title').val(jQuery(this).val());
			});
			jQuery('.acf-field[data-name="bubble_title"] input').on('input', function() {
				// alert( jQuery(this).val() );
				jQuery('#title').val(jQuery(this).val());
			});
		});
	</script>

<?php }

add_action('acf/input/admin_head', 'my_acf_admin_head');

// dashboard 
function sort_dashboard_widgets() {
	global $wp_meta_boxes;
	//unset($wp_meta_boxes['dashboard']['normal']['core']);
   // unset($wp_meta_boxes['dashboard']['side']['core']);
	add_meta_box('options-cms', ' ', 'options_cms_widget', 'dashboard', 'normal', 'high');
}

add_action('wp_dashboard_setup', 'sort_dashboard_widgets');

function options_cms_widget(){


	//displays differemt content if the first time the user views it or not. so could have a tutorial etc...
	echo '<header class="entry-header  customadmin">
		
                <h1 class="entry-title">Dashboard</small></h1>            
            </header>';
	

	
	$user = wp_get_current_user();
	
	$logincontrol = get_user_meta($user->ID, '_new_user', 'TRUE');
   if ( $logincontrol ) {
      //set the user to old
      update_user_meta( $user->ID, '_new_user', '0' );
	   
      echo the_field('content_registered', 'option');
   }else{
	   echo the_field('content_dashboard', 'option');
   }

}
	

	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 


// only show users own posts ===================================================================
function mypo_parse_query_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'update_core' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
			 add_filter('views_edit-post', 'fix_post_counts');
        add_filter('views_upload', 'fix_media_counts');
        }
    }
}

add_filter('parse_query', 'mypo_parse_query_useronly' );

// Fix post counts
function fix_post_counts($views) {
    global $current_user, $wp_query;
    unset($views['mine']);
    $types = array(
        array( 'status' =>  NULL ),
        array( 'status' => 'publish' ),
        array( 'status' => 'draft' ),
        array( 'status' => 'future' ),
		array( 'status' => 'pending' ),
        array( 'status' => 'trash' )
    );
    foreach( $types as $type ) {
        $query = array(
            'author'      => $current_user->ID,
            'post_type'   => 'post',
            'post_status' => $type['status']
        );
        $result = new WP_Query($query);
        if( $type['status'] == NULL ):
            $class = ($wp_query->query_vars['post_status'] == NULL) ? ' class="current"' : '';
            $views['all'] = sprintf(__('<a href="%s"'. $class .'>All <span class="count">(%d)</span></a>', 'all'),
                admin_url('edit.php?post_type=post'),
                $result->found_posts);
        elseif( $type['status'] == 'publish' ):
            $class = ($wp_query->query_vars['post_status'] == 'publish') ? ' class="current"' : '';
            $views['publish'] = sprintf(__('<a href="%s"'. $class .'>Published <span class="count">(%d)</span></a>', 'publish'),
                admin_url('edit.php?post_status=publish&post_type=post'),
                $result->found_posts);
        elseif( $type['status'] == 'draft' ):
            $class = ($wp_query->query_vars['post_status'] == 'draft') ? ' class="current"' : '';
            $views['draft'] = sprintf(__('<a href="%s"'. $class .'>Draft'. ((sizeof($result->posts) > 1) ? "s" : "") .' <span class="count">(%d)</span></a>', 'draft'),
                admin_url('edit.php?post_status=draft&post_type=post'),
                $result->found_posts);
		elseif( $type['status'] == 'future' ):
            $class = ($wp_query->query_vars['post_status'] == 'future') ? ' class="current"' : '';
            $views['draft'] = sprintf(__('<a href="%s"'. $class .'>Scheduled'. ((sizeof($result->posts) > 1) ? "s" : "") .' <span class="count">(%d)</span></a>', 'future'),
                admin_url('edit.php?post_status=future&post_type=post'),
                $result->found_posts);
        elseif( $type['status'] == 'pending' ):
            $class = ($wp_query->query_vars['post_status'] == 'pending') ? ' class="current"' : '';
            $views['pending'] = sprintf(__('<a href="%s"'. $class .'>Pending <span class="count">(%d)</span></a>', 'pending'),
                admin_url('edit.php?post_status=pending&post_type=post'),
                $result->found_posts);
        elseif( $type['status'] == 'trash' ):
            $class = ($wp_query->query_vars['post_status'] == 'trash') ? ' class="current"' : '';
            $views['trash'] = sprintf(__('<a href="%s"'. $class .'>Trash <span class="count">(%d)</span></a>', 'trash'),
                admin_url('edit.php?post_status=trash&post_type=post'),
                $result->found_posts);
        endif;
    }
    return $views;
}

// Fix media counts
function fix_media_counts($views) {
    global $wpdb, $current_user, $post_mime_types, $avail_post_mime_types;
    $views = array();
    $count = $wpdb->get_results( "
        SELECT post_mime_type, COUNT( * ) AS num_posts 
        FROM $wpdb->posts 
        WHERE post_type = 'attachment' 
        AND post_author = $current_user->ID 
        AND post_status != 'trash' 
        GROUP BY post_mime_type
    ", ARRAY_A );
    foreach( $count as $row )
        $_num_posts[$row['post_mime_type']] = $row['num_posts'];
    $_total_posts = array_sum($_num_posts);
    $detached = isset( $_REQUEST['detached'] ) || isset( $_REQUEST['find_detached'] );
    if ( !isset( $total_orphans ) )
        $total_orphans = $wpdb->get_var("
            SELECT COUNT( * ) 
            FROM $wpdb->posts 
            WHERE post_type = 'attachment' 
            AND post_author = $current_user->ID 
            AND post_status != 'trash' 
            AND post_parent < 1
        ");
    $matches = wp_match_mime_types(array_keys($post_mime_types), array_keys($_num_posts));
    foreach ( $matches as $type => $reals )
        foreach ( $reals as $real )
            $num_posts[$type] = ( isset( $num_posts[$type] ) ) ? $num_posts[$type] + $_num_posts[$real] : $_num_posts[$real];
    $class = ( empty($_GET['post_mime_type']) && !$detached && !isset($_GET['status']) ) ? ' class="current"' : '';
    $views['all'] = "<a href='upload.php'$class>" . sprintf( __('All <span class="count">(%s)</span>', 'uploaded files' ), number_format_i18n( $_total_posts )) . '</a>';
    foreach ( $post_mime_types as $mime_type => $label ) {
        $class = '';
        if ( !wp_match_mime_types($mime_type, $avail_post_mime_types) )
            continue;
        if ( !empty($_GET['post_mime_type']) && wp_match_mime_types($mime_type, $_GET['post_mime_type']) )
            $class = ' class="current"';
        if ( !empty( $num_posts[$mime_type] ) )
            $views[$mime_type] = "<a href='upload.php?post_mime_type=$mime_type'$class>" . sprintf( translate_nooped_plural( $label[2], $num_posts[$mime_type] ), $num_posts[$mime_type] ) . '</a>';
    }
    $views['detached'] = '<a href="upload.php?detached=1"' . ( $detached ? ' class="current"' : '' ) . '>' . sprintf( __( 'Unattached <span class="count">(%s)</span>', 'detached files' ), $total_orphans ) . '</a>';
    return $views;
}


/* Show only the Comments MADE BY the current logged user */

add_filter('the_comments', 'wpse56652_filter_comments');

function wpse56652_filter_comments($comments){
    global $pagenow;
    global $user_ID;
    get_currentuserinfo();
    if($pagenow == 'edit-comments.php' && current_user_can('author')){
        foreach($comments as $i => $comment){
            $the_post = get_post($comment->comment_post_ID);
            if($comment->user_id != $user_ID  && $the_post->post_author != $user_ID)
                unset($comments[$i]);
        }
    }
    return $comments;
}

add_filter('show_admin_bar', '__return_false');

add_action('admin_menu','wphidenag');
function wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}

add_filter('the_content', 'do_shortcode', 11); 

add_filter('gettext', 'change_admin_cpt_text_filter', 20, 3);

function change_admin_cpt_text_filter( $translated_text, $untranslated_text, $domain ) {

  global $typenow;

  if( is_admin() && 'location' == $typenow )  {

    switch( $untranslated_text ) {
        case 'Add New Bubble':
          $translated_text = __( 'Bubbles Title','text_domain' );
        break;
        case 'Enter title here':
          $translated_text = __( 'Bubbles Title','text_domain' );
        break;
     }
   }
   return $translated_text;
}

// show right panels by default in admin
add_action('user_register', 'set_user_metaboxes');
function set_user_metaboxes($user_id=NULL) {
    $meta_key['hidden'] = 'metaboxhidden_post';
    // Set the default hiddens if it has not been set yet
    if ( ! get_user_meta( $user_id, $meta_key['hidden'], true) ) {
        $meta_value = array('postcustom','trackbacksdiv','commentstatusdiv','slugdiv','authordiv','revisionsdiv');
        update_user_meta( $user_id, $meta_key['hidden'], $meta_value );
    }
}

// MOVE PUBLISH TO BOTTOM
add_action('do_meta_boxes', 'wpse33063_move_meta_box');

function wpse33063_move_meta_box(){
	remove_meta_box( 'formatdiv', 'location', 'side' );
    add_meta_box( 'formatdiv', _x( 'Bubble Type', 'post format' ), 'post_format_meta_box', 'location', 'normal', 'high' );
	remove_meta_box( 'postimagediv', 'location', 'side' );
    add_meta_box('postimagediv', __('Bubble Image'), 'post_thumbnail_meta_box', 'location', 'normal', 'low');	
	remove_meta_box( 'submitdiv', 'location', 'side' );
    add_meta_box( 'submitdiv', __( 'Create Bubble' ), 'post_submit_meta_box', 'location', 'normal', 'low' );
}

/* enqueue admin scripts */
function load_custom_wp_admin_style() {
	if ( !current_user_can( 'manage_options' ) ) {
    	/* A user without admin privileges */
		wp_register_style( 'admin_skin', get_stylesheet_directory_uri().'/css/skin.css', null, '0.1', 'all' );
		wp_enqueue_style( 'admin_skin' );
	}
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// Remove the Login Page Shake
function my_login_head() {
	remove_action('login_head', 'wp_shake_js', 12);
	
	$subdomain_array = explode('.', $_SERVER['HTTP_HOST']);
	$addbodyclasses = $subdomain_array[0];

}
add_action('login_head', 'my_login_head');
	
}

function add_to_author_profile( $contactmethods ) {
	$contactmethods['google_profile'] = 'Google Profile URL';
	$contactmethods['twitter_profile'] = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
	$contactmethods['instagram_profile'] = 'Instagram Profile URL';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);



/* add ability to track users liked posts */
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Sites joined</h3>

	<table class="form-table">

		<tr>
			<th><label for="sites_joined">Sites Joined</label></th>

			<td>
				<input type="text" name="sites_joined" id="sites_joined" value="<?php echo esc_attr( get_the_author_meta( 'sites_joined', $user->ID ) ); ?>" class="regular-text" /><br />
				
				<?php
												
						
												print_r( get_the_author_meta( 'sites_joined', $user->ID ));
												
												
												
												?>
				
			</td>
		</tr>

	</table>

	<h3>Liked Posts test</h3>

	<table class="form-table">
		
		

		<tr>
			<th><label for="liked_posts">Liked Posts</label></th>

			<td>
				<input type="text" name="liked_posts" id="liked_posts" value="<?php echo esc_attr( get_the_author_meta( 'liked_posts', $user->ID ) ); ?>" class="regular-text" /><br />
				
				<?php
												
						
												print_r( get_the_author_meta( 'liked_posts', $user->ID ));
												
												 $comma_separated = implode(",", get_the_author_meta( 'liked_posts', $user->ID ));
												
												echo '----';
												
												echo $comma_separated;
												
												echo '----';
												
												?>
				
			</td>
		</tr>

	</table>
<?php }



/* Social Login: Action called before redirecting the user -------------*/

//This function will be called before Social Login redirects the user
function oa_social_login_do_before_user_redirect ($user_data, $identity, $redirect_to){ ?>
	<script>
	
	
	window.location = "../../../../wp-admin?nav=0"; 
	
	</script>
	<?php
	
	exit;
	
}
add_action ('oa_social_login_action_before_user_redirect', 'oa_social_login_do_before_user_redirect', 10, 3);






// delete transients (caches) every time a post is updated or created
function clearAllGeoCaches( ) {

	// clear transient posts cache
	delete_transient( 'geob_all_bubbles_location' );
	delete_transient( 'html_bubble_query' );
	
}
add_action( 'save_post', 'clearAllGeoCaches' );











//Set custom roles for new users
function oa_social_login_set_new_user_role ($user_role)
{
  //This is an example for a custom setting with one role
  $user_role = 'author';
   

 
  //The new user will be created with this role
  return $user_role;
}
 
//This filter is applied to the roles of new users
add_filter('oa_social_login_filter_new_user_role', 'oa_social_login_set_new_user_role');




//Handle data retrieved from a social network profile
function oa_social_login_store_extended_data ($user_data, $identity)
{
    update_user_meta ($user_data->id, 'gender', $identity->gender);
}
add_action ('oa_social_login_action_after_user_insert', 'oa_social_login_store_extended_data', 10, 2);
 





function give_role_to_user($login) {
	
	
	$user = get_user_by('login',$login);
    $user_ID = $user->ID;
	
	
	
    //do something with the User ID
	
	add_user_meta( $user_ID, '_new_user', '1' );
	
	
	wp_update_user( array( 'ID' =>  $user_ID, 'role' => 'author' ) );
    	
}
add_action('wp_login', 'give_role_to_user',10, 3);






/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		 $user_ID = '?userid=' . $user->ID;
		
		$url_to_use = '../../../../../../wp-admin/' . $user_ID;
		
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $url_to_use;
		} else {
			return $url_to_use;
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );



	


/* remove width and height from images outputted from media editor in WP (MEANS OK ON NATIVE APPS WEBVIEWS) ======================== */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}






function ACFFrontendForm($acf_field_group_id_array,$custom_top_html,$custom_bottom_html){

	
	
	$settings = array(

		/* (string) Unique identifier for the form. Defaults to 'acf-form' */
		'id' => 'acf-form',

		/* (int|string) The post ID to load data from and save data to. Defaults to the current post ID. 
		Can also be set to 'new_post' to create a new post on submit */
		'post_id' => 'new_post',

		/* (array) An array of post data used to create a post. See wp_insert_post for available parameters.
		The above 'post_id' setting must contain a value of 'new_post' */
		'new_post' => array(
							'post_type'		=> 'si_property',
							'post_status'		=> 'publish'
						),
		/* 
		'submit_value'		=> 'Create a new event'

		/* (array) An array of field group IDs/keys to override the fields displayed in this form */
		'field_groups' => false,

		/* (array) An array of field IDs/keys to override the fields displayed in this form */
		'fields' => 'field_52ea3d1db89f9',

		/* (boolean) Whether or not to show the post title text field. Defaults to false */
		'post_title' => false,

		/* (boolean) Whether or not to show the post content editor field. Defaults to false */
		'post_content' => false,

		/* (boolean) Whether or not to create a form element. Useful when a adding to an existing form. Defaults to true */
		'form' => false,

		/* (array) An array or HTML attributes for the form element */
		'form_attributes' => array(),

		/* (string) The URL to be redirected to after the form is submit. Defaults to the current URL with a GET parameter '?updated=true'.
		A special placeholder '%post_url%' will be converted to post's permalink (handy if creating a new post)
		A special placeholder '%post_id%' will be converted to post's ID (handy if creating a new post) */
		'return' => '%post_id%',

		/* (string) Extra HTML to add before the fields */
		'html_before_fields' => '',

		'html_after_fields' => '',

		/* (string) The text displayed on the submit button */
		'submit_value' => __("Update", 'acf'),

		/* (string) A message displayed above the form after being redirected. Can also be set to false for no message */
		'updated_message' => __("Post updated", 'acf'),

		/* (string) Determines where field labels are places in relation to fields. Defaults to 'top'. 
		Choices of 'top' (Above fields) or 'left' (Beside fields) */
		'label_placement' => 'top',

		/* (string) Determines where field instructions are places in relation to fields. Defaults to 'label'. 
		Choices of 'label' (Below labels) or 'field' (Below fields) */
		'instruction_placement' => 'label',

		/* (string) Determines element used to wrap a field. Defaults to 'div' 
		Choices of 'div', 'tr', 'td', 'ul', 'ol', 'dl' */
		'field_el' => 'div',

		/* (string) Whether to use the WP uploader or a basic input for image and file fields. Defaults to 'wp' 
		Choices of 'wp' or 'basic'. Added in v5.2.4 */
		'uploader' => 'wp',

		/* (boolean) Whether to include a hidden input field to capture non human form submission. Defaults to true. Added in v5.3.4 */
		'honeypot' => true,

		/* (string) HTML used to render the updated message. Added in v5.5.10 */
		'html_updated_message'	=> '<div id="message" class="updated"><p>%s</p></div>',

		/* (string) HTML used to render the submit button. Added in v5.5.10 */
		'html_submit_button'	=> '<input type="submit" class="acf-button button button-primary button-large" value="%s" />',

		/* (string) HTML used to render the submit button loading spinner. Added in v5.5.10 */
		'html_submit_spinner'	=> '<span class="acf-spinner"></span>',

		/* (boolean) Whether or not to sanitize all $_POST data with the wp_kses_post() function. Defaults to true. Added in v5.6.5 */
		'kses'	=> true

	);
	
	// start bootstrap card
	$acf_field_group_ids = implode("-",$acf_field_group_id_array);
	echo '<div class="card post-' . $acf_field_group_ids . '"><div class="card-block">';
	
	// add custom start html
	echo $custom_top_html;
	
	// render ACF FORM
	acf_form($settings);
	
	// add acf submit form button
	echo '<!-- div class="acf-form-submit">
				<input type="submit" class="acf-button button button-primary button-large" value="Next">
				<span class="acf-spinner"></span>
			</div -->';
	
	// add acf submit form button

			//echo	'<button class="allergenie-next" value="Allegenie Next Slide"></button>';
				

		
	// add custom end html
	echo $custom_bottom_html;
	
	// end bootstrap card
	echo '</div></div>';
	
}







/////////// neew ///////////////////////

add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function my_acf_json_load_point( $paths ) {
    
   	$subdomain_array = explode('.', $_SERVER['HTTP_HOST']);
	$site_uid = $subdomain_array[0];
	
	// remove original path (optional)
    unset($paths[0]);
    
    
	if($site_uid == 'ricmax'){
		 $paths[] = get_stylesheet_directory() . '/acf-json-ricmax';
	}else{
		 $paths[] = get_stylesheet_directory() . '/acf-json';
	}
   
    // return
    return $paths;
    
}


?>








