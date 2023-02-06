<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

register_activation_hook( __FILE__, 'geob_activate' );
function geob_activate() {
	flush_rewrite_rules();
}

add_action( 'rest_api_init', 'geo_register_api_hooks' );
function geo_register_api_hooks() {
	$namespace = 'geobubble/v1';
	
	// WORKS = [DOMAIN]/https://jsv1.ge0.uk/wp-json/geobubble/v1/bubbles/location/51.533889/-0.221576/400000
	register_rest_route( $namespace, '/bubbles/location/(?P<latitude>[\d\D]*)/(?P<longitude>[\d\D]*)/(?P<radiusfactor>[\d\D]*)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_location',
	) );
	
	// [DOMAIN]/wp-json/geobubble/v1/cache/bubbles/location/51.533889/-0.221576/400
	register_rest_route( $namespace, '/cache/bubbles/location/(?P<latitude>[\d\D]*)/(?P<longitude>[\d\D]*)/(?P<radiusfactor>[\d\D]*)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_location_cached',
	) );
	
	//wp-json/geobubble/v1/bubbles/media/location
	//wp-json/geobubble/v1/bubbles/alert/location
	//wp-json/geobubble/v1/bubbles/profile/location
	//wp-json/geobubble/v1/bubbles/question/location
	
	
	
	// [DOMAIN]/wp-json/geobubble/v1/bubbles/alert/location/51.533889/-0.221576/400
	register_rest_route( $namespace, '/bubbles/(?P<bubble_type>[\w\-\_]+)/location/(?P<latitude>[\d\D]*)/(?P<longitude>[\d\D]*)/(?P<radiusfactor>[\d\D]*)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_type_location',
	) );
	
	// [DOMAIN]/wp-json/geobubble/v1/bubbles/oembed/9138
	register_rest_route( $namespace, '/bubble/(?P<id>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_single_bubble',
	) );
	
	//voting
	register_rest_route( $namespace, '/vote/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_vote',
	) );
	
	//like
	register_rest_route( $namespace, '/like/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_like',
	) );
	
	//unlike
	register_rest_route( $namespace, '/unlike/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_unlike',
	) );
	
	//join
	register_rest_route( $namespace, '/join/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_join',
	) );
	
	//leave
	register_rest_route( $namespace, '/leave/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_leave',
	) );
	
	// dymanic updating user data - get user custom data etc - just likes for now
	// URGENT - SECURITY RISK ETC - THIS NEEDS TO BE SECURE - TODO
	register_rest_route( $namespace, '/userdynamic/(?P<uid>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_process_userdata_dynamic',
	) );
	
	//static user data - only pulled once
	register_rest_route( $namespace, '/userstatic/(?P<uid>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_process_userdata_static',
	) );
	
}

function geob_get_bubbles_location($request) {
		
		$is_geo = true;
		$latitude = $request['latitude'];
		$longitude = $request['longitude'];
		$radiusfactor = $request['radiusfactor'];
		
		// check if vanilla wp - ie. no long / lat
		if($longitude == null || $longitude == 0 || $latitude == null || $latitude == 0){
			$is_geo = false;
		} 
		
		
		
		if($is_geo == true){
			// get geo posts
			$query = apply_filters( 'geob_get_bubbles_location_query', array(
				'numberposts' => 100,
				'post_type'   => 'post',
				'post_status' => 'publish',
				'meta_query' => array(
						array(
							'key' => 'latitude',
							// value should be array of (lower, higher) with BETWEEN
							//'value' => array(51.533889, 52),
							'value' => array($latitude-($radiusfactor/110000), $latitude+($radiusfactor/110000)),
							'compare' => 'BETWEEN'
						),
						array(
							'key' => 'longitude',
							// value should be array of (lower, higher) with BETWEEN
							'value' => array($longitude-($radiusfactor/110000),$longitude+($radiusfactor/110000)),
							//'value' => array(($request['longitude'])-0.001, ($request['longitude'])+0.001),
							'compare' => 'BETWEEN',
							'type'  => 'DECIMAL(10,6)',
						),
				)
			));
			
		}else{
			// get all posts
			$query =  array(
				'numberposts' => 10,
				'post_type'   => 'post',
				'post_status' => 'publish'
			);
		}
		
		$all_posts = get_posts( $query );
		$return    = array();
		foreach ( $all_posts as $post ) {
			
			$categories = get_the_category($post->ID);
			$cats = '';
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					$cats .= $category->name . ' ';
				}
			}
			
			$posttags = get_the_tags($post->ID);
			$tags = '';
			if ( ! empty( $posttags) ) {
			  foreach($posttags as $tag) {
				$tags .= $tag->name . ' '; 
			  }
			}
			
			$return = array(
				'id'        => $post->ID,
				'author' =>  $post->post_author,
				'name'      => $post->post_name,
				'title'      => $post->post_title,
				'comment_count'	=> $post->comment_count,
				'date' => $post->post_date,
				'link' => $post->guid,
				'categories' => $cats,
				'tags' => $tags,
				'upvotes'   => intval( get_post_meta( $post->ID, 'geob_upvotes', true ) ),
				'downvotes' => intval( get_post_meta( $post->ID, 'geob_downvotes', true ) ),
			);
			
			$acf = get_fields($post->ID);
			if($is_geo == true){
				$result[] = array_merge($return, $acf);
			}else{
				$result[] = $return;
			}

	}

	if(!$result){
		$result[] = array('title' => 'No Content Available','message' => 'No content has been found in your current location. Please either create some content try later at another location. Thank You.');
	}
	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
	
}


