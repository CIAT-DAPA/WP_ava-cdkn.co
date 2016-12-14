            <?php wp_reset_query() ?>                  
			
            <?php if( yiw_get_layout_page() != 'sidebar-no' ) : ?>       
				
				<!-- START SIDEBAR -->
				<div id="sidebar">  
		
					<?php do_action( 'yiw_before_sidebar' ) ?> 
					<?php do_action( 'yiw_before_sidebar_' . yiw_current_pagename() ) ?> 
					
	                <?php 
	                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( get_post_meta( get_the_ID(), '_sidebar_choose_page', true ) ) )
	                        get_sidebar( 'default' ) 
	                ?>
			
					<?php do_action( 'yiw_after_sidebar' ) ?>       
					<?php do_action( 'yiw_after_sidebar_' . yiw_current_pagename() ) ?>          
				
				</div>
				<!-- END SIDEBAR -->			
				
            <?php endif ?>