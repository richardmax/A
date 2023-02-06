<?php 

$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text', false, false);
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_icon = get_field('background_icon');
$icon = get_field('icon');
$summary = get_field('summary');
$instructions = get_field('instructions');
$layout = get_field('layout');

?>

<header class="block <?php if(!$title){echo 'wp-title';}?> entry-header" style="background-color: <?php echo $background_colour; ?> !important; background-icon: url(<?php echo $background_icon; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
		<?php if($layout != 'default'){ ?>
			<div class="row">
				<div class="col-lg">
		<?php } ?>
		<?php if($icon){ ?>
					<img class='media' src="<?php echo $icon; ?>">
		<?php }else{ ?>
					<h1 class='h1 heading'><?php the_title(); ?></h1>
					<h2 class="display-3 h2 title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<?php }?>
	    <?php if($layout != 'default'){ ?>
				</div>
	    		<div class="col-lg">
	    <?php } ?>
	    <?php if($icon){ ?>
					<h1 class='h1 heading'><?php the_title(); ?></h1>
					<h2 class="display-3 h2 title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<?php } ?>
					<div class='lead'><?php echo $text; ?></div>
					<div class="summary"><?php echo $summary; ?></div>
		<?php if($layout != 'default'){ ?>
				</div>
  			</div>
		<?php } ?>
	</div>
</header>