<?php

class yiw_last_news extends WP_Widget 
{
    function yiw_last_news() 
    {
		$widget_ops = array( 
            'classname' => 'last-news', 
            'description' => __('The last news.', 'yiw') 
        );

		$control_ops = array( 'id_base' => 'last-news' );

		$this->WP_Widget( 'last-news', 'Last News', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
    {
        extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Last News', 
            'items' => 2,     
            'show_date' => 'yes',
            'show_author' => 'yes',
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults );

        echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;
        
            $posts_news = new WP_Query( array( 'post_type' => 'yiw_news', 'posts_per_page' => $instance['items'] ) );
             
            while( $posts_news->have_posts() ) : $posts_news->the_post();
        ?>
        
        <div class="box-post">
            <?php 
                $img = '';
                if( has_post_thumbnail() )
                {
                    $img = get_the_post_thumbnail( get_the_ID(), 'thumb-recentposts' );
                }
                else
                {
                    $img = '<img src="' . get_template_directory_uri() . '/images/no_image_recentposts.jpg" width="55" height="55" alt="No Image" />';
                } 
                
                echo $img;
            ?>
            
            <a class="title" href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a>
            
            <p class="meta">
                <?php if( $instance['show_date']   == 'yes' ) : ?><span class="date"><?php echo get_the_date( get_option( 'date_format' ) ) ?></span><?php endif ?>
                <?php if( $instance['show_author'] == 'yes' ) : ?><span class="author"><?php _e( 'by', 'yiw' ) ?> <?php the_author() ?></span><?php endif ?>
            </p>
        </div>
         
        <?php endwhile; 
        
        echo $after_widget;
	}

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['items'] = $new_instance['items'];           

		$instance['show_date'] = $new_instance['show_date'];

		$instance['show_author'] = $new_instance['show_author'];

		return $instance;
	}

    function form( $instance ) 
    {
        global $yiw_icons_name, $yiw_fxs, $yiw_easings;
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Last News', 
            'items' => 2,     
            'show_date' => 'yes',
            'show_author' => 'yes',
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'yiw' ) ?>:
			     <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'items' ); ?>"><?php _e( 'Items', 'yiw' ) ?>:
			     <input type="text" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" value="<?php echo $instance['items']; ?>" size="3" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show date', 'yiw' ) ?>:
			     <select id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>">
			         <option value="yes"<?php selected( $instance['show_date'], 'yes' ) ?>>Yes</option>
			         <option value="no"<?php  selected( $instance['show_date'], 'no'  ) ?>>No</option>
                 </select>
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show author', 'yiw' ) ?>:
			     <select id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>">
			         <option value="yes"<?php selected( $instance['show_author'], 'yes' ) ?>>Yes</option>
			         <option value="no"<?php  selected( $instance['show_author'], 'no'  ) ?>>No</option>
                 </select>
		    </label>
        </p>
    <?php
    }
}

?>
