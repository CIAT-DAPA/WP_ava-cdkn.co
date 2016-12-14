	        <?php 
	            global $yiw_shortname, $yiw_theme_options; 
	            $type = $yiw_theme_options['footer_type']; 
	        ?>
	        
	        <!-- START FOOTER -->
	        <div id="footer">
	        
	        <?php if( $type == 'normal' ) : ?>
	        
	            <p class="left">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/AVA/footer-instit.jpg" alt="<?php bloginfo('name'); ?>" />
                        <br>Contacte con el administrador<a class="smcf-link" href="/contact"> aquí </a>.
	                <br><?php yiw_convertTags( stripslashes( $yiw_theme_options['copyright_text_left'] ) ) ?>
                    </p>

	            <!-- <p class="right">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/AVA/footer-instit.jpg" alt="<?php bloginfo('name'); ?>" />
	                <br><?php yiw_convertTags( stripslashes( $yiw_theme_options['copyright_text_right'] ) ) ?>  
	            </p> -->
	            
	        <?php elseif( $type == 'centered' ) : ?> 
	            
	            <p style="text-align:center;">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/AVA/footer.jpg" alt="<?php bloginfo('name'); ?>" />
	                <br><?php yiw_convertTags( stripslashes( $yiw_theme_options['footer_text_centered'] ) ) ?>  
	            </p>
	            
	        <?php endif ?>
	        
	        </div>
	        <!-- END FOOTER -->     
	    
	        <div class="clear"></div> 
	    
		</div>     
	    <!-- END WRAPPER --> 
	    
	</div>
	<!-- END WRAPSHADOW -->       
    
    <?php wp_footer() ?>   


</body>

</html>
