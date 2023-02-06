// mode
var ui_mode = 'grid'; // grid or swipe slides

// SLICK JS -----------------------------------------------------------------------------------------------
var isVerticalMode = false;
var postOrder = 'rating';
var slick_dots = false;
var slick_infinite = false;
var slick_speed = 300;
var slick_slidesToShow = 15;
var slick_slidesToScroll = 5;
var path2root = '../../../../../';

var apibase = 'index.php/wp-json/wp/v2/'; ///wp-json/geobubble/v1/'
//var apibase = '/wp-json/geobubble/v1/'
var post_id = urlParam('id');
var myroute = 'posts/' + post_id + '?per_page=100&_embed';
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
	
	
	
	// add gutter re packery so can use media queries
	if(ui_mode != 'slick'){
		jQuery('.grid').append( '<div class="gutter-sizer"></div>' );
	}

	// add cards
	for (i = 0; i < posts.length; i++) { 
		
		cardhtml = buildCardHTML(i);
		
		if(ui_mode == 'slick'){
			// slick js carosel
			if(isVertical == true){
		
				// Init Slick using default vars ...................................................
				jQuery('.slickjs .wrapper').slick({
					dots: slick_dots,
					infinite: slick_infinite,
					speed: slick_speed,
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false,
					centerPadding: "300px",
					draggable: true,
					infinite: true,
					pauseOnHover: false,
					swipe: true,
					touchMove: false,
					vertical: true,
					speed: 1000,
					autoplaySpeed: 2000,
					useTransform: true,
					cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
					adaptiveHeight: true,
				});
				
			}else{
				
				// Init Slick using default vars ...................................................
				jQuery('.slickjs .wrapper').slick({
					dots: slick_dots,
					infinite: slick_infinite,
					speed: slick_speed,
					slidesToShow: slick_slidesToShow,
					slidesToScroll: slick_slidesToScroll,
					centerMode: false,
					centerPadding: "300px",
					draggable: false,
					infinite: true,
					pauseOnHover: false,
					swipe: true,
					touchMove: false,
					vertical: false,
					speed: 1000,
					autoplaySpeed: 2000,
					useTransform: true,
					cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
					adaptiveHeight: true,
					responsive: [
						{
						  breakpoint: 1600,
						  settings: {
							slidesToShow: 4,
							slidesToScroll: 4,
						  }
						},
						{
						  breakpoint: 1024,
						  settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
						  }
						},
						{
						  breakpoint: 760,
						  settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						  }
						},
						{
						  breakpoint: 520,
						  settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						  }
						}
					  ]
				});
				
			}

			jQuery('.slickjs .wrapper').slick('slickAdd',cardhtml);
			
		}
		else{
			// grid
		//	alert('ddd');
			jQuery('.grid').append( cardhtml );
			
		}

	}// end loop of all posts returned	
	
	if(ui_mode != 'slick'){
		launchIsotope();
		resizeIframes();
	}
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

		console.log('am vote on post');
	
	// likes and votes combined
	if ( 'likes' != updown ) {

			console.log('A');
		
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

				console.log('B');
		
		// this is a like
		doAjax( geob_settings.endpoints.like, {
			like: 1,
			id: post.id
		} );

	}
	
}


function addReadingListElem( post ) {

	var clickUrl = path2root + 'wp-content/themes/wordpress.theme-communio-js/index.html?id=' + post.id;
	$el.find( '.my-favourites ul' ).append( '<li data-id="' + post.id + '"><a target=_self href="' + clickUrl + '">' + post.title.rendered + '</a></li>' );

}

function doAjax( endpoint, data ) {
	//console.log( endpoint );
	//console.log( data );
	return jQuery.ajax( {
		url: geob_settings.api_base + endpoint.route,
		method: endpoint.method,
		data: data
	} );
}

