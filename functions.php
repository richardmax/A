<?php
/**
 * wordpress.theme-communio-js functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wordpress.theme-communio-js
 */

if ( ! function_exists( 'wordpress_theme_communio_js_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wordpress_theme_communio_js_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wordpress.theme-communio-js, use a find and replace
		 * to change 'wordpress-theme-communio-js' to the name of your theme in all the template files.
		 */
		//load_theme_textdomain( 'wordpress-theme-communio-js', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		//add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		/*register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wordpress-theme-communio-js' ),
		) );
		*/
		
		// This theme uses wp_nav_menu() in two locations
		register_nav_menus( array(
			'app' => esc_html__( 'App Menu', 'mashboardv1' ),
			'user' => esc_html__( 'User Menu', 'mashboardv1' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wordpress_theme_communio_js_custom_background_args', array(
			'default-color' => '000000',
			'default-image' => '',
		) ) );
		
		/*

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		*/

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		
		/*add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		*/
	}
endif;
add_action( 'after_setup_theme', 'wordpress_theme_communio_js_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wordpress_theme_communio_js_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'wordpress_theme_communio_js_content_width', 640 );
}
add_action( 'after_setup_theme', 'wordpress_theme_communio_js_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
/*function wordpress_theme_communio_js_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wordpress-theme-communio-js' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wordpress-theme-communio-js' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wordpress_theme_communio_js_widgets_init' );
*/

/**
 * Enqueue scripts and styles.
 */
function wordpress_theme_communio_js_scripts() {
	wp_enqueue_style( 'wordpress-theme-communio-js-style', get_stylesheet_uri() );

	/*
	
	wp_enqueue_script( 'wordpress-theme-communio-js-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wordpress-theme-communio-js-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	*/
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	
}
add_action( 'wp_enqueue_scripts', 'wordpress_theme_communio_js_scripts' );

/**
 * Implement the Custom Header feature.
 */
/*require get_template_directory() . '/inc/custom-header.php';*/

/**
 * Custom template tags for this theme.
 */
/*require get_template_directory() . '/inc/template-tags.php';*/

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
/*require get_template_directory() . '/inc/template-functions.php';*/

/**
 * Customizer additions.
 */
/*require get_template_directory() . '/inc/customizer.php';*/

/**
 * Load Jetpack compatibility file.
 */
/*if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
*/

// BESPOKE MAIN FUNCTIONS CODE ===================================================================================

// load acf fields ----------------------------------------------------------------------------- */
require 'acf-fields.php';

/* cleanup html head (speed up) ---------------------------------------------------------------- */
function webapp_head_cleanup() {
	remove_action('wp_head', 'wp_shortlink_wp_head');        // #4

	// category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'webapp_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'webapp_remove_wp_ver_css_js', 9999 );
	
	add_filter('the_generator', '__return_false');            // #6
    add_filter('show_admin_bar','__return_false');            // #7
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // #8
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
  	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );

	// cleaning up random code around images
	add_filter( 'the_content', 'webapp_filter_ptags_on_images' );
	add_filter('acf_the_content', 'webapp_filter_ptags_on_images');
	
	
	
	//
	
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
	

	
}

/* cleanup theme ---------------------------------------------------------------- */
function cleanup_theme() {
  // launching operation cleanup
  add_action( 'init', 'webapp_head_cleanup' );
}
add_action( 'after_setup_theme', 'cleanup_theme' );

/* remove WP version from scripts ------------------------------------------------ */
function webapp_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

/* why wrap images with <p -------------------------------------------------------- */
function webapp_filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}



// BESPOKE MASHBOARD FUNCTIONS CODE ================================================================================

// load acf fields ----------------------------------------------------------------------------- */

