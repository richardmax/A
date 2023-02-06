<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package wordpress.theme-communio-js
 */

?>

<?php
	
	$sites_no_login = 'ricmax'; // no login required / public facing app/site
	$sites_no_menu = 'ricmax'; // no login required / public facing app/site

	// determines wether to load header and menus etc (extra weight not required by native)
	global $isItNative;
	global $users_liked_posts;
	global $users_sites_joined;
	global $site_uid;
	
	$url = $_SERVER["REQUEST_URI"];
	$isItNative = strpos($url, 'nav=0');
	
	/* hack */
	if( !$isItNative ){
		$isItNative = strpos($_SERVER["REQUEST_URI"], '/?/'); // this is a clunky hack to ensure no nav ius visible on comments on a topic in bbpress (see template.php in bbpress)
	}

	$isWebApp = strpos($url, 'web-app');
	$isFlexHeight = strpos($url, 'flexheight');
	// needed as wp activate page is a mare re files - see google rants!!!!
	$isSignup = strpos($url, 'local-signup');
	$isActivate = strpos($url, 'wp-activate.php');
	$addbodyclasses = '';
	$subdomain_array = explode('.', $_SERVER['HTTP_HOST']);
	$site_uid = $subdomain_array[0];
	$addbodyclasses = $site_uid;

	if($isItNative || ($site_uid == $sites_no_menu)){
		$addbodyclasses .= ' native '; // native nmeans no menu
	}else{
		$addbodyclasses .= ' web ';
	}
	if($isFlexHeight){
		$addbodyclasses .= ' flexheight ';
	}
	if(wp_is_mobile()){
		$addbodyclasses  .= ' mobile ';
	}
	
	$addbodyclasses  .= get_post_field( 'post_name', get_post() );

	$bodyclass = 'frontend ' . $addbodyclasses;
	$users_liked_posts = [get_user_meta( get_current_user_id(), 'liked_posts', true )];
	$users_sites_joined = [get_user_meta( get_current_user_id(), 'sites_joined', true )];

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if(is_page('acf')){
		acf_form_head(); 
	}else{
	//
}
	?>
<?php wp_head(); ?>

<script>

	function load_iframe(url_var) {
		
		url_var = url_var + '?nav=0';
		jQuery('#app_iframe').remove();
		jQuery('<iframe>', {
			src: url_var,
			class: 'app_iframe fadein',
			name: 'iframe_a',
			id: 'app_iframe',
			frameborder: 0,
			scrolling: 'yes',
		}).appendTo('body');

	}
	
	function load_weburl(url_var,target) {
		
		if(target == '_blank'){
			window.open(url_var,'_blank');
		}else{
			// _self
			window.location.href = url_var;
		}
		
	}

</script>

<?php if(!$isActivate && !$isSignup){include 'css/dynamic.css.php';} ?>
	
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/css/login.css' ?>" type="text/css" media="all">
<!--link rel="stylesheet" href="<?php //echo get_stylesheet_directory_uri() . '/_libraries/bootstrap/css/bootstrap.min.css' ?>" type="text/css" media="all">	
<script type="text/javascript" src="<?php //echo get_stylesheet_directory_uri() . '/_libraries/bootstrap/js/bootstrap.min.js' ?>"></script>
<script type="text/javascript" src="<?php //echo get_stylesheet_directory_uri() . '/_libraries/slick/slick.min.js' ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php //echo get_stylesheet_directory_uri() . '/_libraries/slick/slick.css' ?>" media="all">
<link rel="stylesheet" type="text/css" href="<?php //echo get_stylesheet_directory_uri() . '/_libraries/slick/slick-theme.css' ?>"  media="all" -->
<link  rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() . '/css/print.css' ?>" media="print" >
	
</head>
	
<?php $appPostID = get_the_ID(); ?>
	
<?php
		
		//echo "<script>alert('" . $site_uid . "');</script>";
		if ( !is_user_logged_in() &&  $site_uid != $sites_no_login) {
			wp_redirect('../../../../../../wp-login.php');
		}
	
?>
	
	<body <?php body_class($bodyclass); ?> style='margin: 0 !important; padding: 0 !important;'>


		
	<header>
		
		<div class='content-block'></div>
		
<?php if($site_uid != $sites_no_menu && !$isItNative){
	require 'menu.php';
}	?>

</header>