function geob_get_bubbles_location_cached($request) {
	
		$latitude = $request['latitude'];
		$longitude = $request['longitude'];
		$radiusfactor = $request['radiusfactor'];
		
		if($longitude == null || $longitude == 0){
			$longitude = get_field('app_longitude', 'option');
		}
		if($latitude == null || $latitude == 0){
			$latitude = get_field('app_latitude', 'option');
		}
		if($latitude == null || $latitude == 0){
			$radiusfactor = get_field('setting_detection_radius', 'option');
		}
	
	if ( 0 || false === ( $result = get_transient( 'geob_all_bubbles_location' ) ) ) {
		
		$query = apply_filters( 'geob_get_bubbles_location_cached_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
			'meta_query' => array(
					array(
						'key' => 'latitude',
						'value' => array($latitude-($radiusfactor/110000), $latitude+($radiusfactor/110000)),
						'compare' => 'BETWEEN'
					),
					array(
						'key' => 'longitude',
						'value' => array($longitude-($radiusfactor/110000),$longitude+($radiusfactor/110000)),
						'compare' => 'BETWEEN',
						'type'  => 'DECIMAL(10,6)',
					),
			)
		));
		
		
		$all_posts = get_posts( $query );
		$return    = array();
		foreach ( $all_posts as $post ) {
			
			$categories = get_the_category($post->ID);
			$cats = '';
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					$cats .= $category->name . ' ';
				}
			}
			
			$posttags = get_the_tags($post->ID);
			$tags = '';
			if ( ! empty( $posttags) ) {
			  foreach($posttags as $tag) {
				$tags .= $tag->name . ' '; 
			  }
			}
			
			$return = array(
				'id'        => $post->ID,
				'author' =>  $post->post_author,
				'name'      => $post->post_name,
				'title'      => $post->post_title,
				'comment_count'	=> $post->comment_count,
				'date' => $post->post_date,
				'link' => $post->guid,
				'categories' => $cats,
				'tags' => $tags,
				'upvotes'   => intval( get_post_meta( $post->ID, 'geob_upvotes', true ) ),
				'downvotes' => intval( get_post_meta( $post->ID, 'geob_downvotes', true ) ),
			);
			
			$acf = get_fields($post->ID);
			
			$result[] = array_merge($return, $acf);
			
		}
		
		// one hour cache
		set_transient( 'geob_all_bubbles_location', $result, 60 * MINUTE_IN_SECONDS );
	}

	if(!$result){
		$result[] = array('title' => 'No Content Available','message' => 'No content has been found in your current location. Please either create some content try later at another location. Thank You!');
	}
	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
	
}


