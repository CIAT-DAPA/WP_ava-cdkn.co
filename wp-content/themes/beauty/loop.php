       				<div class="clear"></div>
                    
                    <?php 
						global $wp_query, $post;
						
						$tmp_query = $wp_query;
						
						if (have_posts()) : 
                    
                    $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
                    <?php /* If this is a category archive */ if (is_category()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'yiw'), single_cat_title('', false)); ?></h3>
                    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                  <h3 class="red-normal"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'yiw'), single_tag_title('', false) ); ?></h3>
                    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Daily archive page', 'yiw'), get_the_time(__('F jS, Y', 'yiw'))); ?></h3>
                    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Monthly archive page', 'yiw'), get_the_time(__('F Y', 'yiw'))); ?></h3>
                    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Yearly archive page', 'yiw'), get_the_time(__('Y', 'yiw'))); ?></h3>
                    <?php /* If this is a yearly archive */ } elseif (is_search()) { ?>
                  <h3 class="red-normal"><?php printf( __( 'Search Results for: %s', 'yiw' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
                   <?php /* If this is an author archive */ } elseif (is_author()) { ?>               
                  <h3 class="red-normal"><?php _e('Author Archive', 'yiw'); ?></h3>
                    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                  <h3 class="red-normal"><?php _e('Blog Archives', 'yiw'); ?></h3>        
                    <?php }             
                                                       
                        while (have_posts()) : the_post(); 
                          
                        global $more;
                        
                        if ( !is_single() ) $more = 0;
                        
                        $title = is_null( the_title( '', '', false ) ) ? __( '(this post has no title)', 'yiw' ) : the_title( '', '', false );
                    ?>        
                    
                    <div id="post-<?php the_ID(); ?>" <?php post_class('hentry-post group'); ?>>                
                              
                        <div class="date">    
							<?php if ( is_single() ) : ?>                                                 
                            	<h2 class="title-blog"><?php echo $title ?></h2> 
                            <?php else : ?>	
								<h2 class="title-blog"><a href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'yiw' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo $title ?></a></h2> 
                            <?php endif; ?>
                            
                            <div class="mon-year">
                                <!--<?php echo '<span>' . get_the_time('M') . '</span><br />' . get_the_time('Y') ?>-->
                            </div>
                            
                            <div class="day">
                                <!--<?php the_time('d') ?>-->
                            </div>
                            
                            <div class="clear"></div>
                        </div>
                        
                        <div class="clear line"></div>
                       <!-- <p class="meta left"><?php _e( 'posted by', 'yiw' ) ?> <?php the_author_posts_link() ?> <?php yiw_string_( __( 'on', 'yiw' ) . ' ', get_the_category_list( ', ' ) ) ?></p> -->
                        <?php if ( comments_open() && ! post_password_required() ) : ?>
                        	<p class="meta right"><?php comments_popup_link(__('No comments', 'yiw'), __('1 comment', 'yiw'), __('% comments', 'yiw')); ?></p>
                        <?php endif; ?>
                        <div class="clear line space-content"></div>  
                            
                        <?php                  
                            global $yiw_theme_options;
    
                            $size = $yiw_theme_options['blog_image_size'];
                            
                            if( $size == 'custom' ) $size = array( $yiw_theme_options['blog_image_width'], $yiw_theme_options['blog_image_height'] );
                        ?>
                    
                        <?php 
                            if ( !$video = get_post_meta( get_the_ID(), '_video', true ) )
                                the_post_thumbnail($size, array( 'class' => $yiw_theme_options['blog_image_align'] ) ); 
                            else
                                echo apply_filters( 'the_content', $video );
                        ?>
                     
                        <?php 
                            the_content(__('|| Read more')) 
                        ?>     
                        
                        <div class="clear"></div>
                        
                        <?php wp_link_pages(); ?>
                        
						<?php edit_post_link( __( 'Edit', 'yiw' ), '<span class="edit-link">', '</span>' ); ?>
                    
					
						<?php if( is_single() ) the_tags( '<p class="list-tags">Tags: ', ', ', '</p>' ) ?>    
                    
                    </div>        
                    
                    <?php 
						endwhile;
						
						else : ?>
						
							<div id="post-0" class="post error404 not-found">
								<h1 class="entry-title"><?php _e( 'Not Found', 'yiw' ); ?></h1>
								<div class="entry-content">
									<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							</div><!-- #post-0 -->
						
						<?php
						endif;
						 
						$wp_query = $tmp_query;
						wp_reset_postdata();
					?>          
                
                    <?php 
                    if(function_exists('yiw_pagination')) : yiw_pagination(); else : ?> 
            
                        <div class="navigation">
                            <div class="alignleft"><?php next_posts_link(__('Next &raquo;', 'yiw')) ?></div>
                            <div class="alignright"><?php previous_posts_link(__('&laquo; Back', 'yiw')) ?></div>
                        </div>
                    
                    <?php endif; ?>       
        
                    <?php comments_template(); ?>

               









      <div id="gallery" style="display:none;">



<?php
    $api_key = '3d7e865caceca8f7e2c8780117727a70';
    $photoset_id = '72157677713738856';
    $user_id = '104602115@N04';
    // $perPage = 5;
  
    $url = 'https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos';
    $url.= '&api_key=' . $api_key;
    $url.= '&photoset_id=' . $photoset_id;
    $url.= '&user_id=' . $user_id;
    // $url.= '&per_page=' . $perPage;
    $url.= '&format=json';
    $url.= '&nojsoncallback=1';
  
    $response = json_decode(file_get_contents($url));
  
        $photo_array = $response->photoset->photo;
        $a = 0;
        foreach($photo_array as $single_photo) {
          $a = $a + 1;
          $farm_id = $single_photo->farm;
          $server_id = $single_photo->server;
          $photo_id = $single_photo->id;
          $secret_id = $single_photo->secret;
          $size = 'm';
          $title = $single_photo->title;
          $photo_url_short = 'https://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret_id . '_m.' . 'jpg';
          $photo_url_ori = 'https://farm' . $farm_id . '.staticflickr.com/' . $server_id . '/' . $photo_id . '_' . $secret_id . '_b.' . 'jpg';

  
  
  print '   <img src="' . $photo_url_ori . '" data-image="' . $photo_url_ori . '" data-description="' .  $title . '" style="display:none">';
  
        };
  
  
  ?>


</div>



<br />
<br />


<h4>Articulos relacionados</h4>
<ul>
 	<li>Boletín de CIAT: <a href="http://www.ciatnews.cgiar.org/es/2014/01/16/que-tan-vulnerable-es-la-cuenca-alta-del-rio-cauca-frente-al-cambio-climatico/" target="_blank">¿Qué tan vulnerable  es la Cuenca Alta del río Cauca  frente al Cambio Climático?</a></li>
</ul>





 
                	<?php clear( 'space' ) ?> 


<script type="text/javascript">
			jQuery("#gallery").unitegallery({

	slider_enable_text_panel:true,
	strippanel_enable_handle:false,
        gallery_autoplay:true,
 slider_enable_fullscreen_button: false,
strip_space_between_thumbs:32,	

			});
</script>
