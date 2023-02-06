<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text', false, false);
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

?>

<div class="block hero jumbotron" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  
		<div class="row">
    <div class="col-sm">
      
    </div>
    <div class="col-sm align-self-center">
      <h2 class="title display-3" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<p class='lead'><?php echo $text; ?></p>
	  <!-- p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p -->
    </div>
  </div>
			</div>
</div>