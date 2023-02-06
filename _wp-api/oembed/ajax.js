function urlParam(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}

var post_id = urlParam('id');
var myroute = 'posts/' + post_id + '/';
var geob_settings = {
	api_base: '../../../../../wp-json/wp/v2/',
	endpoints: {
		posts: { route: myroute, method: 'GET' }
	}
}

var $el;
var posts = {};

function getPostsFromServer( callback ) {
	doAjax( geob_settings.endpoints.posts, {} )
		.done( function( data ) {
			posts = data;
			if ( 'function' === typeof callback ) {
				callback.call();
			}
		} );
}

function showPost( post ) {
	
	//STANDARD WP
	$el.find( '.title span' ).text( post.title.rendered );
	$el.find( '.date span' ).text( post.date );
	$el.find( '.id span' ).text( post.id );
	$el.find( '.link span' ).text( post.link );
	$el.find( '.author span' ).text( post.author );
	$el.find( '.categories span' ).text( post.categories );
	$el.find( '.tags span' ).text( post.tags );
	$el.find( '.format span' ).text( post.format );
	
	//ACF WP (CUSTOM META - TODO -PORT TO REDUX FRAMEWORK)
	$el.find( '.latitude span' ).text( post.acf.latitude );
	$el.find( '.longitude span' ).text( post.acf.longitude );
	$el.find( '.likes span' ).text( post.acf.likes );
	$el.find( '.radius span' ).text( post.acf.radius );
	$el.find( '.shares span' ).text( post.acf.shares );
	$el.find( '.trending span' ).text( post.acf.trending );
	$el.find( '.views span' ).text( post.acf.views );
	$el.find( '.bubble_type span' ).text( post.acf.bubble_type );
	
	// ACF WP - BUBBLE TYPE SPECIFIC
	$el.find( '.url_type span' ).text( post.acf.url_type );
	$el.find( '.url span' ).html( post.acf.url );
	
}

function doAjax( endpoint, data ) {
	return $.ajax( {
		url: geob_settings.api_base + endpoint.route,
		method: endpoint.method,
		data: data
	} );
}

$( function() {
	$el = $( '.container' );
	getPostsFromServer( initAfterAjax );
	function initAfterAjax() {
		showPost( posts );		
	}
} );