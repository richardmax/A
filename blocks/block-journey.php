<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom

?>

<div class="block journey" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		
		
					
			  <?php while(the_repeater_field('rows')): ?>

						<?php echo get_sub_field('text'); ?>
					
			
					 <div class='media'>
						 <img class='image' src="<?php echo get_sub_field('media'); ?>" />

					  
			</div>

			<div class='footer'>
			<?php echo get_sub_field('text_footer'); ?>
			</div>
			<hr>

			
				<?php endwhile; ?>
		
		
		
	</div>
</div>