<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text',false,false);
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');
$icon = get_field('icon');

// custom
$type = get_field('type');

?>

<div class="block callout callout-<?php echo $type; ?>" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
		<div class="icon" style="background-image: url(<?php echo $icon; ?>); !important;"></div>
	  	<h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<p class='lead'><?php echo $text; ?></p>
	</div>
</div>