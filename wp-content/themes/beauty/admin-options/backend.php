<?php

/**
 * Custom types name
 */
define('TYPE_NEWS', 'yiw_news');  
define('TYPE_TEAM', 'yiw_team');
define('TYPE_TESTIMONIALS', 'yiw_testimonials');

add_action( 'init', 'yiw_register_post_types', 0  );
add_action( 'init', 'yiw_register_taxonomies', 0  );   
add_action( 'admin_init', 'flush_rewrite_rules' );

if( isset( $_GET['post_type'] ) )
{
	switch( $_GET['post_type'] )
	{
		case TYPE_TESTIMONIALS :
			add_action( 'manage_posts_custom_column',  'yiw_testimonials_custom_columns');
			add_filter( 'manage_edit-'.TYPE_TESTIMONIALS.'_columns', 'yiw_testimonials_edit_columns');
		break;
		
		case TYPE_TEAM :
			add_action( 'manage_posts_custom_column',  TYPE_TEAM.'_custom_columns');
			add_filter( 'manage_edit-'.TYPE_TEAM.'_columns', TYPE_TEAM.'_edit_columns');
		break;                               
	}
}

/**
 * Register post types for the theme
 *
 * @return void
 */
function yiw_register_post_types(){
  
	register_post_type(         
        TYPE_TESTIMONIALS,
        array(
		  'description' => __('Testimonials', 'yiw'),
		  'exclude_from_search' => false,
		  'show_ui' => true,
		  'labels' => yiw_label(__('Testimonial', 'yiw'), __('Testimonials', 'yiw')),
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
		  'public' => true,
		  'capability_type' => 'page',
    	  'publicly_queryable' => true,
		  'rewrite' => array( 'slug' => TYPE_TESTIMONIALS, 'with_front' => true )
        )
    ); 
  
  	register_post_type(         
        TYPE_NEWS,
        array(
		  'description' => __('News', 'yiw'),
		  'exclude_from_search' => false,
		  'show_ui' => true,
		  'labels' => yiw_label(__('News', 'yiw'), __('News', 'yiw')),
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
		  'public' => true,
		  'capability_type' => 'page',
    	  'publicly_queryable' => true,
		  'rewrite' => array( 'slug' => TYPE_NEWS, 'with_front' => true )
        )
    );    
  
	register_post_type(         
        TYPE_TEAM,
        array(
		  'description' => __('Team', 'yiw'),
		  'exclude_from_search' => false,
		  'show_ui' => true,
		  'labels' => yiw_label(__('Worker', 'yiw'), __('Workers', 'yiw'), __('Team', 'yiw')),
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
		  'public' => true,
		  'capability_type' => 'page',
    	  'publicly_queryable' => true,
		  'rewrite' => array( 'slug' => false, 'with_front' => true ),
		  'taxonomies' => array( 'team-profile' )
        )
    ); 
            
	//flush_rewrite_rules();
    
}

/**
 * Registers taxonomies
 * 
 */
function yiw_register_taxonomies()
{
    register_taxonomy('team-profile', array( TYPE_TEAM ), array(
		'hierarchical' => true,
		'labels' => yiw_label_tax(__('Profile', 'yiw'), __('Profiles', 'yiw')),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'team/profile', 'with_front' => false )
	));
}	 


         

/**
 * Create a custom fields for custom types
 */           
 
 
/**
 * yiw_testimonials
 */
function yiw_testimonials_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( "Name", 'yiw' ),
		"image" => __( "Image", 'yiw' ),
		"story" => __( "Story", 'yiw' )
	);
	
	return $columns;
}

function yiw_testimonials_custom_columns($column){
	global $post;
	                                      
	switch ($column) {
		case "story":                      
			add_filter('excerpt_length', 'yiw_new_excerpt_length_testimonial');
			add_filter('excerpt_more', 'yiw_new_excerpt_more_testimonial');
		  	
			the_excerpt();     
		  	break;
		case "image":
		  	the_post_thumbnail( 'thumbnail' );
		  	break;
	}                                  

}	                  
	
