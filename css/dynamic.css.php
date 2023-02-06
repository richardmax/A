<?php 

?>
<style type="text/css">

/* ALL ====================================================================================== */

<?php
	$contentarea_bg_colour = get_field('contentarea_bg_colour', 'option');
	$contentarea_text_colour = get_field('contentarea_text_colour', 'option');
	$colour_1 = get_field('colour_1', 'option');
	$colour_2 = get_field('colour_2', 'option');
	$colour_3 = get_field('colour_3', 'option');
	$colour_grey = get_field('colour_grey', 'option');
?>

.post-new-php #poststuff, html, body.frontend, .entry-content, main {
	color: <?php echo $contentarea_text_colour; ?> !important;
	background-color: <?php echo $contentarea_bg_colour; ?> !important;
}

.frontend p,small,blockquote,li,ul,ol{
	/*color: <?php //echo $contentarea_text_colour;; ?>;*/
}

.frontend h1,.frontend h2,.frontend h3,.frontend h4,.frontend h5,.frontend h6{
	color: <?php the_field('contentarea_title_colour', 'option'); ?>;
}

/* key brand colour - used with white icon etc.... */	
 .bubble-profile .none{
 	background-color: <?php the_field('brand_colour', 'option'); ?> !important;
 }
	
/* APP HEADER ====================================================================================== */

.header, .gn-menu-main {
	background: <?php the_field('header_background_colour', 'option'); ?> !important;
}
	

span.app-logo {color: <?php the_field('logo_text_colour', 'option'); ?> !important;}

/* main menu icon */	
#gn-menu.gn-menu-main a.gn-icon-menu,
#gn-menu.gn-menu-main a.gn-icon-menu:hover{
	background-color:  <?php the_field('header_background_colour', 'option'); ?> !important;
	<?php $icon_menu = get_field('icon_menu', 'option'); ?>
		<?php if($icon_menu){ ?>
			background-image: url( <?php echo $icon_menu; ?> ) !important;
	<?php } ?>
}
	
/* show filters icon */
#gn-menu1.gn-menu-main a.filter-but,
#gn-menu1.gn-menu-main a.filter-but:hover{
	<?php $icon_filter = get_field('icon_filter', 'option'); ?>
		<?php if($icon_filter){ ?>
			background-image: url( <?php echo $icon_filter; ?> ) !important;
	<?php } ?>
}
	
/* create content button */
.create-content-but a,
.create-content-but a:hover{
	<?php $icon_create = get_field('icon_create', 'option'); ?>
		<?php if($icon_create){ ?>
			background-image: url( <?php echo $icon_create; ?> ) !important;
	<?php } ?>
}
	
<?php $tint_icons = get_field('header_icon_tint', 'option'); ?>
	
<?php if($tint_icons == '1'){ 
	
	$tint_colour = get_field('header_icon_tint_colour', 'option'); ?>
	
	.create-content-but h2 {color: <?php echo $tint_colour; ?> !important;}
	.gn-icon-menu.gn-selected::before,
	.gn-icon-menu::before{color: <?php echo $tint_colour; ?> !important;box-shadow: 0 3px rgba(255, 255, 255, 0), 0 -6px <?php echo $tint_colour; ?>, 0 -9px rgba(255, 255, 255, 0), 0 -12px <?php echo $tint_colour; ?>; background: <?php echo $tint_colour; ?> !important; }

	<?php } ?>
	
	
	
/* APP MENU ====================================================================================== */
.gn-menu-main ul.user-nav-items{
	 background: <?php the_field('menu_header_colour', 'option'); ?> !important;
}

#cat_filters,
.menu-side{
	background: <?php the_field('menu_background_colour', 'option'); ?> !important;
 }
	
#cat_filters,
.menu-side, 
.menu-side p,
.menu-side small,
.menu-side li,
.menu-side ul,
.menu-side ol {
	color: <?php the_field('menu_text_colour', 'option'); ?>;
 }

.dpSocialTimeline_filter,
.menu-footer {
	background:  <?php the_field('menu_footer_background_colour', 'option'); ?> !important;
}