/* convert hex to rgb so can add alphas via css etc ----------------------------- */
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function mashboard_enqueue() {
	
update_post_meta( 2, '_wp_page_template', 'page-webapp.php' );	
	
if ( ! is_admin() ) {
	
	wp_register_style( 'nexus_stylesheet', get_stylesheet_directory_uri().'/css/nexus.css', null, '0.1', 'all' );
	wp_enqueue_style( 'nexus_stylesheet' );
	
	// rest
	wp_register_style( 'mashboard_make_app', get_stylesheet_directory_uri().'/css/app.css', null, '0.1', 'all' );
	wp_enqueue_style( 'mashboard_make_app' );
	wp_register_style( 'app_skin', get_stylesheet_directory_uri().'/css/skin.css', null, '0.1', 'all' );
	wp_enqueue_style( 'app_skin' );
	wp_register_style( 'app_dynamic', get_stylesheet_directory_uri().'/css/dynamic.css', null, '0.1', 'all' );
	wp_enqueue_style( 'app_dynamic' );
	wp_register_style( 'brand', get_stylesheet_directory_uri().'/css/brand.css', null, '0.1', 'all' );
	wp_enqueue_style( 'brand' );
}else{
	// add admin styling - #wpadminbar etc - if not an admin
	if( !current_user_can('edit_others_pages') ) { 
		wp_register_style( 'admin_branding', get_stylesheet_directory_uri().'/css/admin_branding.css', null, '0.2', 'all' );
		wp_enqueue_style( 'admin_branding' );
	}else { 
		wp_register_style( 'admin_branding_admin', get_stylesheet_directory_uri().'/css/admin_branding_admin.css', null, '0.3', 'all' );
		wp_enqueue_style( 'admin_branding_admin' );
	}
	wp_register_style( 'brand', get_stylesheet_directory_uri().'/css/brand.css', null, '0.1', 'all' );
	wp_enqueue_style( 'brand' );
}

	function gnmenu_init() {
		wp_register_script('classie_script', get_template_directory_uri() . '/js/classie.js', null, '', true );
		wp_enqueue_script( 'classie_script');
		wp_register_script('gnmenu_script', get_template_directory_uri() . '/js/gnmenu.js', null, '', true );
		wp_enqueue_script( 'gnmenu_script');
		
		if(is_home() || is_archive()){
			wp_register_script('isotope_script', get_template_directory_uri() . '/js/isotope.pkgd.min.js', null, '', true );
			wp_register_script('packery_script', get_template_directory_uri() . '/js/packery.pkgd.min.js', null, '', true );
			wp_register_script('api_script', get_template_directory_uri() . '/js/api-posts.js', null, '', true );
			wp_enqueue_script( 'isotope_script');
			wp_enqueue_script( 'packery_script');
			wp_enqueue_script( 'api_script');					
		}
		
		

		if(function_exists('is_bbpress')){
			$i_am_bb_press = is_bbpress();
		}else{
			$i_am_bb_press = null;
		}

		if(!is_single() ||  $i_am_bb_press == true){?>
			<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					
					$( "nav" ).mouseleave(function() {
			
						$(".content-block").removeClass("cover");
						$(".gn-menu-wrapper").removeClass("gn-open-all");
						$("header span.app-logo").removeClass("fade");
						
					});
					
					$( ".gn-menu-wrapper" ).mouseover(function() {
					
						$(".content-block").addClass("cover");
						$("header span.app-logo").addClass("fade");
				
					});
					
					$( "#container" ).removeClass( "grid3d" );
					if(document.getElementById('gn-menu')){
						new gnMenu( document.getElementById( 'gn-menu' ) );
					}
					if(document.getElementById('gn-menu1')){
						new gnMenu( document.getElementById( 'gn-menu1' ) );
					}
					
					$('.menu-item-object-custom a').click(function() {
						$(".gn-menu-wrapper").removeClass("gn-open-all");
						$(".menu-item-object-custom").removeClass("current_page_item");
						$(".menu-item-object-page").removeClass("current_page_item");
						$(this).parent().addClass('current_page_item');
					})
					
					$('.menu-item-object-page a').click(function() {
						$(".gn-menu-wrapper").removeClass("gn-open-all");
						$(".menu-item-object-custom").removeClass("current_page_item");
						$(".menu-item-object-page").removeClass("current_page_item");
						$(this).parent().addClass('current_page_item');
					})
					
				})
			})(jQuery);
			</script><?php
		}else{ // single page 

?>
			<script type="text/javascript">

				(function($) {
				var $links = $('#comment');
				$links.click(function(){
				   $('#respond').addClass('showme');
				});
				})(jQuery);
					
			</script><?php
		}
		
		global $post;
		wp_localize_script('my-script', 'my_script_vars', array(
                'postID' => $post->ID
            )
        );
		
		if(is_single() || is_home()){ 
		
        global $post;
		global $users_liked_posts;
		global $users_sites_joined;
    	
			
		
        //wp_enqueue_script('my-script', get_stylesheet_directory_uri() . '/_wp-api/js/interactions.js', array('jquery'), 0.1, true);
        wp_localize_script('my-script', 'wp_js_vars', array(
                'postID' => $post->ID,
				'userID' => get_current_user_id(),
				'liked_posts' => $users_liked_posts
            )
        );
			
		wp_localize_script('my-script1', 'wp_js_vars1', array(
                'postID' => $post->ID,
				'userID' => get_current_user_id(),
				'sites_joined' => $users_sites_joined
            )
        );

		}
		
	} //end gnmenu_init
