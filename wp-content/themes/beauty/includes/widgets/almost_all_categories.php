<?php
class yiw_almost_all_categories extends WP_Widget
{
    function yiw_almost_all_categories() 
    {
		$widget_ops = array( 
            'classname' => 'almost-all-categories', 
            'description' => __('Get list of categories, without categories excluded from options panel.', 'yiw') 
        );

		$control_ops = array( 'id_base' => 'almost-all-categories' );

		$this->WP_Widget( 'almost-all-categories', 'Almost Categories', $widget_ops, $control_ops );
	}
	
	function form( $instance )
	{
        /* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Categories'
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><label>
			<strong><?php _e( 'Widget Title', 'yiw' ) ?>:</strong><br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</label></p>
		<p><?php _e( 'Configure this widget on the Theme Option Admin, to exclude the categories from this list.', 'yiw' ) ?></p>
		<?php
	}
	
	function widget( $args, $instance )
	{
	    global $yiw_theme_options;
	    
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		
		echo '<ul id="yiw_almost_all_categories_widget">';
			$cat_params = Array(
					'hide_empty'	=>	FALSE,
					'title_li'		=>	''
				);
			if( isset( $yiw_theme_options['blog_cats_exclude'][2] ) > 0 ){
				$cat_params['exclude'] = implode( ', ', $yiw_theme_options['blog_cats_exclude'][2] );
			}
			wp_list_categories( $cat_params );
		echo '</ul>';
		echo $after_widget;
	}                     

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
	
}     
?>
