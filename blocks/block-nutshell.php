<?php 

// GENERIC BLOCK VARS - WIP	
$title = get_field('title');
$title_colour = get_field('title_colour');
$text = get_field('text');
$text_colour = get_field('text_colour');
$background_colour = get_field('background_colour');	
$background_image = get_field('background_image');
$icon = get_field('icon');

?>

<div class="block <?php if(!$title){echo 'bug-hide';}?> nutshell" style="background-color: <?php echo $background_colour; ?> !important; background-image: url(<?php echo $background_image; ?>); !important; background-size: cover !important;">
	<div class="container" style="color: <?php echo $text_colour; ?> !important">
		<div class="icon" style="background-image: url(<?php echo $icon; ?>); !important;"></div>
	  	<h2 class="title block-title" style="color: <?php echo $title_colour; ?> !important"><?php echo $title; ?></h2>
		<section class="slickjs">
			<?php while(the_repeater_field('rows')): ?>
				<div class="row">
					<div class="col col-3">
						<div class='media'>
							<img class="d-block w-100" src='<?php echo get_sub_field('media'); ?>'>
						</div>
					</div>
					<div class="col col-9" style="color: <?php echo $text_colour; ?> !important">
						<h3 class="title" style="color: <?php echo $title_colour; ?> !important"><?php echo get_sub_field('title'); ?></h3>
						<?php echo get_sub_field('text',false,false); ?>				
					</div>
				</div>
			<?php endwhile; ?>
		</section>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.slickjs').slick({
				dots: true,
				infinite: true,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				centerMode: false,
				draggable: true,
				infinite: true,
				pauseOnHover: false,
				swipe: true,
				touchMove: true,
				vertical: false,
				speed: 1000,
				autoplaySpeed: 5000,
				useTransform: true,
				cssEase: 'cubic-bezier(0.6, 0.04, 0.3, 1.000)',
				adaptiveHeight: false,	
		});
	});
</script>