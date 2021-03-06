<?php
/*
Template Name: Archives
*/
get_header(); ?>
                       
        <!-- START CONTENT -->
		<div id="content" role="main">
	
			<?php the_post(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php get_search_form(); ?>
			
			<h2><?php _e( 'Archives by Month', 'yiw' ); ?></h2>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			
			<h2><?php _e( 'Archives by Subject', 'yiw' ); ?></h2>
			<ul>
				 <?php wp_list_categories(); ?>
			</ul>
	
		</div>        
        <!-- END CONTENT -->    
        
        <?php get_sidebar( 'blog' ) ?>  
    
        <div class="line clear"></div>  

<?php get_footer(); ?>
