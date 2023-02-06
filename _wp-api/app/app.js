// SLICK JS -----------------------------------------------------------------------------------------------
var slick_dots = true;
var slick_infinite = false;
var slick_speed = 300;
var slick_slidesToShow = 5;
var slick_slidesToScroll = 5;
var path2root = '../../../../../';

var apibase = 'wp-json/wp/v2/'; ///wp-json/geobubble/v1/'
var post_id = urlParam('id');
var myroute = 'posts/' + post_id + '?_embed';
var modeType; // single post= 'single' or lots of posts = 'multi'

function urlParam(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
    	modeType = 'multi';
       	return ''; // needs to be blank so gets all posts from rest api
    }
    else{
    	modeType = 'single';
       return results[1] || 0;
    }
}

var geob_settings = {

	//api_base: '../../../../../wp-json/geobubble/v1/',
	api_base: path2root + apibase,
	endpoints: {
		posts: { route: myroute, method: 'GET' },
		vote: { route: 'vote/', method: 'POST' },
		like: { route: 'like/', method: 'POST' }
	}
	
}

var $el;
var posts = {}; // object with multiple posts data 'multi' mode
var post = {}; // object with single post data 'single' mode
var votedOn = JSON.parse( localStorage.getItem( 'geob_votedOn' ) );


function getPostsFromServer( callback ) {

	var ajaxURL = geob_settings.endpoints.posts;

	doAjax( ajaxURL, {} )
		.done( function( data ) {

			//console.log('data: ' + data);

			if(modeType == 'multi'){
				// nb. multi - posts not post
				posts = data;
			}else{
				// nb. single - post not posts
				post = data;
			}

			if ( 'function' === typeof callback ) {
				callback.call();
			}
		} );

}


function createPostsSlider() {

	// Init Slick using default vars ...................................................
	$('.slickjs .wrapper').slick({
		dots: slick_dots,
		infinite: slick_infinite,
		speed: slick_speed,
		slidesToShow: slick_slidesToShow,
		slidesToScroll: slick_slidesToScroll,
		responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		  ]
	});

	for (i = 0; i < posts.length; i++) { 

		cardhtml = buildCardHTML(i);

		// add populated card to slick js ...................................................
	    $('.slickjs .wrapper').slick('slickAdd',cardhtml);

	}// end loop of all posts returned

}

function getLS( key ) {
	//alert('getLS');
	var data = window.localStorage.getItem( key );

	//console.log('getLS' + data);

	try {
		return JSON.parse( data );
	} catch ( e ) {
		return data;
	}
}

function setLS( key, data ) {
	return window.localStorage.setItem( key, JSON.stringify( data ) );
}

function voteOnPost( post, updown ) {
	
	// likes and votes combined
	if ( 'likes' != updown ) {
		
		var myFavourites = getLS( 'myFavourites' ) || [];
		
		if ( 'up' === updown ) {
			if ( -1 === myFavourites.indexOf( post.id ) ) {
				myFavourites.push ( post.id );
				setLS( 'myFavourites', myFavourites );
				addReadingListElem( post );
			}
		}

		doAjax( geob_settings.endpoints.vote, {
			vote: updown,
			id: post.id
		} );
		
	}else{
		
		// this is a like
		doAjax( geob_settings.endpoints.like, {
			like: 1,
			id: post.id
		} );

	}
	
}


function addReadingListElem( post ) {

	var clickUrl = path2root + 'wp-content/themes/wp.theme-communio/_wp-api/app/?id=' + post.id;
	$el.find( '.my-favourites ul' ).append( '<li data-id="' + post.id + '"><a target=_self href="' + clickUrl + '">' + post.title.rendered + '</a></li>' );

}