.menu-side li.gn-search-item, .menu-side a, .no-touch .menu-side li.gn-search-item a {
	color: <?php the_field('menu_item_text_colour', 'option'); ?> !important;
	background-color: <?php the_field('menu_item_background_colour', 'option'); ?> !important; 
}

.menu-side .current_page_item a,
.menu-side li.gn-search-item:hover, .menu-side a:hover, .no-touch .menu-side li.gn-search-item:hover a {
	color: <?php the_field('menu_item_selection_text_colour', 'option'); ?> !important;
	background-color: <?php the_field('menu_item_selection_background_colour', 'option'); ?> !important;
}

<?php 
	$footer_show_icon_tint_colour = get_field('footer_show_button_colour', 'option');
?>
	
 #gn-menu1 .gn-icon-menu::before,
 #gn-menu1.gn-icon-menu::before{color: <?php echo $footer_show_icon_tint_colour; ?> !important;box-shadow: 0 3px rgba(255, 255, 255, 0), 0 -6px <?php echo $footer_show_icon_tint_colour; ?>, 0 -9px rgba(255, 255, 255, 0), 0 -12px <?php echo $footer_show_icon_tint_colour; ?>; background: <?php echo $footer_show_icon_tint_colour; ?> !important; }
	

/* CARDS ====================================================================================== */
/* convert card colours to RGBA's! - BRILLIANT */
<?php 
		$card_footer_rgb_array = hex2rgb(get_field('card_footer_background_colour', 'option'));
		$card_footer_bg_rgb = 'rgba(' . $card_footer_rgb_array[0] . ', ' . $card_footer_rgb_array[1] . ', ' . $card_footer_rgb_array[2] . ',.75)'; 
		
		// get defaults as vars
		$card_header_background_colour = get_field('card_header_background_colour', 'option');
		$card_header_text_colour = get_field('card_header_text_colour', 'option');
		$card_footer_background_colour = get_field('card_footer_background_colour', 'option');
		$card_footer_text_colour = get_field('card_footer_text_colour', 'option');
		$card_content_background_colour = get_field('card_content_background_colour', 'option');
		$card_content_text_colour = get_field('card_content_text_colour', 'option');
?>
	
	
/* main app page headers */	
 .entry-title {
	color: <?php the_field('card_header_text_colour', 'option'); ?> !important;
}

header.entry-header {
	background-color: <?php the_field('card_header_background_colour', 'option'); ?> !important;
}
	

	
.bbp-forum-freshness a,
.bbpress li.bbp-forum-freshness,.bbpress li.bbp-forum-freshness a, .bbpress li.bbp-forum-reply-count, .bbpress li.bbp-forum-topic-count,	
.single .entry-meta,
.card .entry-meta {
	background-color: <?php echo $card_footer_background_colour; ?> !important;
	color: <?php echo $card_footer_text_colour; ?> !important;
}

.bbp-forums .type-forum li:nth-last-of-type(1), .bbp-forums .type-forum li:nth-last-of-type(2), .bbp-forums .type-forum li:nth-last-of-type(3),
.card .geobmeta {
    color: <?php echo $card_footer_background_colour; ?> !important;
}

.entry-meta, .geobmeta{
	color: <?php echo $card_footer_background_colour; ?> !important;
}
#bbpress-forums .bbp-template-notice.info,
div.bbp-template-notice.info,
#bbpress-forums .bbp-template-notice .bbp-topic-description,
#bbpress-forums li.bbp-body ul.topic,
.bbp-forum-title,
.bbp-forum-content,
.page .entry-header,
.single .entry-header,
.card .entry-header{
	background-color: <?php echo $card_header_background_colour; ?> !important;
}

#bbpress-forums .bbp-template-notice .bbp-topic-description,
div.bbp-template-notice .bbp-topic-description  a,
.bbp-topic-permalink,
.bbp-topic-permalink:hover,
.bbp-topic-permalink:visited,
#bbpress-forums li.bbpress .bbp-forum-freshness a,
.subsection li h2,
.forum.bbpress .bbp-topic-permalink,
.bbp-forum-content,
.single header .title,
.page header .title,
.card header .title,
.card .card-title{
	color: <?php echo $card_header_text_colour; ?> !important;
}
.page .content,
.single .content,
.card .content{
	background-color: <?php echo $card_content_background_colour; ?> !important;
	color: <?php echo $card_content_text_colour;?>;
}

