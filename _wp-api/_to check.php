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

	// http://admin.v-marketing.co.uk/wp-json/geobubble/v1/bubbles/type/media/location/51.533889/-0.221576/400
	register_rest_route( $namespace, '/bubbles/type/(?P<bubble_type>[\w\-\_]+)/location/(?P<latitude>[\d\D]*)/(?P<longitude>[\d\D]*)/(?P<radiusfactor>[\d\D]*)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_type_location',
	) );
	
	// http://admin.v-marketing.co.uk/wp-json/geobubble/v1/bubbles/location/51.533889/-0.221576/400
	register_rest_route( $namespace, '/bubbles/location/(?P<latitude>[\d\D]*)/(?P<longitude>[\d\D]*)/(?P<radiusfactor>[\d\D]*)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_location',
	) );
	
	// http://admin.v-marketing.co.uk/wp-json/geobubble/v1/bubbles/type/alert
	register_rest_route( $namespace, '/bubbles/type/(?P<bubble_type>[\w\-\_]+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_type',
	) );
	
	// http://admin.v-marketing.co.uk/wp-json/geobubble/v1/bubbles/author/31
	register_rest_route( $namespace, '/bubbles/author/(?P<id>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_bubbles_author',
	) );
	
	register_rest_route( $namespace, '/list-posts/', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_posts',
	) );

	register_rest_route( $namespace, '/vote/', array(
		'methods'  => 'POST',
		'callback' => 'geob_process_vote',
	) );
	
	
	// http://admin.v-marketing.co.uk/wp-json/geobubble/v1/bubbles/oembed/9138
	register_rest_route( $namespace, '/bubble/(?P<id>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'geob_get_single_bubble',
	) );
}

function geob_get_bubbles_type_location($request) {
	
	/*
	
	// You can access parameters via direct array access on the object:
	$param = $request['some_param'];

	// Or via the helper method:
	$param = $request->get_param( 'some_param' );

	// You can get the combined, merged set of parameters:
	$parameters = $request->get_params();

	// The individual sets of parameters are also available, if needed:
	$parameters = $request->get_url_params();
	$parameters = $request->get_query_params();
	$parameters = $request->get_body_params();
	$parameters = $request->get_default_params();

	// Uploads aren't merged in, but can be accessed separately:
	$parameters = $request->get_file_params();
	
	*/
	
	
	if ( 0 || false === $return ) {
		
		$query = apply_filters( 'geob_get_bubbles_type_location_query', array(
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

		// cache for 10 minutes
		set_transient( 'geob_all_bubbles_type_location', $result, apply_filters( 'geob_bubbles_type_location_ttl', 60 * 10 ) );
	}
	
	
	
	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}

function geob_get_bubbles_location($request) {
	
	// transisnets only work for identical queries
	
	// therefore for fixed location apps its ok so have x2 apis one fixed one not
	
	delete_transient( 'geob_all_bubbles_location' );
	
	if ( 0 || false === ( $result = get_transient( 'geob_all_bubbles_location' ) ) ) {
		
		$query = apply_filters( 'geob_get_bubbles_location_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
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
			
			//print_r($return);
			
			$acf = get_fields($post->ID);
			
			//print_r($acf);
			
			$result[] = array_merge($return, $acf);
			
		}

		// cache for 10 minutes
		set_transient( 'geob_all_bubbles_location', $result, 60 );
	}

	if(!$result){
		$result[] = array('title' => 'No Content Available','message' => 'No content has been found in your current location. Please either create some content try later at another location. Thank You.');
	}
	
	
	
	
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
	
}

function geob_get_bubbles_type($request) {
	
	if ( 0 || false === ( $return = get_transient( 'geo_all_bubbles_type' ) ) ) {
		$query     = apply_filters( 'geob_get_bubbles_type_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
			//'author' => $request['id'],
			'meta_key'		=> 'bubble_type',
			'meta_value'	=> $request['bubble_type'],
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

		// cache for 10 minutes
		set_transient( 'geob_all_bubbles_type', $result, apply_filters( 'geob_bubbles_type_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}


function geob_get_bubbles_author($request) {
	
	if ( 0 || false === ( $return = get_transient( 'geo_all_bubbles_author' ) ) ) {
		$query     = apply_filters( 'geob_get_bubbles_author_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
			'author' => $request['id'],
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

		// cache for 10 minutes
		set_transient( 'geob_all_bubbles_author', $result, apply_filters( 'geob_bubbles_author_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}


function geob_get_single_bubble($request) {
	
	if ( 0 || false === ( $return = get_transient( 'geo_all_bubbles_oembed' ) ) ) {
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

		// cache for 10 minutes
		set_transient( 'geob_all_bubbles_oembed', $result, apply_filters( 'geob_bubbles_oembed_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}





function geob_get_posts() {
	
	
	
	if ( 0 || false === ( $return = get_transient( 'geo_all_posts' ) ) ) {
		$query     = apply_filters( 'geob_get_posts_query', array(
			'numberposts' => 100,
			'post_type'   => 'post',
			'post_status' => 'publish',
		) );
		$all_posts = get_posts( $query );
		
		//print_r($all_posts);
		
		
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

		// cache for 10 minutes
		set_transient( 'geob_all_posts', $result, apply_filters( 'geob_posts_ttl', 60 * 10 ) );
	}
	$response = new WP_REST_Response( $result );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}


function geob_process_vote() {
	$vote    = $_POST['vote'];
	//$post_id = $_POST['id'];
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
	delete_transient( 'geob_all_posts' );
	delete_transient( 'geob_all_bubbles_type' );
	delete_transient( 'geob_all_bubbles_author' );
	delete_transient( 'geob_all_bubbles_location' );
	delete_transient( 'geob_all_bubbles_type_location' );
	
	$response = new WP_REST_Response( $update_success );
	$response->header( 'Access-Control-Allow-Origin', apply_filters( 'geob_access_control_allow_origin', '*' ) );

	return $response;
}