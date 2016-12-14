<?php
/* Define the custom box */

// WP 3.0+
add_action('add_meta_boxes', 'yiw_admin_add_custom_box');

// backwards compatible
//add_action('admin_init', 'yiw_admin_add_custom_box', 1);

// adding some style
function yiw_admin_style_init()
{
	wp_enqueue_style('my_meta_css', get_template_directory_uri() . '/admin-options/include/metaboxes.css');
}
add_action( 'admin_init', 'yiw_admin_style_init' );

/* Do something with the data entered */
add_action('save_post', 'yiw_admin_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function yiw_admin_add_custom_box() {
    //add_meta_box( 'admin_sectionid', __( 'My Post Section Title', 'admin_textdomain' ), 'admin_inner_custom_box', 'post' );
    
	// page
	add_meta_box( 'admin_sidebar_page', __( 'Options of page', 'yiw' ), 'yiw_admin_options_page_inner_custom_box', 'page', 'side' );     
    add_meta_box( 'admin_slogan_page', __( 'Slogan Page', 'yiw' ), 'yiw_admin_slogan_page_inner_custom_box', 'post', 'side', 'high' );
    add_meta_box( 'admin_remove_wpautop_page', __( 'Remove WpAutoP filter.', 'yiw' ), 'yiw_admin_remove_wpautop_page_inner_custom_box', 'page', 'normal', 'high' );
    add_meta_box( 'admin_extra_content_page', __( 'Extra Content', 'yiw' ), 'yiw_admin_extra_content_page_inner_custom_box', 'page', 'normal', 'high' );
}                         

/* When the post is saved, saves our custom data */
function yiw_admin_save_postdata( $post_id ) {

	if ( isset( $_POST['admin_noncename'] ) AND !wp_verify_nonce( $_POST['admin_noncename'], plugin_basename(__FILE__) )) 
		return $post_id;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;    
	
	if ( isset( $_POST['post_type'] ) AND 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		  return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		  return $post_id;
	}
	
	$custom_keys['hidden'] = array();
	$custom_keys['public'] = array();
	
	if( isset( $_POST['post_type'] ) )
	{
		switch( $_POST['post_type'] )
		{
			case 'page' :
				$custom_keys['hidden'][] = 'layout_page';
				$custom_keys['hidden'][] = 'sidebar_choose_page';  
				$custom_keys['hidden'][] = 'sidebar_layout';  
				$custom_keys['hidden'][] = 'slider_accordion_show';  
				$custom_keys['hidden'][] = 'slider_accordion_name';  
				$custom_keys['hidden'][] = 'slogan_page';  
				$custom_keys['hidden'][] = 'show_title_page';
				$custom_keys['hidden'][] = 'page_remove_wpautop';
				$custom_keys['hidden'][] = 'page_extra_content';
				$custom_keys['hidden'][] = 'page_extra_content_autop';
			break;   
		}    
	}
	
	// add post metas hidden
	foreach( $custom_keys['hidden'] as $key )
	{
		if( isset( $_POST[$key] ) )
			add_post_meta( $post_id, '_'.$key, $_POST[$key], true ) or update_post_meta( $post_id, '_'.$key, $_POST[$key] );	
		else
			delete_post_meta( $post_id, '_'.$key );
	}
	
	return;
}



// ========================== OPTIONS PAGE ================================