.bbp-forums .type-forum li:nth-last-of-type(1), .bbp-forums .type-forum li:nth-last-of-type(2), .bbp-forums .type-forum li:nth-last-of-type(3){
	background-color: <?php echo $card_footer_background_colour; ?> !important;
	}

	
/* bubble colours ----------------------------------------------------------------------------------------- */
.acf-field input[value="media"],
.bubble-media  .entry-header,  .card .bubble-media .entry-content,  #cat_filters a[data-filter=".bubble-media"], .bubble-media .header .title, .single .bubble-media .entry-header h1 {
	background-color:  <?php the_field('bubble_media_color', 'option'); ?> !important;
}
.acf-field input[value="alert"],
 .bubble-alert  .entry-header, .card  .bubble-alert .entry-content,  #cat_filters a[data-filter=".bubble-alert"], .bubble-alert .header .title, .single .bubble-alert .entry-header h1,  .bubble-alert .entry-meta {
	background-color:  <?php the_field('bubble_alert_color', 'option'); ?> !important;
}
.acf-field input[value="question"],
.bubble-question  .entry-header, .card  .bubble-question .entry-content,  #cat_filters a[data-filter=".bubble-question"], .bubble-question .header .title, .single .bubble-question .entry-header h1 {
	background-color:  <?php the_field('bubble_question_color', 'option'); ?> !important;
}
	
.acf-input input[value="event"],
.bubble-event  .entry-header, .card  .bubble-event .entry-content,  #cat_filters a[data-filter=".bubble-event"], .bubble-event .header .title, .single .bubble-event .entry-header h1 {
	background-color: <?php the_field('bubble_event_color', 'option'); ?> !important;
}
.acf-input input[value="information"],
.bubble-information  .entry-header, .card  .bubble-information .entry-content,  #cat_filters a[data-filter=".bubble-information"], .bubble-information .header .title, .single .bubble-information .entry-header h1 {
	background-color: <?php the_field('bubble_information_color', 'option'); ?> !important;
}
.acf-input input[value="classified"],
.bubble-classified  .entry-header, .card  .bubble-classified .entry-content,  #cat_filters a[data-filter=".bubble-classified"], .bubble-classified .header .title, .single .bubble-classified .entry-header h1 {
	background-color: <?php the_field('bubble_for_sale_color', 'option'); ?> !important;
}
 div.modern div.dpSocialTimeline .dpSocialTimeline_item div.dpSocialTimelineContentHead,.acf-field input[value="url"],
.bubble-url  .entry-header, .card  .bubble-url .entry-content,  #cat_filters a[data-filter=".bubble-url"], .bubble-url .header .title, .single .bubble-url .entry-header h1 {
	background-color: <?php the_field('bubble_url_color', 'option'); ?> !important;
}