function yiw_new_excerpt_length_testimonial($length) {
	return 20;
}                                
	
function yiw_new_excerpt_more_testimonial($more) {
	return '[...]';
} 
 
 
/**
 * yiw_team
 */
function yiw_team_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( "Name", 'yiw' ),
		"photo" => __( "Photo", 'yiw' ),
		"description" => __( "Description", 'yiw' ),
		"profile" => __( "Profile", 'yiw' )
	);
	
	return $columns;
}

function yiw_team_custom_columns($column){
	global $post;
	
	switch ($column) {
		case "description":
		  the_excerpt();
		  break;
		case "photo":
		  the_post_thumbnail('team-thumb');
		  break;
		case "profile": 
		  echo get_the_term_list($post->ID, 'team-profile', '', ', ','');     
		  break;
	}
}  



add_action( 'admin_head', 'yiw_admin_style' );
function yiw_admin_style() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-team .wp-menu-image {
            background:transparent url('<?php echo home_url();?>/wp-admin/images/menu.png') no-repeat scroll -301px -33px !important;
        }
		#menu-posts-team:hover .wp-menu-image, #menu-posts-team.wp-has-current-submenu .wp-menu-image {
            background-position:-301px -1px!important;
        }
        #menu-posts-blportfolio .wp-menu-image, #menu-posts-blgallery .wp-menu-image {
            background:transparent url('<?php echo home_url();?>/wp-admin/images/menu.png') no-repeat scroll -1px -33px !important;
        }
		#menu-posts-blportfolio:hover .wp-menu-image, #menu-posts-blportfolio.wp-has-current-submenu .wp-menu-image,
		#menu-posts-blgallery:hover .wp-menu-image, #menu-posts-blgallery.wp-has-current-submenu .wp-menu-image {
            background-position:-1px -1px!important;
        }
    </style>
<?php } 



/**
 * Return Labels Post
 *
 * @return array
 */
function yiw_label($singular_name, $name, $title = FALSE)
{
	if( !$title )
		$title = $name;
		
	return array(
      "name" => $title,
      "singular_name" => $singular_name,
      "add_new" => __("Add New", 'yiw'),
      "add_new_item" => sprintf( __( "Add New %s", 'yiw' ), $singular_name),
      "edit_item" => sprintf( __( "Edit %s", 'yiw' ), $singular_name),
      "new_item" => sprintf( __( "New %s", 'yiw'), $singular_name),
      "view_item" => sprintf( __( "View %s", 'yiw'), $name),
      "search_items" => sprintf( __( "Search %s", 'yiw'), $name),
      "not_found" => sprintf( __( "No %s found", 'yiw'), $name),
      "not_found_in_trash" => sprintf( __( "No %s found in Trash", 'yiw'), $name),
      "parent_item_colon" => ""
  );
}	 	     

/**
 * Return Labels Post
 *
 * @return array
 */
function yiw_label_tax($singular_name, $name)
{
	return array(
      	'name' => $name,
		'singular_name' => $singular_name,
		'search_items' => sprintf( __( 'Search %s', 'yiw' ), $name),
		'all_items' => sprintf( __( 'All %s', 'yiw' ), $name),
		'parent_item' => sprintf( __( 'Parent %s', 'yiw' ), $singular_name),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'yiw' ), $singular_name),
		'edit_item' => sprintf( __( 'Edit %', 'yiw' ), $singular_name), 
		'update_item' => sprintf( __( 'Update %s', 'yiw' ), $singular_name),
		'add_new_item' => sprintf( __( 'Add New %s', 'yiw' ), $singular_name),
		'new_item_name' => sprintf( __( 'New %s Name', 'yiw' ), $singular_name),
		'menu_name' => $name,
  );
}

add_action( 'admin_enqueue_scripts', 'yiw_custom_admin_scripts');
function yiw_custom_admin_scripts() {
    wp_enqueue_script( 'jquery-custom-admin', get_bloginfo('template_directory').'/admin-options/include/jquery.custom.admin.js', array(), '1.0', true );
}