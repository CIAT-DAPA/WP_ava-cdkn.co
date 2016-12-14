<?php       
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */

get_header() ?>                     
        
        <?php if ( get_header_image() ) : ?>
        <!-- START HEADER IMAGE-->
        <div id="slideshow">
            <div id="images"><a href="http://gisweb.ciat.cgiar.org/AVA-CDKN" target="_self">
	            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/AVA/inicio-front.jpg" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />  </a>
			</div>
		</div>
        <!-- END HEADER IMAGE --> 
        <?php endif ?>     
        
        <div class="clear"></div>
        
        <?php global $paged ?>
        <?php $paged = (get_query_var('page')) ? get_query_var('page') : 1; ?>
        <?php query_posts('cat=' . yiw_exclude_categories() . '&posts_per_page=' . get_option('posts_per_page') . '&paged=' . $paged) ?>
        
        <!-- START CONTENT -->
        <div id="content">   
            <?php get_template_part('loop', 'index') ?>
        </div>                       
        <!-- END CONTENT -->
        
        <?php get_sidebar( 'blog' ) ?>  
    
        <div class="line clear"></div>        
        
<?php get_footer() ?>