jQuery( function() {
	$el = jQuery( '.app-content' );
	
	

	getPostsFromServer( initAfterAjax );

	function initAfterAjax() {

		if(modeType == 'multi'){
			
			orderPostsReturned();
			// create slider full of post cards as mumtiple items
			createPostsSlider(isVerticalMode);
		}else{
			// create single card for x1 post
			showSinglePost();
		}

		// display saved reading list
		$el.find( '.my-favourites ul' ).empty();
		jQuery.each( getLS( 'myFavourites' ), function( i, id ) {
			jQuery.each( posts, function( i, post ) {
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
		
		var value = parseInt(jQuery( this ).text()) + 1;
		jQuery( this ).text(value);

		// get the posts number within the data array
		//console.log($(this).closest('.interactions').children('.postnumber').text());
		var myPostsNumber = jQuery(this).closest('.interactions').children('.postnumber').text();

		if(modeType == 'multi'){
			$el.data( 'currentPost', posts[myPostsNumber-1] ); // is -1 so numbers look ok if viewable in Final UI
		}else{
			// create single card for x1 post
			$el.data( 'currentPost', post); // is -1 so numbers look ok if viewable in Final UI1
		}

		console.log('am trying an inetercation');

		voteOnPost( $el.data( 'currentPost' ), jQuery( this ).attr( 'class' ) );
	} );
	
	$el.on( 'click', '.clear-list', function( e ) {
		console.log('clear list');
		e.preventDefault();
		setLS( 'myFavourites', [] );
		$el.find( '.my-favourites ul' ).empty();
	} );

} );
	
function orderPostsReturned( ) {
	// allow reordering of posts etc
	if(postOrder == 'rating'){
		//dorder by rating - meta
	   posts.sort(dynamicSort("acf","rating"));
	posts.reverse(); 
	}else{
	   //default order - do nothing
	}
}

function dynamicSort(property1,property2) {
    var sortOrder = 1;
    if(property1[0] === "-") {
        sortOrder = -1;
        property1 = property1.substr(1);
    }
    return function (a,b) {
        var result = (a[property1][property2] < b[property1][property2]) ? -1 : (a[property1][property2] > b[property1][property2]) ? 1 : 0;
        return result;
    }
}

function showSinglePost( ) {

	//console.log('!!!!' + post.title.rendered);
	
	
	var singlepostcard = buildCardHTML(0); // only 1 item in the array
	
	//console.log(singlepostcard);

	$('.slickjs .wrapper').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		centerPadding: "10px",
		draggable: false,
		infinite: true,
		pauseOnHover: false,
		swipe: false,
		touchMove: false,
		vertical: true,
		speed: 1000,
		autoplaySpeed: 2000,
		useTransform: true,
		cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
		adaptiveHeight: true,
	});

	$('.slickjs .wrapper').slick('slickAdd',singlepostcard);
}
	
	
function launchIsotope(){

	jQuery(document).ready(function(t) {
		
	//console.log('here!');
	
    var e = t(".grid");
		
	/*
	e.isotope({
        itemSelector: ".item",
	
		transitionDuration: '.3s',
		stagger: 30,
		hiddenStyle: {
			opacity: 0
		},
		visibleStyle: {
			opacity: 1
		}
	})
	*/

	e.packery({
        itemSelector: ".item",
		/*gutter: 15,*/
		"gutter": ".gutter-sizer",
		transitionDuration: '.3s',
		stagger: 30,
		hiddenStyle: {
			opacity: 0
		},
		visibleStyle: {
			opacity: 1
		}
	})
	 
	classie.addClass(document.body, "loaded"), classie.removeClass(document.body, "grid");
    var n = t("#output"),
        a = t("#form-ui select"),
        i = t("#form-ui input");
   
    var r = t("#cat_filters"),
        l = r.find("a");
    l.click(function() {
        var n = t(this);
        if (n.hasClass("selected")) return !1;
        n.parents("#cat_filters"), r.find(".selected").removeClass("selected"), n.addClass("selected");
        var a = t(this).attr("data-filter");
        return e.isotope({
            filter: a
        }), !1
    })
	
	// ensure all oembeds that appear as iframes later dont overlap - clunky but works
	e.packery();
	var x = 0;
	var intervalID = setInterval(function () {
		e.packery();
	    if (++x === 40) {
		   window.clearInterval(intervalID);
	    }
	}, 500);
		
		
		
		
	
});
	
	
	
}




// RESIZE IFRAMES IF WEBPAGES ==================================================================================================
var myIframes2Resize = [];

function resizeIframes( ) {

	for (var i = 0; i < myIframes2Resize.length; i++) {
		
		
	/*	alert(myIframes2Resize[i]); */
		var iframe = document.getElementById(myIframes2Resize[i]);
		
		// Adjusting the iframe height onload event
		iframe.onload = function(){
			iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
		/*	alert('loaded');*/
		}
		
	}

}


// NEW GEO CARD HTML =======================================================================================================================================

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
		var date = object2Query.date;
		var date = date.replace("T", "<br/>");
		var id = object2Query.id;
		var link = object2Query.link;
		var author = object2Query.author;
		var categories = object2Query.categories; // needs second api query
		var tags = object2Query.tags; // needs second api query
		var format = object2Query.format;
		var excerpt = object2Query.excerpt.rendered;
		var content = object2Query.content.rendered;
		
		console.log('-----------------------------------------');
		console.log(id);

		// rest
		var featured_media_url = '';
		var cardhtml = '';
		var card_content_type = 'wordpress';
		var card_media = ''; // image, video, audio etc - means more idea re what type of media is used. todo - needs to work with normal wp so could have faetured videos etc - if they come out

		//acf
		var sites_url = ["spotify", "youtube", "instagram", "facebook", "soundcloud", "twitter"];
		var acfDataObject = null;
		var card_type = 'default';
		var card_rating = 0;
		var card_size = 'rating';
		var url_type = '';
		var url = '';
		var external_site = '';
		var mime_type = '';
		var media_shape = '';
		var aspect_ratio = '';
		var aspectPercentage = '';

		// has acf fields start ----------------------------------------------------------------------------------------------------------
		if(object2Query.hasOwnProperty('acf')){

			acfDataObject = object2Query.acf;
			
			// bubbles start ------------------------------------------------------------------------------------------------------------
			
			card_rating = acfDataObject.rating;	
			card_size = acfDataObject.size;

				if(card_rating >= 85){
					card_size = 'large';
				}else if(card_rating >= 55){
					card_size = 'medium';
				}else if(card_rating >= 20){
					card_size = 'small';
				}else{
					card_size = 'tiny';
				}

			card_type = acfDataObject.bubble_type;
			card_content_type = 'card-' + card_type;

			if(card_type == 'url') {
				
				// bubbles:url start (has own ui as another webpage/website or oembed)--------
				url_type = acfDataObject.url_type;
				url = acfDataObject.url;

				// see if url matches any of these main site types - means can style etc
				var i_so = 0;
				for ( i_so;sites_url[i_so];) {
					if(url.includes(sites_url[i_so])){
						external_site = sites_url[i_so] + ' ';
					};
					i_so++;
				}
				
				// bubbles:url end ------------------------------------------------------------

			}else {

				if(acfDataObject.hasOwnProperty('image') && acfDataObject.image != null){

					// bubbles: has media start ---------------------------------------------------
					card_media = acfDataObject.image.type; //image, video, audio
					mime_type = acfDataObject.image.mime_type;

					console.log('A new cool ric start');
					console.log(card_media);
					console.log(mime_type);
					console.log('A new cool ric end');

					if(card_media == 'image'){
						featured_media_url = acfDataObject.image.sizes.thumbnail;
					}else{
						// audio, video
						featured_media_url = acfDataObject.image.url;
					}

					//console.log(card_media);
				}

			}

			//

		}

		// has acf fields end ----------------------------------------------------------------------------------------------------------

		// wp - has a featured background-image
		if(object2Query.hasOwnProperty('featured_media') && object2Query.featured_media!=0){
			// ie. /wp-json/wp/v2/posts?_embed - note embed extra
			featured_media_url = object2Query._embedded['wp:featuredmedia'][0].source_url; // only exists as appending '?_embed' to end of query in api query
			card_media = object2Query._embedded['wp:featuredmedia'][0].media_type; //image, video, audio
			mime_type = object2Query._embedded['wp:featuredmedia'][0].mime_type;
			media_width = object2Query._embedded['wp:featuredmedia'][0].media_details.width;
			media_height = object2Query._embedded['wp:featuredmedia'][0].media_details.height;

			// boom - how many faking themes check the optimal shape to render a featured image. if portrait image - show as portrait - no catch all bollocks any more ! boom1

			// dont laugh - but working out the percentage of how much wider the image is than the height
			/*

			4x3 		75%		70-100 (percentage needed to define as this aspect ratio)
			3x2			67%		60-70 (percentage needed to define as this aspect ratio)
			16x9		56%		40-60 (percentage needed to define as this aspect ratio)
			ultrawide	-		0-40 (percentage needed to define as this aspect ratio)

			*/

			/* end resulkt is lovely looking cards no matter what featured inage is used */

			if(media_width > media_height){
				media_shape = 'landscape';

				aspectPercentage = (media_height/media_width)*100;

				if( aspectPercentage >= 70){
					aspect_ratio = 'four-three';
				}else if(aspectPercentage >= 60 ){
					aspect_ratio = 'three-two';
				}else if(aspectPercentage >= 40 ){
					aspect_ratio = 'sixteen-nine';
				}else{
					aspect_ratio = 'ultrawide';
				}
			}else if(media_width < media_height){
				media_shape = 'portrait';
			}else{
				media_shape = 'square';
			}

					console.log('B new cool ric start');
					console.log(card_media);
					console.log(mime_type);
					console.log(media_shape);
					console.log('B new cool ric end');
			//card_media = 'image'; //in future maybe wp does featured videos etc
		}

		var cardclasses = "card item i-" + id + " " + card_type + " " + card_media + " " + media_shape + " " + aspect_ratio + " " + card_size + " ";

		// start building the card html - super easy to edit eh! :) ...................................................
		//bug start
		// needs a UI as not another webpage / website
		if(card_type == 'url'){
			cardhtml += '<div class="' + cardclasses + external_site + ' ' + url_type + '">';
			if(url_type == 'oembed'){
				// already an iframe
				cardhtml += url;
				
			}else{
				// make an iframe
				var iframeID = "iframe-"+ id;
				
				cardhtml += '<iframe id="' + iframeID + '" src="' + url + '"></iframe>';
				
			/*	alert(iframeID);*/
				
				myIframes2Resize.push(iframeID);
	
			}
			cardhtml += '</div>';
			
	
		
			
			
			
			
			
		}else if(card_media == 'video'){
			cardhtml += '<div class="' + cardclasses + '"><video controls><source src="' + featured_media_url + '" type="' + mime_type + '" ></video></div>';
		}else if(card_media == 'audio'){
			cardhtml += '<div class="' + cardclasses + '"><audio controls><source src="' + featured_media_url + '" type="' + mime_type + '" ></audio></div>';
		}else{

			cardhtml = '<div class="' + cardclasses + '" >';
			cardhtml += '<a onclick="open_bubbleurl()" target="iframe_a" href="' + link + '">';
			cardhtml += '</a>';
			
			
			
			if(featured_media_url != '' && featured_media_url != undefined){
				cardhtml += '<div class="card-img-top">';
				cardhtml += '<img src="' + featured_media_url + '" >';
				cardhtml += '</div>';
			}
			
			//console.log('cardhtml : ' + cardhtml);
			cardhtml += '<div class="card-block">';
			cardhtml += '<h2 class="card-title">' + title + '</h2>';
			cardhtml += '<p class="excerpt">' + excerpt + '</p>';
			//cardhtml += '<p class="content">' + content + '</p>';
			//cardhtml += '<p class="date">' + date + '</p>';
			//cardhtml += '<p class="link">' + link + '</p>';
			//cardhtml += '<p class="id">' + id + '</p>';
			//cardhtml += '<p class="author">' + author + '</p>';
			//cardhtml += '<p class="format">' + format + '</p>';
			//cardhtml += '<p class="categories">' + categories + '</p>';
			//cardhtml += '<p class="tags">' + tags + '</p>';
			//cardhtml += '<a href="' + link +'" class="link btn btn-primary">View Now</a>';
			cardhtml += '</div>';
			//cardhtml += '<div class="interactions">';
			//cardhtml += '<span class="postnumber">' + postnumber + '</span>'; // cricial - needed by js!!! silly but a hack as time poor apu!
			//cardhtml += '<span class="like">0</span><span class="likes">0</span>';
			//cardhtml += '<span class="comment_count">0</span><span class="down">0</span><span class="up">0</span></div>';
			cardhtml += '<div class="footer entry-meta"><span class="geobmeta meta-views" href="#">1</span><span class="geobmeta meta-likes" href="#">0</span> <span class="geobmeta meta-comments" href="#">0</span><span class="geobmeta meta-price" href="#">£99</span><span class="geobmeta bubble-type"></span>';
			
			if(object2Query._embedded['author'][0].avatar_urls != null){
				cardhtml += '<span class="avatar"><img src="';
			   	cardhtml += object2Query._embedded['author'][0].avatar_urls[48];
				cardhtml += '" width="50" height="50" alt="avatar" ></span>';
			}
			
			cardhtml += '<span class="footer-txt posted-on">' + date + '</span>';
			cardhtml += '</div></div>';
			
			
			
			

		}
	
	
	
	
		return cardhtml;
}