function geob_get_bubbles_type_location($request) {
	
		$query = apply_filters( 'geob_get_bubbles_location_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
			'meta_key'		=> 'bubble_type',
			'meta_value'	=> $request['bubble_type'],
			'meta_query' => array(
				
					array(
						'key' => 'latitude',
						// value should be array of (lower, higher) with BETWEEN
						//'value' => array(51.533889, 52),
						'value' => array(($request['latitude'])-($request['radiusfactor']/110000), ($request['latitude'])+($request['radiusfactor']/110000)),
						'compare' => 'BETWEEN'
					),
					array(
						'key' => 'longitude',
						// value should be array of (lower, higher) with BETWEEN
						'value' => array($request['longitude']-($request['radiusfactor']/110000),$request['longitude']+($request['radiusfactor']/110000)),
						//'value' => array(($request['longitude'])-0.001, ($request['longitude'])+0.001),
						'compare' => 'BETWEEN',
						'type'  => 'DECIMAL(10,6)',
					),
					
			)
		));
	
		//$request['bubble_type']: todo
		
		$all_posts = get_posts( $query );
		$return    = array();
		foreach ( $all_posts as $post ) {
			
			$categories = get_the_category($post->ID);
			$cats = '';
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					$cats .= $category->name . ' ';
				}
			}
			
			$posttags = get_the_tags($post->ID);
			$tags = '';
			if ( ! empty( $posttags) ) {
			  foreach($posttags as $tag) {
				$tags .= $tag->name . ' '; 
			  }
			}
			
			$return = array(
				'id'        => $post->ID,
				'author' =>  $post->post_author,
				'name'      => $post->post_name,
				'title'      => $post->post_title,
				'comment_count'	=> $post->comment_count,
				'date' => $post->post_date,
				'link' => $post->guid,
				'categories' => $cats,
				'tags' => $tags,
				'upvotes'   => intval( get_post_meta( $post->ID, 'geob_upvotes', true ) ),
				'downvotes' => intval( get_post_meta( $post->ID, 'geob_downvotes', true ) ),
			);
			
			$acf = get_fields($post->ID);
			
			$result[] = array_merge($return, $acf);

	}

	if(!$result){
		$result[] = array('title' => 'No Content Available','message' => 'No content has been found in your current location. Please either create some content try later at another location. Thank You!');
	}
	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
	
}

function geob_get_single_bubble($request) {
	
		$query     = apply_filters( 'geob_get_single_bubble_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
			'post' => $request['id'],
		) );
		$all_posts = get_posts( $query );
		$return    = array();
		foreach ( $all_posts as $post ) {
			
			$categories = get_the_category($post->ID);
			$cats = '';
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					$cats .= $category->name . ' ';
				}
			}
			
			$posttags = get_the_tags($post->ID);
			$tags = '';
			if ( ! empty( $posttags) ) {
			  foreach($posttags as $tag) {
				$tags .= $tag->name . ' '; 
			  }
			}
			
			$return = array(
				'id'        => $post->ID,
				'author' =>  $post->post_author,
				'name'      => $post->post_name,
				'title'      => $post->post_title,
				'comment_count'	=> $post->comment_count,
				'date' => $post->post_date,
				'link' => $post->guid,
				// 'acf' 		=> get_fields($post->ID),
				//	_likes
				'categories' => $cats,
				'tags' => $tags,
				'upvotes'   => intval( get_post_meta( $post->ID, 'geob_upvotes', true ) ),
				'downvotes' => intval( get_post_meta( $post->ID, 'geob_downvotes', true ) ),
			);
			
			$acf = get_fields($post->ID);
			$result[] = array_merge($return, $acf);
		}

	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}

function geob_process_vote() {
	$vote    = $_POST['vote'];
	$post_id = $_POST['id'];

	// input validation
	if ( ! is_numeric( $post_id ) || ! in_array( strtolower( $vote ), array( 'up', 'down' ) ) ) {
		return false;
	}

	// @richardmax - issue was here!!!
	
	$meta_name      = 'geob_' . $vote . 'votes';
	//$meta_name      = 'giar_' . $vote . 'votes';
	
	// end
	
	$vote_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	$update_success = update_post_meta( $post_id, $meta_name, ++$vote_count ) ? true : false;

	// clear transient posts cache
	clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}

function geob_process_like() {
	$like    = $_POST['like'];
	$post_id = $_POST['id'];
	$user_id = $_POST['user'];

	// input validation
	if ( ! is_numeric( $post_id ) || ! is_numeric( $like ) || ! is_numeric( $user_id )  ) {
		return false;
	}

	$meta_name = 'likes';
  	$users_liked_posts = get_user_meta( $user_id, 'liked_posts', true ); 
	
	if(!in_array($post_id, $users_liked_posts, false)){
		$users_liked_posts[] = $post_id;
    }
	
	update_user_meta($user_id, 'liked_posts', $users_liked_posts);
	$like_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	$update_success = update_post_meta( $post_id, $meta_name, ++$like_count ) ? true : false;

	// clear transient posts cache
	clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );
	return $response;
}

