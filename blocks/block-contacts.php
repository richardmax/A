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

<div class="block contacts" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
	 
	 
		
		<div class='grid'>
					
			  <?php while(the_repeater_field('rows')): ?>

			

<div class="card item" >
	<a href="<?php echo get_sub_field('link'); ?>">
  <div class="card-body">
    <h5 class="card-title"><?php echo get_sub_field('name'); ?></h5>
    <h5 class="card-title"><?php echo get_sub_field('jobtitle'); ?></h5>
       <p><?php echo get_sub_field('description'); ?></p>
	</div>

	</a>
</div>		


			
				<?php endwhile; ?>
		
		</div>
		
	</div>
</div>

