<?php get_header(); ?>

<?php //include 'css/dynamic.css.php'; ?>


	<div id="primary" class="content-area directorys">
		<main id="main" class="site-main" role="main">

			
        	<section class="ac-container">
        
            <?php

			class Walker_Category_Posts extends Walker_Category
			{
			function start_lvl(&$output, $depth=0, $args=array()) {
			$output .= "\n<ul class='section'>\n";
			}
			 
			function end_lvl(&$output, $depth=0, $args=array()) {
			$output .= "</ul>\n";
			}

			function start_el(&$output, $item, $depth=0, $args=array(),$current_object_id = 0) {

			$output.= '<li class="header"><h2>'.esc_attr($item->name) . '</h2></li>';
			
			$taxpostargs = array(
							'post_type' => 'directory',
							'tax_query' => array(
								array(
								'taxonomy' => 'genre',
								'terms' => $item->cat_ID,
								 )
							  )
							);
			
			$posts_array = get_posts($taxpostargs);
			
			if($posts_array  ){

			$output.= '<ul class="subsection">'; 

			foreach ( $posts_array as $post ) :				setup_postdata( $post );        

					//acf
					$directory_location_array = get_field( "directory_location" , $post -> ID);
					$directory_location = $directory_location_array['address'];
					$directory_contact_number_1 = get_field( "directory_contact_number_1" , $post -> ID);
					$directory_email = get_field( "directory_email" , $post -> ID);
					$directory_website = get_field( "directory_website" , $post -> ID);
					$thumb_id = get_post_thumbnail_id( $post -> ID );
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
					$thumb_url = $thumb_url_array[0];
				
					$output.= '<li class="directory accordianitem"><input id="' . $post -> ID . '" name="accordion-1" type="radio"><label for="' . $post -> ID . '"><h2>' . $post -> post_title . '</h2><div class="directory_meta"><span class="recommendations">17</span><span class="testimonials">67</span><div style=" background-image: url(' . $thumb_url . ')" class="box directory-logo"></div></div></label>' . '<article class="ac-large"><div class="text-holder">' . $post -> post_content . '</div><div class="feedback-holder"><a href="#" class="recommendations button">19 Recommendations</a><a href="#" class="testimonials button">17 Testimonials</a></div>';
					
					$output.= '<div class="entry-meta meta-holder">';
					//$output.= '<a href="' . $directory_website . '" class="website button">View Site</a>';
					$output.= '<a href="#" class="website button">View Site</a>';
					//$output.= '<a href="tel:' . $directory_contact_number_1 . '" class="telephone button">Call Now</a>';
					$output.= '<a href="#" class="telephone button">Call Now</a>';
					//$output.= '<a href="mailto:' . $directory_email . '" class="contact button">Contact</a>';
					$output.= '<a href="#" class="contact button">Contact</a>';
					//$output.= '<a href="address:' . $directory_location . '" class="location button">Call Now</a>';
					$output.= '<a href="#" class="location button">Call Now</a>';
					$output.= '</div></article></li>';		

			endforeach; 

			$output.= '</ul>'; 

		};
			
		wp_reset_postdata();

//in this case you should create images with names of category slugs
}
 
function end_el(&$output, $item, $depth=0, $args=array()) {
$output .= "</a></li>\n";
}
}
?>

<?php wp_list_categories( array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 0,
        'echo'                => 1,
        'exclude'             => '',
        'exclude_tree'        => '',
        'feed'                => '',
        'feed_image'          => '',
        'feed_type'           => '',
        'hide_empty'          => 1,
        'hide_title_if_empty' => true,
        'hierarchical'        => true,
        'order'               => 'ASC',
        'orderby'             => 'name',
        'separator'           => '<br />',
        'show_count'          => 0,
        'show_option_all'     => '',
        'show_option_none'    => __( 'No categories' ),
        'style'               => 'list',
        'taxonomy'            => 'genre',
        'title_li'            => __( '<header class="entry-header">
                <h1 class="entry-title">Community Directory</h1>            
            </header>' ),
        'use_desc_for_title'  => 1,
		'walker' => new Walker_Category_Posts
		)
    ) 
?>

			</section>
            
		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php wp_footer(); ?>