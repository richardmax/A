<nav>


<ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">

    	<a class="gn-icon gn-icon-menu gn-selected"><span>Menu</span></a>
    	
    	<!-- start - allows webapps to work properly in ios - stops pages being opened in mobile safari -->
		<script type="text/javascript">(function(document,navigator,standalone){if((standalone in navigator)&&navigator[standalone]){var curnode,location=document.location,stop=/^(a|html)$/i;document.addEventListener('click',function(e){curnode=e.target;while(!(stop).test(curnode.nodeName)){curnode=curnode.parentNode;}if('href'in curnode){e.preventDefault();location.href=curnode.href;}},false);}})(document,window.navigator,'standalone');</script>
		<!-- end - allows webapps to work properly in ios - stops pages being opened in mobile safari -->
    
    	<nav class="menu-side gn-menu-wrapper">
        	<div class="gn-scroller">



<ul class="gn-menu user-nav-items app-menu">
                
                 	<span class='user-avatar'><?php echo get_wp_user_avatar(50); ?></span>
					
					<span class='user-nav-items-wrapper'>
					<?php 

						
						wp_nav_menu(array(
								'theme_location' => 'user',
							 	'container' => false,
							 	'items_wrap' => '%3$s',
							 	'walker'        => new themeslug_walker_nav_menu
						) 
					);

?>
					
					</span>
					
				</ul>


         
		        <ul class="gn-menu main-nav-items1 app-menu">
		          
		         	<?php wp_nav_menu(
						array(
								'theme_location' => 'app',
							 	'container' => false,
							 	'items_wrap' => '%3$s',
								'walker'        => new themeslug_walker_nav_menu
						) 
					); ?>
					
		        </ul>
				
 	<div class="menu-footer"></div>
   
        </div>
        <!-- /gn-scroller --> 
  
      </nav>
      
    </li>
	
	<span class='app-logo'>
	
		<?php
	
			if(get_field('logo_type', 'option') == 'text'){
				
				the_field('logo_text', 'option'); 
				
			}else{?>
				
				<img src='<?php echo get_field('logo_url', 'option'); ?>' class='logo'>
		
			<?php }
	
	
		?>
	
	</span>
    
    <div class="pull-right create-content-but">
    	
  		
    	<!-- a class="gn-icon" target="iframe_a" onclick="load_iframe('../../../../wp-admin/post-new.php?latitude=51.535149&amp;longitude=-0.226276')" id="new-bubble-link"></a -->
		<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<!-- label class="assistive-text" for="s"><?php //esc_html_e( 'Search', 'understrap' ); ?></label -->
	<div class="input-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e( 'Search &hellip;', 'understrap' ); ?>">
		<span class="input-group-btn">
			<input class="gn-icon search submit" id="searchsubmit" name="submit" type="submit"
			value="<?php esc_attr_e( 'Search', 'understrap' ); ?>">
	</span>
	</div>
</form>
    	<a class="gn-icon" target="iframe_a" onclick="load_iframe('../../../../wp-admin/post-new.php?latitude=51.535149&amp;longitude=-0.226276')" id="new-bubble-link"></a>
		<!--a class="gn-icon linkedin" target="_blank" onclick="load_weburl('https://www.linkedin.com/in/ricmax','_blank')" ></a>
		<a class="gn-icon github" target="_blank" onclick="load_weburl('https://github.com/richardmax','_blank')" ></a>
		<a class="gn-icon instagram" target="_blank" onclick="load_weburl('https://www.instagram.com/ric.max','_blank')" ></a>
		<a class="gn-icon spotify" target="_blank" onclick="load_weburl('https://open.spotify.com/user/richardmax','_blank')" ></a>
		<a class="gn-icon soundcloud" target="_blank" onclick="load_weburl('https://soundcloud.com/dxradio','_blank')" ></a -->
    </div>
</ul>

	<?php if(is_home() || is_search()){ ?>
		<ul id="gn-menu1" class="gn-menu-main">
			<li class="gn-trigger">
			<a class="filter-but gn-icon gn-icon-menu"><span>Filters</span></a>
				<nav class="menu-side gn-menu-wrapper">
					
					<ul id="cat_filters" class="gn-menu">  
						<li><a href="#" data-filter=".block1"></a></li>
						<li><a href="#" data-filter=".block2"></a></li>
						<li><a href="#" data-filter=".block3"></a></li>
						<li><a href="#" data-filter=".block4"></a></li>
						<li><a href="#" data-filter=".block5"></a></li>
						<li><a href="#" data-filter=".block6"></a></li>
						<li><a href="#" data-filter=".block7"></a></li>
						<li><a href="#" data-filter=".block8"></a></li>
						<li><a href="#" data-filter=".block9"></a></li>
						<li><a href="#" data-filter=".block10"></a></li>
						
					</ul>
				</nav>   
			</li>
		</ul>
	<?php } ?>
		

       </nav>