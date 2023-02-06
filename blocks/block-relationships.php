<?php 

// GENERIC BLOCK VARS - WIP
	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');

// custom
$title_left = get_field('title_left');
$title_right = get_field('title_right');
?>

<div class="block relationships" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
	  <h2 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		
		<table class="table">
  <thead>
    <tr>
      <th scope="col"><?php echo $title_left; ?></th>
      <th scope="col"><?php echo $title_right; ?></th>
    </tr>
  </thead>
  <tbody>
	  
	  
	  	  <?php while(the_repeater_field('rows')): ?>
			
		 <tr>
      <!-- th scope="row">1</th -->
      <td><?php echo get_sub_field('left_column_text'); ?></td>
      <td><?php echo get_sub_field('right_column_text'); ?></td>

    </tr>
					

				<?php endwhile; ?>
		
	  
	  
    
  </tbody>
</table>
		
		
		
		
	
					
		
		
		
	</div>
</div>