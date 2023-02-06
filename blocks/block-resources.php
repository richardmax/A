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

<div class="block resources" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" >
		

					
			  <?php while(the_repeater_field('rows')): ?>
		
		
		<h3 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo get_field('title'); ?></h3>
		<ul>
					<?php while(the_repeater_field('rows_secondary')): ?>
		
		
<li>
						<?php //echo get_field('internal-external',false,false); ?>
						<?php echo get_sub_field('number',false,false); ?>
						<?php //echo get_field('link',false,false); ?>
						<?php echo get_sub_field('resource_name',false,false); ?>
			
			</li>
			
					<?php endwhile; ?>
		</ul>
		<p><?php echo get_field('text',false,false); ?></p>
		<div class="footer small"><?php echo get_field('text_footer'); ?></div>

				<?php endwhile; ?>
		

		
	</div>
</div>