/* Prints the box content */
function yiw_admin_options_page_inner_custom_box() {

	// Use nonce for verification
	wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' ); 
  
	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
	
	// LAYOUT PAGE
	$select_layout = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_layout_page', true ) : ''; 
	if( $select_layout == '' ) $select_layout = 'sidebar-right';
	
	$layouts = array(
		'sidebar-no' => 'No Sidebar',
		'sidebar-left' => 'Left Sidebar',
		'sidebar-right' => 'Right Sidebar'
	);    
	?>
	
	<div class="yiw_metaboxes">
		<p><?php _e( 'You can configure this page as you want, setting these optional options.', 'yiw' ) ?></p>   
		
		<?php           
		// SLOGAN
		$select_slogan = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slogan_page', true ) : '';     
		?>
		
		<label for="slogan_page"><?php _e( 'Slogan page', 'yiw' )?></label>    
		<p>
			<input type="text" name="slogan_page" id="slogan_page" value="<?php echo $select_slogan ?>" style="width:95%" />      
			<span><?php _e( 'Insert the slogan showed on top of this page/post.', 'yiw' ); ?></span>
		</p>                     
		
		
		<?php $select_title = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_show_title_page', true ) : 'yes'; ?>
		
		<label for="show_title_page"><?php _e( 'Show the title of this page', 'yiw' ) ?></label> 
		<p>    
			<input type="radio" name="show_title_page" id="show_title_page_yes" value="yes"<?php checked( $select_title, 'yes' ) ?> /> <label for="show_title_page_yes"><?php _e( 'Yes', 'yiw' ) ?></label>     
			<input type="radio" name="show_title_page" id="show_title_page_no" value="no"<?php checked( $select_title, 'no' ) ?> /> <label for="show_title_page_no"><?php _e( 'No', 'yiw' ) ?></label>      
		</p>
	
		<label for="layout_page"><?php _e( 'Layout Page', 'yiw' )?></label>
		
		<p>
			<select name="layout_page" id="layout_page">
			
			<?php
			foreach( $layouts as $layout => $name_layout )
			{
				$selected = '';
				
				if( $layout == $select_layout )
					$selected = ' selected="selected"';
				
				?><option value="<?php echo $layout ?>"<?php echo $selected?>><?php echo $name_layout ?></option><?php
			} ?>
			                            
			</select>
			<span class="inline"><?php _e("Select layout of page", 'yiw' ) ?></span>
		</p>                         
		
		<?php
		// SIDEBAR
		$select_sidebar = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_sidebar_choose_page', true ) : '';     
		?>
		
		<label for="sidebar_choose_page">><?php _e("Sidebar Page", 'yiw' ) ?></label>
		<p>
			<select name="sidebar_choose_page" id="sidebar_choose_page">			
				<?php
				foreach( $GLOBALS['wp_registered_sidebars'] as $sidebar )
				{
					$selected = '';
					if( $sidebar['name'] == $select_sidebar )
						$selected = ' selected="selected"';
					
					?><option value="<?php echo $sidebar['name'] ?>"<?php echo $selected ?>><?php echo $sidebar['name'] ?></option><?php
				} ?>
			                            
			</select>                
			<span class="inline"><?php _e("Select sidebar of page", 'yiw' ) ?></span>        
		</p>  
	</div><?php  
}

/* Enable or not the remove wpautop for main content */
function yiw_admin_remove_wpautop_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
    
  $select_autop = false;
  if ( $post_id != FALSE )
  	$select_autop = get_post_meta( $post_id, '_page_remove_wpautop', true );

  // The actual fields for data entry       
  echo '<label>';
  echo '<input type="checkbox" id="page_remove_wpautop" name="page_remove_wpautop" value="1"' . checked( $select_autop, true, false ) . ' /> ';
  _e( "Remove 'wpautop' filter to main content.", 'yiw' );
  echo '</label>';
}

/* Prints the box content */
function yiw_admin_extra_content_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $select_text = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_page_extra_content', true ) : '';     
  $select_autop = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_page_extra_content_autop', true ) : FALSE;

  // The actual fields for data entry       
  echo '<p>' . __( 'If you want, you can add some text to show above the footer, under content and sidebar.', 'yiw' ) . '</p>';
  echo '<textarea name="page_extra_content" id="page_extra_content" style="width:100%;height:200px;" />'.htmlentities($select_text).'</textarea>';   
  echo '<label>';
  echo '<input type="checkbox" id="page_extra_content_autop" name="page_extra_content_autop" value="1"' . checked( $select_autop, true, false ) . ' /> ';
  _e( 'Automatically add paragraphs', 'yiw' );
  echo '</label>';
}



// ========================== SLOGAN PAGE ================================

/* Prints the box content */
function yiw_admin_slogan_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );     
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $select = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slogan_page', true ) : '';     

  // The actual fields for data entry
  echo '<label><strong>' . __( 'Slogan page', 'yiw' ) .'</strong><br /><br />' ;
  echo '<input type="text" name="slogan_page" id="slogan_page" value="'.$select.'" />';
  echo '</label>';
}     
?>