.acf-field input[value="oembed"],
.bubble-oembed  .entry-header, .card  .bubble-oembed .entry-content,  #cat_filters a[data-filter=".bubble-oembed"], .bubble-oembed .header .title, .single .bubble-oembed .entry-header h1 {
	background-color: <?php the_field('bubble_oembed_color', 'option'); ?> !important;
}
.acf-field input[value="grafitti"],
.bubble-grafitti  .entry-header, .card  .bubble-grafitti .entry-content,  #cat_filters a[data-filter=".bubble-grafitti"], .bubble-grafitti .header .title, .single .bubble-grafitti .entry-header h1 {
	background-color: <?php the_field('bubble_grafitti_color', 'option'); ?> !important;
}
.acf-field input[value="advert"],
.bubble-advert  .entry-header,  .card .bubble-advert .entry-content,  #cat_filters a[data-filter=".bubble-advert"], .bubble-advert .header .title, .single .bubble-advert .entry-header h1 {
	background-color: <?php the_field('bubble_advert_color', 'option'); ?> !important;
}
.acf-field input[value="questionnaire"],
.bubble-questionnaire  .entry-header,  #cat_filters a[data-filter=".bubble-questionnaire"], .bubble-questionnaire .header .title, .single .bubble-questionnaire .entry-header h1 {
	background-color: <?php the_field('bubble_questionnaire_color', 'option'); ?> !important;
}
.acf-field input[value="news"],
.bubble-news  .entry-header,  .card .bubble-news .entry-content,  #cat_filters a[data-filter=".bubble-news"], .bubble-news .header .title, .single .bubble-news .entry-header h1 {
	background-color: <?php the_field('bubble_news_color', 'option'); ?> !important;
}
.acf-field input[value="game"],
.bubble-game  .entry-header, .card .bubble-game .entry-content,  #cat_filters a[data-filter=".bubble-game"], .bubble-game .header .title, .single .bubble-game .entry-header h1 {
	background-color: <?php the_field('bubble_game_color', 'option'); ?> !important;
}
.acf-field input[value="chat"],
.bubble-chat  .entry-header, .card .bubble-chat .entry-content,  #cat_filters a[data-filter=".bubble-chat"], .bubble-chat .header .title, .single .bubble-chat .entry-header h1 {
	background-color: <?php the_field('bubble_chat_color', 'option'); ?> !important;
}
.acf-field input[value="forum"],
.bubble-forum  .entry-header,  .card .bubble-forum .entry-content,  #cat_filters a[data-filter=".bubble-forum"], .bubble-forum .header .title, .single .bubble-forum .entry-header h1 {
	background-color: <?php the_field('bubble_forum_color', 'option'); ?> !important;
}
.acf-field input[value="profile"],
.bubble-profile .entry-header, .card .bubble-profile .entry-content,  #cat_filters a[data-filter=".bubble-chat"], .bubble-profile .header .title, .single .bubble-profile .entry-header h1, .author-box-bg {
	background-color: <?php the_field('bubble_profile_color', 'option'); ?> !important;
}
#cat_filters a.clear-data {
	background-color: <?php the_field('ui_filter_clear_colour', 'option'); ?> !important;
}
	
	
<?php $icon_alert = get_field('bubble_alert_icon', 'option'); ?>
<?php if($icon_alert){ ?>
	.bubble-alert .bubble-type {
		background-image: url(<?php echo $icon_alert; ?>) !important;
	}
<?php } ?>
	
<?php $icon_media = get_field('bubble_media_icon', 'option'); ?>
<?php if($icon_media){ ?>
	.bubble-media .bubble-type {
		background-image: url(<?php echo $icon_media; ?>) !important;
	}
<?php } ?>
	
<?php $icon_classified = get_field('bubble_classified_icon', 'option'); ?>
<?php if($icon_classified){ ?>
	.bubble-classified .bubble-type {
		background-image: url(<?php echo $icon_classified; ?>) !important;
	}
<?php } ?>

<?php $icon_question = get_field('bubble_question_icon', 'option'); ?>
<?php if($icon_question){ ?>
	.bubble-question .bubble-type {
		background-image: url(<?php echo $icon_question; ?>) !important;
	}
<?php } ?>	
	
<?php $icon_questionnaire = get_field('bubble_questionnaire_icon', 'option'); ?>
<?php if($icon_questionnaire){ ?>
	.bubble-questionnaire .bubble-type {
		background-image: url(<?php echo $icon_questionnaire; ?>) !important;
	}
<?php } ?>		
	
<?php $icon_grafitti = get_field('bubble_grafitti_icon', 'option'); ?>
<?php if($icon_grafitti){ ?>
	.bubble-grafitti .bubble-type {
		background-image: url(<?php echo $icon_grafitti; ?>) !important;
	}
<?php } ?>		
		
<?php $icon_url = get_field('bubble_url_icon', 'option'); ?>
<?php if($icon_url){ ?>
	.bubble-url .bubble-type {
		background-image: url(<?php echo $icon_url; ?>) !important;
	}
<?php } ?>		
	
<?php $icon_advert = get_field('bubble_advert_icon', 'option'); ?>
<?php if($icon_advert){ ?>
	.bubble-advert .bubble-type {
		background-image: url(<?php echo $icon_advert; ?>) !important;
	}
<?php } ?>		