function geob_process_unlike() {
	$like    = $_POST['like'];
	$post_id = $_POST['id'];
	$user_id = $_POST['user'];

	// input validation
	if ( ! is_numeric( $post_id ) || ! is_numeric( $like ) || ! is_numeric( $user_id )  ) {
		return false;
	}

	$meta_name = 'likes';
	$users_liked_posts = get_user_meta( $user_id, 'liked_posts', true ); 
	$users_liked_posts = array_diff($users_liked_posts, array($post_id));
	update_user_meta($user_id, 'liked_posts', $users_liked_posts);
	$like_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	$update_success = update_post_meta( $post_id, $meta_name, --$like_count ) ? true : false;

	// clear transient posts cache
	clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );
	return $response;
}



function geob_process_join() {
	$site_id = $_POST['site'];
	$user_id = $_POST['user'];

	// input validation
	if ( ! is_numeric( $site_id ) || ! is_numeric( $user_id )  ) {
		return false;
	}

	//$meta_name = 'sites';
  	$users_sites_joined = get_user_meta( $user_id, 'sites_joined', true ); 
	
	if(!in_array($site_id, $users_sites_joined, false)){
		$users_sites_joined[] = $site_id;
    }
	
	$update_success = update_user_meta($site_id, 'sites_joined', $users_sites_joined) ? true : false;;
	//$like_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	//$update_success = update_post_meta( $post_id, $meta_name, ++$like_count ) ? true : false;

	// clear transient posts cache
	//clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );
	return $response;
}

function geob_process_leave() {
	$site_id = $_POST['site'];
	$user_id = $_POST['user'];

	// input validation
	if ( ! is_numeric( $site_id ) || ! is_numeric( $user_id )  ) {
		return false;
	}

	//$meta_name = 'sites';
	$users_sites_joined = get_user_meta( $user_id, 'sites_joined', true ); 
	$users_sites_joined = array_diff($users_sites_joined, array($site_id));
	$update_success = update_user_meta($site_id, 'sites_joined', $users_sites_joined) ? true : false;
	//$like_count     = intval( get_post_meta( $post_id, $meta_name, true ) );
	//$update_success = update_post_meta( $site_id, $meta_name, --$like_count ) ? true : false;

	// clear transient posts cache
	//clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );
	return $response;
}




function geob_process_userdata_dynamic($request) {
	
	$user_id = $request['uid'];
	
	// input validation
	if ( ! is_numeric( $user_id ) ) {
		return false;
	}
	
  	$users_liked_posts = get_user_meta( $user_id, 'liked_posts', true );
	
	$random_user_date =  'this is just a string, demo';
	
	$all_custom_user_data = array(
		'liked_posts' => $users_liked_posts,
		'sponsors_image' => 'http://via.placeholder.com/600x600',
		'dummy_data' => $random_user_date
	);
	
	// clear transient posts cache
	//clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way
	
	$response = new WP_REST_Response( $all_custom_user_data );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	
	return $response;
}

function geob_process_userdata_static($request) {
	
	$user_id = $request['uid'];
	
	// input validation
	if ( ! is_numeric( $user_id ) ) {
		return false;
	}else{
		
		
		
		$users_avatar_as_img = get_wp_user_avatar($user_id);

		
		
		// riddiculous hack to get url of image getting first value - if plugin changes avatar will vanish - in a hurry - soz!
		$users_avatar_array = explode('"', $users_avatar_as_img);
		$users_avatar = $users_avatar_array[1]; // fails if $users_avatar_as_img value changes format

		if($users_avatar == null || $users_avatar == '' ){
			$users_avatar = get_stylesheet_directory_uri() + '/_media/avatar-blank.png';
		}
		
		

		$random_user_data =  'this is just a string, demo';

		$all_custom_user_data = array(
			'users_image' => $users_avatar,
			'sponsors_image' => 'http://via.placeholder.com/600x600',
			'dummy_data' => $random_user_data
		);
		
	

		// clear transient posts cache
		//clearAllGeoCaches(); // todo - hyper inefficnet - must be a better way

			
			
			$response = new WP_REST_Response( $all_custom_user_data );
		$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );


		return $response;
		
		
		
		
		
		
	}
	
}


