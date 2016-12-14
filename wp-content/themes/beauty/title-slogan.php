		<?php if( !is_404() || !is_search() ) : ?>	
		
		    <div class="line clear"></div>
            
            <?php global $post; $slogan = isset( $post->ID ) ? get_post_meta( $post->ID, '_slogan_page', true ) : '' ?>
                    
            <?php yiw_string_( '<h1 id="slogan">', yiw_get_convertTags( $slogan ), '</h1><div class="line"></div>' ) ?> 
            
            <div class="space"></div>
            
        <?php endif ?>                        
            
            <div class="clear"></div>