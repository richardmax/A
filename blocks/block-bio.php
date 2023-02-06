<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$name = get_field('name');
$media = get_field('media');
$link = get_field('link');

?>

<div class="block bio" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
		

  <div class="row">
    <div class="col-3" style="background-image: url('<?php echo $media; ?>'); background-repeat: no-repeat; background-size: cover; background-position:center;">
      
    </div>
    <div class="col-9">
      <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
	  <h3 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $name; ?></h3>
		<?php echo $text; ?>
		<div>
			<?php echo $link; ?></div>
    </div>
</div>
	  
		
	</div>
</div>