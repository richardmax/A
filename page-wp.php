<article id="post-<?php echo get_the_ID(); ?>" <?php body_class('block'); ?>>
	<div class='container'>						
		<header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>            
         </header>
		<?php the_content(); ?>
	</div>
</article>