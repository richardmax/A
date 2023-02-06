<div class="card item" >
  <div class="card-body">
    <h5 class="card-title"><?php echo $galleryitem['caption']?></h5>
	  <?php //print_r($galleryitem); ?>
	  	<video width="320" height="240" controls>
			<!-- source src="horse.ogg" type="audio/ogg" -->
			<source src="<?php echo $galleryitem['url']; ?>">
			Your browser does not support the video tag.
		</video>
	  <h5 class="card-title"><?php echo $galleryitem['description']?></h5>
	</div>
</div>		