<?php $icon_information = get_field('bubble_information_icon', 'option'); ?>
<?php if($icon_information){ ?>
	.bubble-information .bubble-type {
		background-image: url(<?php echo $icon_information; ?>) !important;
	}
<?php } ?>	
	
<?php $icon_profile = get_field('bubble_profile_icon', 'option'); ?>
<?php if($icon_profile){ ?>
	.bubble-profile .bubble-type {
		background-image: url(<?php echo $icon_profile; ?>) !important;
	}
<?php } ?>		
	
<?php $icon_forum = get_field('bubble_forum_icon', 'option'); ?>
<?php if($icon_forum){ ?>
	.bubble-forum .bubble-type {
		background-image: url(<?php echo $icon_forum; ?>) !important;
	}
<?php } ?>			
	
<?php $icon_event = get_field('bubble_event_icon', 'option'); ?>
<?php if($icon_event){ ?>
	.bubble-event .bubble-type {
		background-image: url(<?php echo $icon_event; ?>) !important;
	}
<?php } ?>			
	
<?php $icon_news = get_field('bubble_news_icon', 'option'); ?>
<?php if($icon_news){ ?>
	.bubble-news .bubble-type {
		background-image: url(<?php echo $icon_news; ?>) !important;
	}
<?php } ?>	
	
<?php $icon_game = get_field('bubble_game_icon', 'option'); ?>
<?php if($icon_game){ ?>
	.bubble-game .bubble-type {
		background-image: url(<?php echo $icon_game; ?>) !important;
	}
<?php } ?>		

<?php $icon_chat = get_field('bubble_chat_icon', 'option'); ?>
<?php if($icon_chat){ ?>
	.bubble-chat .bubble-type {
		background-image: url(<?php echo $icon_chat; ?>) !important;
	}
<?php } ?>


	
	
	
/* meta icons =================================== */
	
<?php 
	$custom_meta_likes = get_field('icon_likes', 'option');
	if($custom_meta_likes){ ?>
		.meta-likes {
	background-image: url(<?php echo $custom_meta_likes; ?>) !important;
}
<?php } ?>
.meta-saves {
	background-image: url(<?php the_field('icon_saves', 'option'); ?>) !important;
}
.meta-date {
	background-image: url(<?php the_field('icon_date', 'option'); ?>) !important;
}
.meta-price {
	background-image: url(<?php the_field('icon_cost', 'option'); ?>) !important;
}
<?php 
	$custom_meta_views = get_field('icon_views', 'option');
	if($custom_meta_views){ ?>
		.meta-views {
			background-image: url(<?php echo $custom_meta_views; ?>) !important;
		}
<?php } ?>
	
<?php 
	$custom_meta_comments = get_field('icon_comments', 'option');
	if($custom_meta_comments){ ?>
		.forum li.bbp-forum-reply-count,
		.meta-comments {
			background-image: url(<?php echo $custom_meta_comments; ?>) !important;
		}
<?php } ?>
	

<?php 
	$custom_meta_freshness = get_field('icon_freshness', 'option');
	if($custom_meta_freshness){ ?>
		.forum li.bbp-forum-freshness {
			background-image: url(<?php echo $custom_meta_freshness; ?>) !important;
		}
<?php } ?>

<?php 
	$custom_meta_topics = get_field('icon_categories', 'option');
	if($custom_meta_topics){ ?>
		.forum li.bbp-forum-topic-count {
			background-image: url(<?php echo $custom_meta_topics; ?>) !important;
		}
<?php } ?>

.meta-holder .contact.button:before {
	background-image: url(<?php the_field('icon_email', 'option'); ?>) !important;
}
.meta-holder .website.button:before {
	background-image: url(<?php the_field('icon_website', 'option'); ?>) !important;
}
.meta-holder .location.button:before {
	background-image: url(<?php the_field('icon_location', 'option'); ?>) !important;
}
.meta-holder .telephone.button:before {
	background-image: url(<?php the_field('icon_telephone', 'option'); ?>) !important;
}
.ac-container a.recommendations,
.subsection li span.recommendations {
	background-image: url(<?php the_field('icon_likes', 'option'); ?>) !important;
}
.ac-container a.testimonials,
.subsection li span.testimonials {
	background-image: url(<?php the_field('icon_comments', 'option'); ?>) !important;
}
	
