<?php        
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */                        

get_header() ?>    
        
        <div class="layout-<?php echo yiw_get_layout_page() ?>">
        
            <!-- START CONTENT -->
            <div id="content">
                <?php get_template_part( 'loop', 'page' ) ?> 
                
                <?php comments_template() ?>
            </div>
            <!-- END CONTENT -->
            
            <?php get_sidebar() ?>
        
        </div>   
                              
        <!-- START EXTRA CONTENT -->
		<?php get_template_part( 'extra-content' ) ?>      
        <!-- END EXTRA CONTENT -->
    
        <div class="line clear"></div>        
        
<?php get_footer() ?>