function doAjax( endpoint, data ) {
	//console.log( endpoint );
	//console.log( data );
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

		if(modeType == 'multi'){
			// create slider full of post cards as mumtiple items
			createPostsSlider();
		}else{
			// create single card for x1 post
			showSinglePost();
		}

		// display saved reading list
		$el.find( '.my-favourites ul' ).empty();
		$.each( getLS( 'myFavourites' ), function( i, id ) {
			$.each( posts, function( i, post ) {
				if ( post.id === id ) {
					addReadingListElem( post );
				}
			} );

			if ( post.id === id ) {
				addReadingListElem( post );
			}
			
		} );
	}

	$el.on( 'click', '.interactions span', function( e ) {
		
		var value = parseInt($( this ).text()) + 1;
		$( this ).text(value);

		// get the posts number within the data array
		//console.log($(this).closest('.interactions').children('.postnumber').text());
		var myPostsNumber = $(this).closest('.interactions').children('.postnumber').text();

		if(modeType == 'multi'){
			$el.data( 'currentPost', posts[myPostsNumber-1] ); // is -1 so numbers look ok if viewable in Final UI
		}else{
			// create single card for x1 post
			$el.data( 'currentPost', post); // is -1 so numbers look ok if viewable in Final UI1
		}

		voteOnPost( $el.data( 'currentPost' ), $( this ).attr( 'class' ) );
	} );
	
	$el.on( 'click', '.clear-list', function( e ) {
		e.preventDefault();
		setLS( 'myFavourites', [] );
		$el.find( '.my-favourites ul' ).empty();
	} );

} );



function buildCardHTML( i ) {

		var postnumber = i+1; // critical as allows us to identify what to like etc via js.

		if(modeType == 'multi'){
			var object2Query = posts[i];
		}else{
			// create single card for x1 post
			var object2Query = post;
		}

		// get any vars you required from the json ...................................................
		var title = object2Query.title.rendered;
		//var title = object2Query.title.rendered;
		var date = object2Query.date;
		var link = object2Query.id;
		var id = object2Query.link;
		var author = object2Query.author;
		var categories = object2Query.categories; // needs second api query
		var tags = object2Query.tags; // needs second api query
		var format = object2Query.format;
		var excerpt = object2Query.excerpt.rendered;
		var content = object2Query.content.rendered;

		if(object2Query._embedded['wp:featuredmedia']){
			var featured_image_url = object2Query._embedded['wp:featuredmedia'][0].source_url; // only exists as using '?_embed' in api query
		}else{
			var featured_image_url = '';
		}
		
		var cardhtml = '';

		// start building the card html - super easy to edit eh! :) ...................................................
		cardhtml += '<div class="card">';
		cardhtml += '<div class="card-img-top" style="background-image: url(\'' + featured_image_url + '\');"></div>';

		//console.log('cardhtml : ' + cardhtml);

		cardhtml += '<div class="card-block">';
		cardhtml += '<h4 class="card-title">' + title + '</h4>';
		cardhtml += '<p class="excerpt">' + excerpt + '</p>';
		cardhtml += '<p class="content">' + content + '</p>';
		cardhtml += '<p class="date">' + date + '</p>';
		cardhtml += '<p class="link">' + link + '</p>';
		cardhtml += '<p class="id">' + id + '</p>';
		cardhtml += '<p class="author">' + author + '</p>';
		cardhtml += '<p class="format">' + format + '</p>';
		//cardhtml += '<p class="categories">' + categories + '</p>';
		//cardhtml += '<p class="tags">' + tags + '</p>';
		cardhtml += '<a href="' + link +'" class="link btn btn-primary">View Now</a>';
		cardhtml += '</div>';
		cardhtml += '<div class="interactions">';
		cardhtml += '<span class="postnumber">' + postnumber + '</span>'; // cricial - needed by js!!! silly but a hack as time poor apu!
		cardhtml += '<!-- span class="like">0</span --><span class="likes">0</span><span class="comment_count">0</span><span class="down">0</span><span class="up">0</span></div>';
		cardhtml += '</div>';

		return cardhtml;
}

function showSinglePost( ) {

	//console.log('!!!!' + post.title.rendered);
	var singlepostcard = buildCardHTML(0); // only 1 item in the array
	//console.log(singlepostcard);

	$('.slickjs .wrapper').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
	});

	$('.slickjs .wrapper').slick('slickAdd',singlepostcard);
}