.wp-core-ui .button, .post-new-php .edit-selection, .post-new-php .clear-selection, .subsubsub li, .media-frame:not(.hide-menu) .media-frame-title, .edit-php .search-box #search-submit, #major-publishing-actions .submitdelete, .submitdelete, .media-modal .delete-attachment, .media-selection .selection-info a, .media-modal-close .media-modal-icon:before, .wp-core-ui .button-primary[disabled], #major-publishing-actions .button-primary, #major-publishing-actions .button-primary[disabled], #your-profile .form-table label, .row-actions .untrash a, .response-links a:last-child, .row-actions .approve a, .row-actions .unapprove a, .row-actions .quickedit a, .row-actions .reply a, .row-actions .edit a, .row-actions .view a, .row-actions .editinline, .row-actions .trash a, .media-frame:not(.hide-menu) .media-frame-title, .wp-core-ui .button-primary, #major-publishing-actions #save-post, #major-publishing-actions #post-preview, #major-publishing-actions .submitdelete, #save-post, #post-preview, #major-publishing-actions .submitdelete, .submitdelete, #simple-local-avatar-media, #insert-media-button, .insert-media, .edit-visibility, .edit-timestamp, .browser.button-hero, #category-add-toggle, #set-post-thumbnail, .cancel-timestamp, .cancel-post-visibility, .misc-pub-section>a, .save-post-visibility, .tagadd, .tagcloud-link, .acf-image-uploader input.button, .save-timestamp,.slider>.highlight-track,
.wpcf7-submit, button, .gform_button, .slider>.highlight-track,
.mce-container,
.media-router .active, .media-router>a.active:last-child,
.acf-field[data-name="form_type"] input[value="card"],
.acf-field[data-name="form_type"] input[value="url"],
.acf-field[data-name="classified_type"] input[value="itemforsale"],
.acf-field[data-name="classified_type"] input[value="rent"],
.acf-field[data-name="alert_type"] input[value="card"],
.acf-field[data-name="alert_type"] input[value="url"],
.acf-field[data-name="advert_type"] input[value="text"],
.acf-field[data-name="advert_type"] input[value="image"],
.acf-field[data-name="url_type"] input[value="oembed"],
.acf-field[data-name="url_type"] input[value="url"],
.has-file .acf-button-delete, .acf-button {
	     background-color: <?php the_field('ui_toggle_on_colour', 'option'); ?> !important;
	color:  <?php the_field('ui_button_default_text_colour', 'option'); ?> !important;
}


.acf-field[data-name="grafitti_type"] input[value="text"],
.acf-field input[value="uploaded"],
.acf-field[data-name="grafitti_type"] input[value="voice"],
.acf-field[data-name="news_type"] input[value="url"],
.acf-field[data-name="news_type"] input[value="card"],
.acf-field[data-name="bubble_type"] li, .acf-field[data-name="bubble_type"] li input, #acf-bubble_type li input {
    background-color: <?php the_field('ui_toggle_off_colour', 'option'); ?> !important;
	color:  <?php the_field('ui_button_default_text_colour', 'option'); ?> !important;
}	
	
  
	
.slider>.highlight-track {
	    background-color: <?php the_field('ui_slider_max_colour', 'option'); ?> !important;
}
	
	.slider>.track {
	    background-color: <?php the_field('ui_slider_min_colour', 'option'); ?> !important;
}


	

.acf-radio-list li label.selected {
	 background-color: <?php the_field('ui_toggle_on_colour', 'option'); ?> !important;
}

.acf-field[data-name="bubble_type"] li{
	border-color: <?php the_field('ui_toggle_on_colour', 'option'); ?> !important;
}
	

.acf-radio-list li label {
    /* float: left; */
     background-color: <?php the_field('ui_toggle_off_colour', 'option'); ?> !important;
}

.acf-field[data-name="bubble_type"] input[type=radio]:checked:before {
		 background-color: <?php the_field('ui_toggle_on_colour', 'option'); ?> !important;
}

