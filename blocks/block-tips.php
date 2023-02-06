<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$type = get_field('type');
$excerpt = get_field('excerpt');

?>

<div class="block tips tips-<?php echo $type; ?>" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
	  	<div class="excerpt"><?php echo $excerpt; ?></div>
		
		<?php echo $text; ?>
	  <!-- p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p -->
	
		
	</div>
</div>