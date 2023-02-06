<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$form = get_field('form');

?>

<div class="block form" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	 	<h2 class="title" style="color: <?php echo $title_colour; ?> !important">Playbook Feedback</h2>
		 <?php echo do_shortcode('[contact-form-7 id="13606" title="Playbook Feedback"]'); ?>
	</div>
</div>