.mce-container{width:100% !important;}
	.mce-toolbar .mce-ico{color: #ffffff !important;}


.wpcf7-submit:hover, button:hover, /*a:hover,*/  .gform_button:hover {
	    background-color: <?php the_field('ui_button_click_colour', 'option'); ?> !important;
    background:  <?php the_field('ui_button_click_colour', 'option'); ?>;
	color:  <?php the_field('ui_button_click_text_colour', 'option'); ?> !important;
}
	
.acf-field[data-name="form_type"] input[value="card"]:checked,
.acf-field[data-name="form_type"] input[value="url"]:checked,
.acf-field[data-name="news_type"] input[value="card"]:checked,
.acf-field[data-name="news_type"] input[value="url"]:checked,
.acf-field[data-name="classified_type"] input[value="itemforsale"]:checked,
.acf-field[data-name="classified_type"] input[value="rent"]:checked,
.acf-field[data-name="alert_type"] input[value="card"]:checked,
.acf-field[data-name="alert_type"] input[value="url"]:checked,
.acf-field[data-name="advert_type"] input[value="text"]:checked,
.acf-field[data-name="advert_type"] input[value="image"]:checked,
.acf-field[data-name="grafitti_type"] input[value="text"]:checked,
.acf-field[data-name="grafitti_type"] input[value="voice"]:checked,
.acf-field[data-name="url_type"] input[value="oembed"]:checked,
	.acf-field[data-name="url_type"] input[value="url"]:checked,
.acf-field[data-name="media_location"] input[value="url"]:checked,
.acf-field[data-name="media_location"] input[value="uploaded"]:checked,
.wpcf7-submit:hover, button:hover, /*a:hover,*/  .gform_button:hover {
	    background-color: <?php the_field('ui_toggle_on_colour', 'option'); ?> !important;
  
	color:  <?php the_field('ui_button_click_text_colour', 'option'); ?> !important;
}

.single .footer-txt,
.card .footer-txt, {
    color: <?php echo $card_footer_text_colour; ?> !important;
}


.bbp-forum-info {
	background-color: <?php echo $card_header_background_colour; ?> !important;
}

.bbp-forum-info, .bbp-forum-title {
	color: <?php echo $card_header_text_colour; ?> !important;
}

	
.item.bubble-news .entry-title {
	<?php 
		$news_bg_rgb_array = hex2rgb(get_field('bubble_news_color', 'option'));
		$news_bg_rgb = 'rgba(' . $news_bg_rgb_array[0] . ', ' . $news_bg_rgb_array[1] . ', ' . $news_bg_rgb_array[2] . ',.5)'; 
	?>
	
	background-color: <?php echo $news_bg_rgb; ?> !important;
}
	
.item.bubble-news .entry-meta {
	background-color: <?php echo $card_footer_bg_rgb; ?> !important;
}
	
/*directorys -------------- */
.ac-container .header h2, li.genre .header{
	background-color: <?php echo $colour_grey; ?> !important;
}
	.subsection li h2{
		
		background-color: <?php echo $colour_grey; ?> !important;
		color: <?php echo $contentarea_text_colour; ?> !important; 
	}
	
	.accordianitem label{

		color: <?php echo $card_header_text_colour; ?> !important;
	}
	

	.ac-container article{
		background-color: <?php echo $card_content_background_colour; ?> !important;
		color: <?php echo $card_content_text_colour;?> !important;
	}
	
	.ac-container input:checked+label h2, .ac-container input:checked+label:hover h2 {
		color: <?php echo $card_header_text_colour; ?> !important;
		background-color: <?php echo $card_header_background_colour; ?> !important;
	}
	
	
	
	
	
	
	/* ADD BOOTSTRAP ---------------------------- */
/*	
body {
    margin: 0;
    font-family: "Campton,"-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
}
	
*/


/*
	.gn-menu-main .gn-scroller li.menu-item.bg-grey{
	background-color:#b0c5cc !important;
}

.gn-menu-wrapper{
	background: #5c6f7b !important;
}
	*/

</style>
<?php

?>