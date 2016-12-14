<?php        
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */
 
/*
Template Name: Home
*/

if( ( is_home() || is_front_page() ) && get_option( 'show_on_front' ) == 'posts' ) {
    get_template_part( 'blog', 'home' ); 
    die;
}                           

if ( get_option( 'show_on_front' ) == 'page' && get_option( 'page_for_posts' ) != 0 ) {
    get_template_part( 'blog' ); 
    die;
}

get_header() ?>        

        <!-- START HEADER IMAGE-->
        <div id="slideshow">
            <div id="images">
	            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/AVA/xxxxxcio-front.jpg" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /> 
			</div>
		</div>
        <!-- END HEADER IMAGE --> 
    
        <div class="line clear space"></div>
        
        <div class="layout-<?php echo yiw_get_layout_page() ?>">
        
            <!-- START CONTENT -->
            <div id="content">
                <?php 
                	if ( is_front_page() )
						get_template_part( 'loop', 'page' ); 
					elseif ( is_home() )
						get_template_part( 'loop', 'index' ); 
				?> 
            </div>
            <!-- END CONTENT -->
            
            <?php get_sidebar() ?>
        
        </div>                        
            
        <?php clear() ?>
        
        <div class="boxs-home">    
		  <?php dynamic_sidebar( 'Home Row' ) ?>    
		</div>
    
        <div class="line clear"></div> 
        
<?php get_footer() ?>
