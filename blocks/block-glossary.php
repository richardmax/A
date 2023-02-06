<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$glossary = get_field('glossary');

?>

<div class="block glossary" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
	 
	 <?php echo $text; ?>
		
		<div class="terms">
					
			  <ul>
				  
				 
			
			
			
			<?php
			
		

if( $glossary ): 

	// override $post
	foreach( $glossary as $post): 
	setup_postdata( $post ); 

	?>
    <li>
    	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </li>
  
				     <?php endforeach; ?>
				  
				    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

				  
				  
				  <?php endif; ?>
				  </ul>
		
		</div>
		
	</div>
</div>