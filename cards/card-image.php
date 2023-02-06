<div class="card item" >
  <div class="card-body">
    <h5 class="card-title"><?php echo $galleryitem['caption']?></h5>
	  <?php //print_r($galleryitem); ?>
	   <a href="<?php echo $galleryitem['url']; ?>">
       	<img src="<?php echo $galleryitem['sizes']['thumbnail']; ?>" alt="<?php echo $galleryitem['alt']; ?>" />
       </a>
       <p><?php echo $galleryitem['caption']; ?></p -->
	  <h5 class="card-title"><?php echo $galleryitem['description']?></h5>
	</div>
</div>		