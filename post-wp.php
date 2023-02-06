



<?php
/**
 * @package mashboardv1
 */
?>

<?php

// GEOBUBBLE - SET UP DATA ==============================================================

if (function_exists('get_field')) {
    $acf_bubble_type = get_field("bubble_type");
    $acf_bubble_class = 'block bubble-' . $acf_bubble_type;
    $number_of_comments = get_comments_number();
    $bubble_content = get_field("content");
    $acf_views_value = get_field("views") + 1;
    $acf_likes_value = get_field("likes");
    update_field('views', $acf_views_value);
}

$post_id = get_the_ID();

// find out if a gallery
$findme     = "id='gallery";
$hasgallery = strpos($bubble_content, $findme);

$media_type = null;
$url = null;

if ($acf_bubble_type == 'mb') {
    $mb_amount = get_field("mb_amount");
	$mb_currency = get_field("mb_currency");
	$mb_id = get_field("mb_id");
	$mb_type = get_field("mb_type");
}

if ($hasgallery == true) {
    $acf_bubble_class = $acf_bubble_class . ' gallery';
}

if ($acf_bubble_type == 'grafitti') {
    $grafitti_type = get_field("grafitti_type");
}

if ($acf_bubble_type == 'news') {
    $news_type = get_field("news_type");
}

if ($acf_bubble_type == 'classified') {
    $acf_classified_type = get_field("classified_type");
}

if ($acf_bubble_type == 'classified' || $acf_bubble_type == 'information' || $acf_bubble_type == 'media' || $acf_bubble_type == 'news' || $acf_bubble_type == 'event') {
    $media      = get_field("image");
    $url        = $media['url'];
    $title      = $media['title'];
    $caption    = $media['caption'];
    $icon       = $media['icon'];
    $type       = $media['mime_type'];
    $media_type = explode("/", $type);
    $media_type = $media_type[0];
    if ($media_type == 'image') {
        $url = wp_get_attachment_image_src($media['id'], 'medium');
        $url = $url[0];
    }
}

// GEOBUBBLE - END SETUP DATA =========================================================

?>


<article id="post-<?php echo get_the_ID(); ?>" <?php body_class($acf_bubble_class); ?>>

<!-- BUBBLE TYPE - PROFILE ========================================================= -->

<?php if ($acf_bubble_type == 'profile') { ?>
<div class="entry-content">
<?php echo get_avatar(get_the_author_meta('email'), '640'); ?>
	<div class='author-box'>
		<div class='author-box-bg'></div>
		<div class='author-box-content'>
			<h2>NAME: <?php the_author_meta('display_name'); ?></h2>
			<?php 
				$field          = get_field_object('profile_agenda');
				$value          = get_field('profile_agenda');
				$profile_agenda = $field['choices'][$value];
				echo '<h2>AGENDA: ' . $profile_agenda . '</h2>';
			?>
        </div>
	</div>
	
	<div class='profile-sources' >
		<h2>Social media profiles</h2>
	<?php
		$field   = get_field_object('profile_data_sources');
		$value   = $field['value'];
		$choices = $field['choices'];
		if ($value):
			$signupnetworkprofile = get_the_author_meta('user_url');
        	$signupnetworkprofileshort = 'none';
			if (strpos($signupnetworkprofile, 'facebook') !== false) {
				$signupnetworkprofileshort = 'facebook';
			} else if (strpos($signupnetworkprofile, 'linkedin') !== false) {
				$signupnetworkprofileshort = 'linkedin';
			} else if (strpos($signupnetworkprofile, 'twitter') !== false) {
				$signupnetworkprofileshort = 'twitter';
			} else if (strpos($signupnetworkprofile, 'google') !== false) {
				$signupnetworkprofileshort = 'google';
			} else if (strpos($signupnetworkprofile, 'instagram') !== false) {
				$signupnetworkprofileshort = 'instagram';
			} else if (strpos($signupnetworkprofile, 'live') !== false) {
				$signupnetworkprofileshort = 'live';
			} else if (strpos($signupnetworkprofile, 'yahoo') !== false) {
				$signupnetworkprofileshort = 'yahoo';
			}?>
			
		<ul>
		<?php foreach ($value as $v): 						  
										  						  
            if ($choices[$v] == 'SignUpNetworkProfile') {
                if ($signupnetworkprofile && $signupnetworkprofile != '') {
                    echo '<li class="' . $signupnetworkprofileshort . '"><a href="' . esc_url($signupnetworkprofile) . '" rel="author">SignUpNetworkProfile</a></li>';
                }
            } else if ($choices[$v] == 'Google' && $signupnetworkprofileshort != 'google') {
                $google_profile = get_the_author_meta('google_profile');
                if ($google_profile && $google_profile != '') {
                    echo '<li class="google"><a href="' . esc_url($google_profile) . '" rel="author">GOOGLE</a></li>';
                }
            } else if ($choices[$v] == 'LinkedIn' && $signupnetworkprofileshort != 'linkedin') {
                $linkedin_profile = get_the_author_meta('linkedin_profile');
                if ($linkedin_profile && $linkedin_profile != '') {
                    echo '<li class="linkedin"><a href="' . esc_url($linkedin_profile) . '" rel="author">LINKEDIN</a></li>';
                }
            } else if ($choices[$v] == 'Facebook' && $signupnetworkprofileshort != 'facebook') {
                $facebook_profile = get_the_author_meta('facebook_profile');
                if ($facebook_profile && $facebook_profile != '') {
                    echo '<li class="facebook"><a href="' . esc_url($facebook_profile) . '" rel="author">FACEBOOK</a></li>';
                }
            } else if ($choices[$v] == 'Instagram' && $signupnetworkprofileshort != 'instagram') {
                $instagram_profile = get_the_author_meta('instagram_profile');
                if ($instagram_profile && $instagram_profile != '') {
                    echo '<li class="instagram"><a href="' . esc_url($instagram_profile) . '" rel="author">INSTAGRAM</a></li>';
                }
            } else if ($choices[$v] == 'Twitter' && $signupnetworkprofileshort != 'twitter') {
                $twitter_profile = get_the_author_meta('twitter_profile');
                if ($twitter_profile && $twitter_profile != '') {
                    echo '<li class="twitter"><a href="' . esc_url($twitter_profile) . '" rel="author">TWITTER</a></li>';
                }
            }
        endforeach; ?>
		</ul>
     	<br>     
	<?php endif; ?>
    </div>
    
    <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
    <?php echo '<p>' . $bubble_content . '</p>'; ?>
</div>
<?php } else if ($acf_bubble_type != 'chat') { ?>



	
						      
<!-- BUBBLE TYPE != PROFILE, CHAT ========================================================= -->
 
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>
  
 
  
   
    
     <?php if ($acf_bubble_type != 'grafitti' && $acf_bubble_type != 'question'  && $acf_bubble_type != 'forum'   && $acf_bubble_type != 'alert'  && $acf_bubble_type != 'game'  && $acf_bubble_type != 'advert' ){ ?>
		<!-- has content  -->	  
			  <div class="entry-content">
    <?php } 
	
	
	
	
	if ($acf_bubble_type == 'questionnaire') { ?>

<!-- BUBBLE TYPE - QUESTIONNAIRE ========================================================= -->


	<?php echo do_shortcode('[gravityform id="' . $bubble_content[id] . '" title="false" description="true" ajax="true"]'); ?>



<?php }else { ?>
	
	<!-- BUBBLE TYPE != PROFILE, QUESTIONNAIRE, CHAT ========================================================= -->
       
	
	<?php	
		if ($media_type == 'video') {
			// BUBBLE TYPE == MEDIA (VIDEO) =====================================================================================
            echo '<video class="html5video feedhtml5video" width="100%" height="100%" controls><source src="' . $url . '" type="' . $type . '">Sorry we cant play this video.</video>';
	} else if ($media_type == 'audio') {
			// BUBBLE TYPE == MEDIA (VIDEO) =====================================================================================
            echo '<audio controls><source src="horse.ogg" type="audio/ogg"><source src="' . $url . '" type="' . $type . '">Sorry we cannot play this audio file.</audio>';
        } else {
			// BUBBLE TYPE == MEDIA (VIDEO) =====================================================================================
            echo '<img src="' . $url . '" class="feedphoto" />';
        }
    
echo $bubble_content; 
	}			  
}
				  
				  ?>
