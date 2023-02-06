<?php 

// GENERIC BLOCK VARS - WIP	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');
$icon = get_field('icon');

// custom
$galleryitems = get_field('gallery');

?>

<div class="block gallery upshot" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
<div class="container" style="color: <?php echo $text_colour; ?> !important">
	
	
	
	
	<div class="icon" style="background-image: url(<?php echo $icon; ?>); !important;"></div>
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<?php echo $text; ?>
		
	
			<?php if( $galleryitems ): ?>

	
			  <div class="grid">
				  <?php foreach( $galleryitems as $galleryitem ): ?>
				  

<div class="card item audio" >
  <div class="card-body">
	  <?php //print_r($galleryitem); ?>
	  	<audio controls>
			<!-- source src="horse.ogg" type="audio/ogg" -->
			<source src="<?php echo $galleryitem['url']; ?>">
			Your browser does not support the audio element.
		</audio>
	  <h3 class='title'><?php echo $galleryitem['title']?></h3>
	  <small>
		  <?php echo $galleryitem['description']?></small>
	</div>
</div>		
 	



<?php endforeach; ?>
</div>
		<?php endif; ?>
		
	
	</div>
</div>