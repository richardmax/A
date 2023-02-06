<?php get_header(); ?>



<main class="container-fluid" role="main">
			
	<?php if(is_home() && $site_uid != 'xxxricmax'){
		require 'main-posts.php'; // javascript page
	}else if(is_search()){
		// todo
	}else if(is_page('admin')){
		//ACFFrontendForm(12053,'a1','b1'); // acf front end form
		require 'page-acf.php';
	}else if(is_single() && $site_uid != 'xxxxricmax'){ // turn ricmax var into a default theme for wp
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			require 'post-wp.php';
		endwhile;
		endif;
	}else if( $site_uid == 'xxxricmax'){
	
		 add_revslider('photography-11');
	
	}else{
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			require 'page-wp.php';
		endwhile;
		endif;
	}
	?>

</main>	<!-- container-fluid -->	

<?php wp_footer(); ?>

<!-- iframe id="app_iframe" class="app_iframe" ></iframe -->

</body>
	

	
</html>