add_action('wp_footer', 'gnmenu_init');	
	
}
add_action( 'init', 'mashboard_enqueue' );
//end mashboard_enqueue


// LOAD THE CUSTOMISER ON A ACF OPTIONS PAGE - KERRANG - LATERAL THINKING ROCKS RICCY!!!!! - WIX FOR MOBILE IS FINALLY HERE
function wporg_current_screen_example( $current_screen ) {
	
	if($current_screen->base == 'toplevel_page_acf-options-options' ){ echo "
		<style type='text/css'>
		#adminmenuwrap {
			position: fixed !important;
		}
		#wpbody-content {
			    float: right !important;
    width: calc(45% ) !important;
    /* height: 100%; */
    margin-top: 0px;
    /* position: fixed; */
    background-color: #e5e5e5;
	padding-bottom:0px !important;
    padding: 0px;
		}
		#postbox-container-2 {
    height: 100%;
    background-color: #fff;
}
		#poststuff {
			min-width: 0% !important;
		}
		
		#postbox-container-2 {
    height: calc(100% - 100px);
	}
	
		.wrap h1 {
			display: none;
		}
		#poststuff #post-body.columns-2 {
			margin-right: 0px !important;
		}
		#major-publishing-actions {
			padding: 0 !important;
			border-top: none !important;
			background: none !important;
		}
		.acf-tab-group li {
 width: 16.65%;
    margin: 0  !important;
}

.acf-tab-group li a {
    padding: 20px !important;
    text-align: center !important;
    line-height: 50px !important;
    border: #ccc solid 1px !important;
    border-radius: 0 !important;
}
		#submitdiv.postbox {
			min-width: 0px !important;
			border: 0px !important;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			background: none !important;
		}
		.postbox {
			background: none !important;
			border: none !important;
		}
		#poststuff h2 {
			display: none !importnat;
		}
		.js .postbox .hndle, .js .widget .widget-top {
			cursor: inherit !important;
		}
		.acf-fields {
			background: #fff;
		}
		.acf-fields>.acf-field {
			/*border-left:1px solid #cccccc; border-right:1px solid #cccccc; */
			border: 0px !important;
		}
		.acf-postbox>.hndle:hover .acf-hndle-cog, .acf-postbox>.hndle.hover .acf-hndle-cog, #postbox-container-2 .handlediv, acf-js-tooltip {
			display: none !important;
		}
		#post-body.columns-2 #side-sortables {
			min-height: 0px !important;
		}
		.acf-fields>.acf-tab-wrap .acf-tab-group {
			padding: 0px !important;
		}
		#submitdiv .handlediv, #submitdiv .toggle-indicator, #submitdiv .ui-sortable-handle {
			display: none !important;
		}
		#ifm-customizer {
			padding: 0%;
			background: #333;
			    height: calc(100% - 60px);
			
			float: left;
			position: fixed;
			width: calc(60% - 160px);
			/*left: calc(160px + 12%);*/
			left: 160px;
    	    border-right: 1px solid #dddddd;
			z-index: 999999999999999;
		}
		
		#wpbody-content {
    background-color: #eeeeee;
}


		.hndle {
			display: none !important;
		}		
	</style>";
		
	echo "<iframe id='ifm-customizer' src='../../../wp-admin/customize.php?return=%2Fwp-admin%2Fthemes.php' width='100%' height='100%'></iframe>";
		
	}
}
add_action( 'current_screen', 'wporg_current_screen_example' );








