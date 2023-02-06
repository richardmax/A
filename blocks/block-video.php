<?php 
	
// non generic
$media = get_field('media');
$type = get_field('type');
$cookie = get_field('cookie');

?>

<div class="block video video-<?php echo $type; ?> jumbotron" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">

	<video autoplay muted loop controls class="video <?php echo $type; ?>">
  <source src="<?php echo $media; ?>" type="video/mp4">
</video>

</div>
<!-- The video -->
