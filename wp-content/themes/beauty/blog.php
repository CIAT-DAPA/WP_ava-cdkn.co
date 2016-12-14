<?php       
/**
 * @package WordPress
 * @subpackage Beauty & Clean
 * @since 1.0
 */
 
/*
Template Name: Blog
*/

get_header() ?>                     
        
        <?php global $paged ?>
        <?php $paged = (get_query_var('page')) ? get_query_var('page') : 1; ?>
        <?php query_posts('cat=' . yiw_exclude_categories() . '&paged=' . $paged) ?>
        
        <!-- START CONTENT -->
        <div id="content">
            <?php get_template_part('loop', 'index') ?>
        </div>                       
        <!-- END CONTENT -->
        
        <?php get_sidebar( 'blog' ) ?>  
    
        <div class="line clear"></div>        
        
<?php get_footer() ?>
