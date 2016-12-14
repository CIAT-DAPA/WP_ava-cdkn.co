
                <div class="widget">            
                    <h3><?php _e( 'Search' ) ?></h3>
                    <?php get_search_form() ?>
                </div>
                
                <div class="widget">
                    <h3><?php _e( 'Archives' ) ?></h3>
                    <ul>
                        <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
                    </ul>
                </div>
                
                <div class="widget">
                    <h3><?php _e( 'Categories' ) ?></h3>
                    <ul>
                        <?php 
                            global $yiw_theme_options; 
                            
                			$cat_params = Array(
                					'hide_empty'	=>	FALSE,
                					'title_li'		=>	''
                				);
                			if( isset( $yiw_theme_options['blog_cats_exclude'][2] ) > 0 ){
                				$cat_params['exclude'] = implode( ', ', $yiw_theme_options['blog_cats_exclude'][2] );
                			}
                			wp_list_categories( $cat_params ); 
                        ?>
                    </ul>
                </div>
                
                <div class="widget">
                    <h3><?php _e( 'Blogroll' ) ?></h3>
                    <ul>
                        <?php wp_list_bookmarks( 'title_li=&categorize=0' ) ?>
                    </ul>
                </div>
                