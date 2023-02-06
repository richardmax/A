
jQuery(document).ready(function(){
	 //alert(wp_js_vars.postID);	
	
			var user_id = wp_js_vars.userID; 
		var post_id = wp_js_vars.postID; // default = like this page / post
	
			
				
		/* start likes --------------------- */
	
	var geob_settings = {
		api_base: '../../../../../wp-json/geobubble/v1/',
		endpoints: {
			like: { route: 'like/', method: 'POST' },
			unlike: { route: 'unlike/', method: 'POST' }
		}
	}
	
	function likePost( post_id , user_id ) {
		doAPI( geob_settings.endpoints.like, {
			user: user_id,
			like: 1,
			id: post_id
		} );	
	}
	
	function unlikePost( post_id , user_id ) {
		doAPI( geob_settings.endpoints.unlike, {
			user: user_id,
			like: -1,
			id: post_id
		} );	
	}

	function doAPI( endpoint, data ) {
		console.log( endpoint );
		console.log( data );
		return jQuery.ajax( {
			url: geob_settings.api_base + endpoint.route,
			method: endpoint.method,
			data: data
		} );
	}

	var post_id = wp_js_vars.postID; // default = like this page / post
	var liked_posts = wp_js_vars.liked_posts;
	
	//alert(post_id);
	
	//alert(liked_posts);
			
	
	if(jQuery( 'body' ).hasClass( 'single' )){
		if(liked_posts != null && jQuery.inArray(post_id, liked_posts)!= -1){
			jQuery( '.meta-likes' ).addClass( 'is_selected' );
		}
	}
	
	
	
	jQuery( function() {
		
	
			
		
		jQuery( '.entry-meta' ).on( 'click', '.meta-likes', function( e ) {
			
			var post_id = wp_js_vars.postID; // default = like this page / post
	var liked_posts = wp_js_vars.liked_posts;
			
			if(jQuery( '#container' ).hasClass( 'grid' )){
				// this is a list of posts so need to finf the actual posts id from parent article id
				var id = jQuery(this).closest("article").prop("id");
				var post_id = id.split('-')[1];
				//alert(post_id);
			}
			
			
			
			
			
		//	alert(post_id);
			
			if(jQuery( this ).hasClass( 'is_selected' )){
				// unlike
				
				var value = parseInt(jQuery( this ).text()) - 1;
				unlikePost(post_id,user_id);
			}else{
				// like
				
				var value = parseInt(jQuery( this ).text()) + 1;
				likePost(post_id,user_id);
			}
			jQuery( this ).text(value);
			jQuery( this ).toggleClass( 'is_selected' );
		} );
	} );

	} );
		/* end likes --------------------- */
		
		
		
		
				
				
				
				
			