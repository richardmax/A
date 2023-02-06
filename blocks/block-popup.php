<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$icon = get_field('icon');
$popup_title = get_field('popup_title');
$popup_text = get_field('popup_text');
$popup_title_colour = get_field('popup_title_colour');
$popup_text_colour = get_field('popup_text_colour');

?>


<div class="block popup alert alert-dismissible fade show float-right" role="alert" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important; color: <?php echo $text_colour; ?> !important">
	

  
			<div class='icon' style="background-image: url(<?php echo $icon ; ?>) !important; background-size: cover !important;"></div>
	<h4 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h4>
	
		<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  <?php echo $text; ?>
</button>
	
	
	
  <!-- button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button -->
		
	
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background-color: <?php echo $background_colour; ?>;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="color: <?php echo $popup_title_colour; ?> !important"><?php echo $popup_title; ?></h5>
		  
		  
       
      </div>
      <div class="modal-body" style="color: <?php echo $popup_text_colour; ?> !important">
        <?php echo $popup_text; ?>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>