</div><!-- .entry-content -->
			  

   
   
    

   
<div class="entry-meta">

 
 
 
 
 
 
	 <span class='geobmeta meta-views' href='#'><?php echo $acf_views_value; ?></span>
	 <span class='geobmeta meta-saves' href='#'>17</span> 
	 <span class='geobmeta meta-price' href='#'>16</span>
	 <span class='geobmeta meta-likes' href='#'><?php echo $acf_likes_value; ?></span> 
	 <span class='geobmeta meta-comments' href='#'><?php echo $number_of_comments; ?></span>
	 <?php
		if($acf_bubble_type != 'profile'){
			echo get_avatar(get_the_author_meta('ID'), 100);
		}
	 ?>
	 <span class="footer-txt posted-on"><?php echo get_the_date('l'); ?></span>   
	 <?php if (!empty($cost)) { ?>
     <span class='geobmeta meta-cost' href='#'>£<?php echo $cost; ?>
     <?php if ($acf_classified_type == 'rent') {
        echo '<span class="small"> /' . get_field("item_time_unit") . '</span>';
     } ?></span>
<?php } ?>
</div><!-- .entry-meta -->

<!-- COMMENTS START -->
<?php
	if ($acf_bubble_type == 'questionnaire' || $acf_bubble_type == 'profile') {
		// no comments
	} else if ($acf_bubble_type == 'chat') {
		echo do_shortcode('[chat blocked_ip_addresses_active="disabled" box_send_button_enable="enabled" ]');
	} else if (comments_open()) {
		// If comments are open or we have at least one comment, load up the comment template.			
		
		
		
		
		
		
		
		
		
		
		

$number_of_comments  = get_comments_number();

if ( post_password_required() ) {
	return;
}

?>
<h2 class="comments-title">Recent Comments</h2>
<div id="comments" class="comments-area comments-left">
	<?php if ( have_comments() ) : ?>
		
		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'avatar_size' => 64,
					'short_ping' => true,
				) );
			?>
		</ol><!-- .comment-list -->

	<?php endif; // have_comments() ?>
    <?php $args = array(
  'label_submit'      => __( 'Comment' ),
  'comment_notes_after' => '',
  'logged_in_as' => '',
  'title_reply' => '',
);

?>

<div class='appfooter appfooter-left'>
	<?php comment_form($args); ?>
</div>
</div><!-- #comments -->
		
		
		
		
		
	<?php	
		
		
	}
?>

<div class="money-button"
  data-to="<?php echo $mb_id; ?>"
  data-amount="<?php echo $mb_amount; ?>"
  data-currency="<?php echo $mb_currency; ?>"
  data-label="fsdfds"  data-client-identifier="cd15f7de8cd43ce3ff6989936b7a0c5f"data-button-id="1615203328104"
  data-button-data="{}"
  data-type="<?php echo $mb_type; ?>"
></div>
<script src="https://www.moneybutton.com/moneybutton.js"></script>

</article><!-- #post-## -->