// custom nav walker start ============================================
class themeslug_walker_nav_menu extends Walker_Nav_Menu {
	
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );
	public $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		$urltoopen = null;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li' . $id . $class_names .'>';
		$atts = array();	
		$atts['title']  = ! empty( $item->post_title ) ? $item->post_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )       ? $item->url        : '';
		
		/* hack start - now we need to pass the click url back into the function name so the webapp javascript can run as required */
		$atts['href']   = '';
		$menu_item_action_type = get_field('menu_item_action_type',$item->object_id);
		
		$auto_generated_menu_item = null;
			
		if($menu_item_action_type == null){
			// this is an auto generated menu item (ie not added as a page)
			$auto_generated_menu_item = true;
		}
		
		$javascriptfunction = null;
		
		if($auto_generated_menu_item == true){
			$urltoopen = $item->url;
			$functionname  = 'load_iframe';
			$javascriptfunction = $functionname . "('" . $urltoopen . "')";
		}else{
			// normal user added wp page
			if($menu_item_action_type == 'weburl'){
				$menu_item_url_type = get_field('menu_item_url_type',$item->object_id);
				if($menu_item_url_type == 'self'){
					//$urltoopen = $item->url . '?nav=0';
					$urltoopen = $item->url;
				}else if($menu_item_url_type == 'module'){
					// ensure opens from root of site
					$urltoopen = '../../../../../' . get_field('menu_item_action_parameter',$item->object_id);
				}else{
					// 'shortcode etc - just get the pages url for now - could be useful in future to do something clever'
					$urltoopen = $item->url;
				}
				$functionname  = 'load_weburl';
				$javascriptfunction = $functionname . "('" . $urltoopen . "')";
			}

			if($menu_item_action_type == 'html' || $menu_item_action_type == ''){
				// blank or '' = the user menu items that arent set as pages... they are auto generated menu items
				//$urltoopen = $item->url  . '?nav=0';
				$urltoopen = $item->url;
				$functionname  = 'load_weburl';
				$javascriptfunction = $functionname . "('" . $urltoopen . "')";
			}

			if($menu_item_action_type == 'native'){
				$menu_item_action_parameter = get_field('menu_item_action_parameter',$item->object_id);
				if($menu_item_action_parameter == 'show_feed()'){
					$urltoopen = '../../../../';
				}
				if($menu_item_action_parameter == 'show_map()'){
					$urltoopen = '/map';
				}
				$functionname  = 'load_weburl';
				$javascriptfunction = $functionname . "('" . $urltoopen . "')";
			}
		}
		
		
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$item_output = $args->before;
		
		
		//$item_output .= 'miat: ' . $menu_item_action_type;
		
		
		$item_output .= '<a ';
	//	if($menu_item_action_type == 'weburl' || $menu_item_action_type == 'html' || $menu_item_action_type == ''){
			//nb. blank / menuitemtype = '' = the user menu items that arent set as pages... they are auto generated menu items
			//use an iframe - useful!
			$item_output .= 'target="iframe_a" ';
	//	}
		
		/*
		
		if($menu_item_action_type == 'native'){
			//use an iframe - useful!
			$item_output .= 'onclick="' . get_field('menu_item_action_parameter',$item->object_id)  . '" ';
		}else
			
		*/
		
		//if($menu_item_action_type == 'weburl' || $menu_item_action_type == 'html' || $menu_item_action_type == '' ){
			// blank or '' = the user menu items that arent set as pages... they are auto generated menu items
			$item_output .= 'onclick="' . $javascriptfunction . '" ';
		//}
		
		
		if($auto_generated_menu_item == true){
			
			$icon_url = $item->description;
			$item_output .= 'class="gn-icon gn-icon-article" style="background-image: url(' . $icon_url .  ')!important " ';
			
		}else{
			
			$icon_url = get_field('menu_item_icon',$item->object_id);
		
			
			
			if($icon_url){
				$item_output .= 'class="gn-icon gn-icon-article" style="background-image: url(' . $icon_url .  ')!important " ';
			}else{
				$item_output .= 'class="gn-icon gn-icon-article no-icon"';
			}
			
		}
		
		
		
		
		
		
		
		$item_output .= $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		//print_r($item);
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
















































/*

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  $required_array = array(
  
  	  'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  
  );
	
	return $required_array;

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

*/


// add excerpts to pages
add_post_type_support( 'page', 'excerpt' );


// expose extra data TO THE WP-JSON API
$args = array(
    'show_in_rest' => true,
);
register_meta( 'post', 'geo_longitude', $args );
register_meta( 'post', 'geo_latitude', $args );
register_meta( 'post', 'geo_address', $args );  
register_meta( 'post', 'like', $args );  
register_meta( 'post', 'geob_upvotes', $args );  
register_meta( 'post', 'geob_downvotes', $args );  

//cpt ----------------------------------------------------------------------------- 
require '_cpt/directory.php';
//require '_cpt/product.php';
//require '_cpt/companies.php';

//api ----------------------------------------------------------------------------- 
require '_wp-api/api.php';

//extra functions ----------------------------------------------------------------------------- 
require 'functions-extra.php';

//extra functions ----------------------------------------------------------------------------- 
require 'gutenberg.php';

//pwa ----------------------------------------------------------------------------- 
require '_pwa/functions.php';


?>