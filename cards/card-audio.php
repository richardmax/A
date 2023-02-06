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