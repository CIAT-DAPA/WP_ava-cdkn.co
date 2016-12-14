<?php        
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */
 
get_header() ?>                     
        
        <!-- START CONTENT -->
        <div id="content">
            <?php get_template_part('loop', 'index') ?>
        </div>                       
        <!-- END CONTENT -->
        
        <?php get_sidebar( 'blog' ) ?>  
    
        <div class="line clear"></div>        
        
<?php get_footer() ?>
