var geob_settings = {
	api_base: '../../../../../wp-json/geobubble/v1/',
	endpoints: {
		posts: { route: 'bubbles/location/51.533889/-0.221576/999', method: 'GET' },
		vote: { route: 'vote/', method: 'POST' },
		like: { route: 'like/', method: 'POST' }
	}
}

var $el;
var posts = {};
var votedOn = JSON.parse( localStorage.getItem( 'geob_votedOn' ) );

function getPostsFromServer( callback ) {
	
	//alert ('getPostsFromServer');
	
	doAjax( geob_settings.endpoints.posts, {} )
		.done( function( data ) {
			posts = data;
			if ( 'function' === typeof callback ) {
				callback.call();
			}
		} );
}
function getNextPost() {
	var post = posts[0];
	var current = $el.data( 'post' );
	return post;
}
function getFirstPost() {
	var post = posts[0];
	var current = $el.data( 'post' );
	return post;
}
function getRandomPost() {
	var post = posts[ Math.floor( Math.random() * posts.length ) ];
	var current = $el.data( 'post' );
	if ( 'object' == typeof current && current.id === post.id ) {
		post = getRandomPost();
	}
//	alert (post);
	return post;
}
function showPost( post ) {
	
	//alert ('showPost');
	
	// reset image - wipe the ones that vary depending on type
	$el.find( '.image' ).html('');
	$el.find( '.cost span' ).text( '' );

	
	$el.data( 'currentPost', post );
	
	// wp core
	$el.find( '.title' ).text( post.title );
	$el.find( '.categories span' ).text( post.categories );
	$el.find( '.tags span' ).text( post.tags );
	$el.find( '.comment_count' ).text( post.comment_count );
	$el.find( '.date span' ).text( post.date );
	$el.find( '.id span' ).text( post.id );
	$el.find( '.link span' ).text( post.link );
	$el.find( '.author span' ).text( post.author );
	
	// geobubble content
	$el.find( '.bubble_title span' ).text( post.bubble_title ); // @todo probably not needed as can use title - see below
	$el.find( '.name span' ).text( post.name ); // @todo this is the same as title (should use title not name in ios app so can delete - spk to shinnoy)
	$el.find( '.content' ).html( post.content );
	$el.find( '.cost span' ).text( post.cost );
	$el.find( '.image' ).html( post.image );
	
	// geobubble interactions
	$el.find( '.views span' ).text( post.views );
	$el.find( '.likes' ).text( post.likes );
	$el.find( '.interactions .up' ).text( post.upvotes );
	$el.find( '.interactions .down' ).text( post.downvotes );
	
	// geobubble meta
	$el.find( '.bubble_type  span' ).text( post.bubble_type );
	$el.find( '.latitude span' ).text( post.latitude );
	$el.find( '.longitude span' ).text( post.longitude );
	$el.find( '.radius span' ).text( post.radius );
			
	
}

function getLS( key ) {
	var data = window.localStorage.getItem( key );
	try {
		return JSON.parse( data );
	} catch ( e ) {
		return data;
	}
}

function setLS( key, data ) {
	return window.localStorage.setItem( key, JSON.stringify( data ) );
	//alert(JSON.stringify( data ));
}

function voteOnPost( post, updown ) {
	
	// likes and votes combined
	
	//console.log(updown);
	
	if ( 'likes' != updown ) {
		
		var myFavourites = getLS( 'myFavourites' ) || [];
		
		if ( 'up' === updown ) {
			if ( -1 === myFavourites.indexOf( post.id ) ) {
				myFavourites.push ( post.id );
				setLS( 'myFavourites', myFavourites );
				addReadingListElem( post );
			}
		}
		
		showPost( getRandomPost() );

		doAjax( geob_settings.endpoints.vote, {
			vote: updown,
			id: post.id
		} );
		
	}else{
		
		// this is a like
		
		//showPost( getRandomPost() );

	doAjax( geob_settings.endpoints.like, {
		
		like: 1,
		id: post.id
	} );

	}
	
}



function addReadingListElem( post ) {
	$el.find( '.my-favourites ul' ).append( '<li data-id="' + post.id + '"><a target=_blank href="' + post.permalink + '">' + post.title + '</a></li>' );
}

function doAjax( endpoint, data ) {
	console.log( endpoint );
	console.log( data );
	return $.ajax( {
		url: geob_settings.api_base + endpoint.route,
		method: endpoint.method,
		data: data
	} );
}

$( function() {
	$el = $( '.geobubble' );

	getPostsFromServer( initAfterAjax );

	function initAfterAjax() {
		
		//alert('first load');
		
		//showPost( getRandomPost() );
		showPost( getFirstPost() );

		// display saved reading list
		$el.find( '.my-favourites ul' ).empty();
		$.each( getLS( 'myFavourites' ), function( i, id ) {
			$.each( posts, function( i, post ) {
				if ( post.id === id ) {
					addReadingListElem( post );
				}
			} );
		} );
	}

	$el.on( 'click', '.interactions span', function( e ) {
		
		var value = parseInt($( this ).text()) + 1;
		$( this ).text(value);
		
		voteOnPost( $el.data( 'currentPost' ), $( this ).attr( 'class' ) );
	} );
	

	
	$el.on( 'click', '.clear-list', function( e ) {
		e.preventDefault();
		setLS( 'myFavourites', [] );
		$el.find( '.my-favourites ul' ).empty();
	} );

} );
