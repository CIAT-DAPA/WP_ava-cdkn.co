<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 */                                                                               

// define the text domain location for the theme
define( 'ENABLE_IMPORT', 1 );
define( 'DEFAULT_COLOR_SET', '#A10404' );  
define( 'DEFAULT_FONT', 'champagne' );   

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('yiw', TEMPLATEPATH . '/languages');   

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 558;               

function yiw_warning_version_wp() {
	global $theme_update_notice, $pagenow;
	//if ( $pagenow == "themes.php") {
?>
		<div id="yiw_message" class="error fade">
		<?php _e( 'The theme you are using requires WordPress version 3.0 or higher. So, many features of it will not perform correctly.', 'yiw' ) ?>
		</div>
<?php
	//}
}                        

$yiw_shortname = 'bc'; 

if( version_compare($wp_version, "3.0", "<") )
	add_action('admin_notices', 'yiw_warning_version_wp');	    

$yiw_color_theme = (get_option('theme_color') != '') ? get_option('theme_color') : "red";   
if(isset($_COOKIE['yiw_color_theme_bc'])) $yiw_color_theme = esc_attr(strtolower($_COOKIE['yiw_color_theme_bc']));           

$yiw_actual_font = get_option( $GLOBALS['yiw_shortname'] . '_font', DEFAULT_FONT );                                          

// default theme setup
function beauty_setup() {                 
    global $wp_version;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'css/editor-style.css' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );  

	// This theme uses the menues
	add_theme_support( 'menus' );          

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Post Format support.                      
	//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );  
	
	if ( ! defined( 'BACKGROUND_COLOR' ) )
		define( 'BACKGROUND_COLOR', 'F0F1F1' );
	
	if ( ! get_theme_mod( 'background_repeat', false ) )
		set_theme_mod( 'background_repeat', 'no-repeat' );
		
	if ( ! get_theme_mod( 'background_position_x', false ) )
		set_theme_mod( 'background_position_x', 'center' );

	// This theme allows users to set a custom background   
    if( version_compare( $wp_version, '3.4', ">=" ) )
        add_theme_support( 'custom-background' );
    else
        add_custom_background();

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/slideshow/005.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'yiw_header_image_width', 864 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'yiw_header_image_height', 319 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
    if( version_compare( $wp_version, '3.4', ">=" ) )
        add_theme_support( 'custom-header', array( 'admin-head-callback' => 'yiw_admin_header_style' ) );
    else
        add_custom_image_header( '', 'yiw_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'sea' => array(
			'url' => '%s/images/slideshow/001.jpg',
			'thumbnail_url' => '%s/images/slideshow/001-thumb.png',
			/* translators: header image description */
			'description' => __( 'Sea', 'yiw' )
		),
		'flowers' => array(
			'url' => '%s/images/slideshow/002.jpg',
			'thumbnail_url' => '%s/images/slideshow/002-thumb.png',
			/* translators: header image description */
			'description' => __( 'Flowers', 'yiw' )
		),
		'portrait' => array(
			'url' => '%s/images/slideshow/003.jpg',
			'thumbnail_url' => '%s/images/slideshow/003-thumb.png',
			/* translators: header image description */
			'description' => __( 'Portrait', 'yiw' )
		),
		'hearth' => array(
			'url' => '%s/images/slideshow/004.jpg',
			'thumbnail_url' => '%s/images/slideshow/004-thumb.png',
			/* translators: header image description */
			'description' => __( 'Heart', 'yiw' )
		),
		'black-white' => array(
			'url' => '%s/images/slideshow/005.jpg',
			'thumbnail_url' => '%s/images/slideshow/005-thumb.png',
			/* translators: header image description */
			'description' => __( 'Black & White', 'yiw' )
		)
	) );

	$locale = get_locale();      
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file ); 
    
	// This theme uses wp_nav_menu() in more locations.
	register_nav_menus(
        array(
            'nav'           => __( 'Navigation' )
        )
    );
    
    // images size
    add_image_size( 'team-thumb', 100, 100 );           
	add_image_size( 'thumb-recentposts', 55, 55, true );   // for shortcode
    add_image_size( 'portfolio-thumb', 280, 149 );
	add_image_size( 'portfolio-thumb-slider', 193, 118, true );
	add_image_size( 'portfolio-thumb-gallery', 179, 179, true ); 
    
    // sidebars registers            
	register_sidebar( yiw_sidebar_args( 'Blog Sidebar', __( 'The sidebar showed on Blog and single templates of posts.', 'yiw' ) ) );  
	register_sidebar( yiw_sidebar_args( 'Home Row', __( 'The row below home content.', 'yiw' ), 'one-third', 'h2' ) );                                   
	
	// add custom style
	add_action( 'wp_head', 'yiw_custom_style', 999 );  
}
add_action( 'after_setup_theme', 'beauty_setup' );     

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function yiw_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'menu';
	return $args;
}
add_filter( 'wp_page_menu_args', 'yiw_page_menu_args' );  

$yiw_theme_modules = array(
    dirname(__FILE__) . '/../includes/colors.php',
    dirname(__FILE__) . '/../includes/fonts.php',
    dirname(__FILE__) . '/../admin-options/yiw_panel.php',
    dirname(__FILE__) . '/../admin-options/notifier/update-notifier.php',
    dirname(__FILE__) . '/../admin-options/backend.php',
    dirname(__FILE__) . '/../admin-options/metaboxes.php',           
    dirname(__FILE__) . '/../admin-options/dashboard.php',
    //dirname(__FILE__) . '/../admin-options/tinymce/tinymce.php',
    dirname(__FILE__) . '/../includes/widgets/widgets.php',
    dirname(__FILE__) . '/../includes/shortcodes.php',
    dirname(__FILE__) . '/../includes/sendemail.php'
);                              

// add lightbox to the gallery
function yiw_add_lightbox( $html, $id, $size, $permalink, $icon, $text ) {
	if ( ! $permalink )
		return str_replace( '<a', '<a rel="prettyPhoto[gallery]"', $html );
	else
		return $html;
}
add_filter( 'wp_get_attachment_link', 'yiw_add_lightbox', 10, 6 );

function yiw_custom_style()
{
    global $yiw_theme_options;
	yiw_string_( '<style type="text/css">', stripslashes_deep( $yiw_theme_options['custom_style'] ), '</style>' );
}

function yiw_sidebar_args( $name, $description = '', $widget_class = 'widget', $title = 'h3' )
{   
	$id = strtolower( str_replace( ' ', '-', $name ) );
	
    return array(
        'name' => $name,
        'id' => $id,
        'description' => $description,
		'before_widget' => '<div id="%1$s" class="' . $widget_class . ' %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<' . $title . '>',
		'after_title' => '</' . $title . '>',
    );
}                          

if ( ! function_exists( 'yiw_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function yiw_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

// sort array
function yiw_subval_sort($a, $subkey) 
{
	if( is_array($a) AND !empty($a) )
	{
		foreach($a as $k => $v) 
		{
			$b[$k] = strtolower( $v[$subkey] );
		}
		
		asort($b);
		
		foreach($b as $key => $val) 
		{
			$c[] = $a[$key];
		}
		
		return $c;
	}
	
	return $a;
}                          

$yiw_message = '';           


// set of icons
$yiw_icons_name = array(            
    'bag', 'box', 'bubble', 'bulb',
    'calendar', 'cart', 'chart', 'clipboard', 'coffee',
    'diagram', 'doodles',
    'gear', 'gift', 'globe',
    'info',
    'label', 'letter',
    'moleskine', 'monitor', 'mphone',
    'new',
    'open',
    'pc', 'pencil', 'phone', 'pictures', 'postit',
    'qmark',
    'refresh',
    'shopbag', 'statistics',
    'testimonial', 'tick',
    'bag-grey', 'card-grey', 'cart-grey', 'mail-grey', 'pencil-grey', 'phone-grey', 'users-grey'
);  

// tags for text
$yiw_tags_allowed = array(
    'name_site' => get_bloginfo('name'),
    'description_site' => get_bloginfo('description'),
    'site_url' => site_url()
);
              
// include theme modules           
foreach ( $yiw_theme_modules as $module )
    if ( file_exists( $module ) )
        include_once $module;
unset( $module );         

function yiw_catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

    if(empty($first_img)){ //Defines a default image
      $first_img = get_stylesheet_directory_uri()."/images/default.gif";
    }
    return $first_img;
}              

$count = 0;   

/**if ( ! function_exists( 'yiw_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 
function yiw_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['count'] = $GLOBALS['count']+1;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-container">
    		<div class="comment-author vcard">
    		    <?php $url = get_template_directory_uri() . '/images/noavatar.png'; ?>
    			<?php echo get_avatar( $comment, 75,$default=$url ); ?>
    			<?php printf( __( '%s ', 'yiw' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
    		</div><!-- .comment-author .vcard -->
    		
    		<div class="comment-meta commentmetadata">
                <?php if ( $comment->comment_approved == '0' ) : ?>
        			<em class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'yiw' ); ?></em>
        			<br />
        		<?php endif; ?>
        		
        		<div class="intro">
            		<div class="commentDate">
            		  <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
            			<?php
            				/* translators: 1: date, 2: time 
            				printf( __( '%1$s at %2$s', 'yiw' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'yiw' ), ' ' );
            			?>
        			</div>

        			<div class="commentNumber">#&nbsp;<?php echo $GLOBALS['count'] ?></div>
        		</div>
        			
    			<div class="comment-body"><?php comment_text(); ?></div>
    			
    			
    			<div class="reply">
        			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        			<?php clear() ?>
        		</div><!-- .reply -->
    		</div><!-- .comment-meta .commentmetadata -->
    	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'yiw' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'yiw'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
*/
function yiw_current_pagename()
{
	global $post;
	
	if ( isset( $post->post_name ) )
		return $post->post_name;
	else
		return '';
}       

function yiw_exclude_categories()
{
    global $yiw_theme_options;
    
    if ( !isset( $yiw_theme_options['blog_cats_exclude'][1] ) )
        return;
    
    $cats = $yiw_theme_options['blog_cats_exclude'][1];
    
    $return = implode( ', -', $cats );
    if ( $return != '' )
        $return = '-' . $return;
    
    return $return;
}

// --------------- SCRIPTS JS --------------------
function yiw_add_footer_js_scripts() {   
?>	    
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("a[rel^='prettyPhoto']").prettyPhoto({
        });
                //$yiw_shortname . '_portfolio_skin_lightbox'
                theme: '<?php echo get_option('_portfolio_skin_lightbox') ?>'});
    </script>              
    
    <script type="text/javascript">
        //<![CDATA[
        Cufon.now();  //]]>
    </script>      
<?php
}
add_action( 'wp_footer', 'yiw_add_footer_js_scripts' );
        
//------------------------------------------------------------------------------
// CHECK EMAIL
//------------------------------------------------------------------------------
function yiw_checkMail($m) {
	$r = "([A-z0-9]+[\._\-]?){1,3}([A-z0-9])*";
  	$r = "/(?i)^{$r}\@{$r}\.[A-z]{2,6}$/";
  	return preg_match($r, $m);
}

//------------------------------------------------------------------------------
// CHECK GENERIC
//------------------------------------------------------------------------------
Function yiw_checkGeneric($str) {
//	if (!preg_match("/^[a-z0-9 '-\^]+$/i", $str)) {
//		Return False;
//	}
	If (strlen($str) <= 2) {
		return False;
	} else {
		Return True;
	}
}

//------------------------------------------------------------------------------------------------
// CHECK TEL
//-----------------------------------------------------------------------------------
Function yiw_checktel($str) {
    if ($str == "") {
		$str = 0;
	}
	if (!is_numeric($str)) {
		Return False;
	}
	If (strlen($str) >= 18) {
		return False;
	} else {
		Return True;
	}
}           

//------------------------------------------------------------------------------
// CHECK GENERIC
//------------------------------------------------------------------------------
function yiw_get_convertTags($str, $class = '', $after = '') 
{
    global $yiw_tags_allowed;
    
	if( $class != '' )
		$class = ' class="' . $class . '"';
		
    $str = str_replace('[', '<span' . $class . '>', $str);
    $str = str_replace(']', '</span>', $str);
    
    foreach( $yiw_tags_allowed as $tag => $value )
        $str = str_replace( "%$tag%", $value, $str );
    
    return $str . $after;
}                      

function yiw_convertTags($str, $class = '', $after = '') 
{
    echo yiw_get_convertTags($str, $class, $after);
}                                 
add_filter( 'widget_title', 'yiw_get_convertTags' ); 
add_filter( 'bloginfo', 'yiw_get_convertTags' );     

function yiw_favicon()
{                              
    global $yiw_theme_options;
	$favicon = $yiw_theme_options['favicon'];    
		
	if ( is_array( $favicon ) )	
		echo $favicon['url'];
	else
		echo $favicon;
}

function yiw_logo()
{
    global $yiw_theme_options;
	$logo = $yiw_theme_options['logo'];
	
	if ( is_array( $logo ) )
		$url = $logo['url'];
	else
		$url = $logo;
	
	if ( $url == '' )
		$url = get_template_directory_uri() . '';
	
	echo $url;
}

// adjust logo
function yiw_add_dynamic_logo_size()
{
    global $yiw_theme_options;
    
    $_show_logo = $yiw_theme_options['show_logo'];
    $custom_width = $yiw_theme_options['logo_width'];
    $custom_height = $yiw_theme_options['logo_height'];
    
    $margin = 20;
    
    if( $_show_logo AND $custom_width != '' AND $custom_height != '' )
    {
        ?>
        <style type="text/css">
            #logo { width:<?php echo $custom_width ?>px; height:<?php echo $custom_height ?>px; }
            #nav { margin-left:<?php echo $custom_width + $margin ?>px }
        </style>
        <?php
    }
}      
add_action( 'wp_head', 'yiw_add_dynamic_logo_size' ); 

function yiw_get_layout_page()
{
    $layout = get_post_meta( get_the_ID(), '_layout_page', true );
    return ( !$layout ) ? 'sidebar-right' : $layout;
}  

function yiw_get_removeTags($str, $after = '') 
{
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    
    return $str . $after;
}                               
add_filter( 'wp_title', 'yiw_get_removeTags' ); 

function yiw_slideshowImages($path, $n = FALSE)
{
    $dir = $path;
    $dir = str_replace("http://$_SERVER[SERVER_NAME]", "$_SERVER[DOCUMENT_ROOT]", $path);
	
    $files = array();        
    $html = ''; $i = 1;
    if ($handle = opendir($dir)) 
    {                                
       while (false !== ($file = readdir($handle))) 
       { 
            list($name, $ext) = explode('.', $file);
            if ( $file == ".." || $file == "." || is_dir($file)) {
                continue;
            }

           if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') 
           {
                $html .= "<img src=\"{$path}{$file}\" alt=\"$name\" />";
                $i++;
           }
           
           if($n AND $i > $n) break;
       }
    
       closedir($handle); 
    }        
    
//     $html = '';
//     for($i = 0; $i < get_option('nums_images_slideshow_home_f'); $i++)
//     {
//         $html .= "<img src=\"{$path}{$file[$i]}\" alt=\"001\" />";
//     } 
    
    echo $html;
}              

function yiw_url_icon($icon, $size = 32)
{
    global $yiw_icons_name;
    
    $path = "/images/icons/{$icon}{$size}.png";
    
    if( file_exists( STYLESHEETPATH . $path ) )
    	return get_template_directory_uri() . "/images/icons/{$icon}{$size}.png";
    else
    	return get_template_directory_uri() . "/images/icons/{$icon}.png";
}           

function yiw_list_icons( $selected = false, $echo = TRUE )
{
    global $yiw_icons_name;
    
    $html = '';
    foreach($yiw_icons_name as $icon)
        $html .= '<option value="'.$icon.'"'.selected( ( $selected != FALSE AND $selected == $icon ), true ).'>'.$icon.'</option>'."\n";
    
    if($echo) echo $html;
    return $html;
}

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function yiw_widget_first_last_classes($params) {

	global $yiw_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$yiw_widget_num) {// If the counter array doesn't exist, create it
		$yiw_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($yiw_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$yiw_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$yiw_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $yiw_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($yiw_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($yiw_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}
add_filter('dynamic_sidebar_params','yiw_widget_first_last_classes');      

function yiw_links_sliders( &$a, &$url, $slide )
{
	switch( $slide['link_type'] )
    {
		case 'page':
			$a = TRUE;
			$url = get_permalink( $slide['link_page'] );
		break;
		
		case 'category': 
			$a = TRUE;
			$theCatId = get_category_by_slug( $slide['link_category'] );                              
			$url = get_category_link( $theCatId->term_id );
		break;
		
		case 'url':      
			$a = TRUE;                          
			$url = $slide['link_url'];
		break;
		
		case 'none':     
			$a = FALSE;
			$url = '';
		break;
	}  
}              

function yiw_featured_content( $slide, $before = '', $after = '', $container = true )
{
	global $link;                                     
	
	switch( $slide['content_type'] ) { 
				
		case 'image' : ?>                    
        <?php if( $link ) : ?><a href="<?php echo $link_url ?>"><?php endif ?>
		<?php if( $container ) : ?><div class="featured-image"><?php endif; echo $before ?><img src="<?php echo $slide['image_url'] ?>" alt="<?php echo $slide['slide_title'] ?>" /><?php echo $after ?><?php if( $container ) : ?></div><?php endif; ?>  
		<?php if( $link ) : ?></a><?php endif ?>
		<?php break;
		
		case 'video' : ?>
		<div class="video-container"><?php echo stripslashes_deep( $slide['code_video'] ) ?></div>
		<?php break;               
        
	}
}         

function clear( $class = '' )
{
	?><div class="clear<?php echo ' ' . $class ?>"></div><?php
}

// sliders
function yiw_split_title( $title, $pattern = '/(.*)\[(.*)\]/' )
{
	$return = array();
	
	if( preg_match($pattern, $title, $t, PREG_OFFSET_CAPTURE) )
	{
    	$return['title'] = $t[1][0];
    	$return['subtitle'] = $t[2][0];
    }
    else
    {
		$return['title'] = $title;
        $return['subtitle'] = '';	
	}
    
    return $return;
}

function yiw_string_( $before = '', $string = '', $after = '', $echo = true )
{
    $html = '';
    
	if( $string != '' AND !is_null( $string ) )
		$html = $before . $string . $after;
	
	if( $echo )
		echo $html;
	
	return $html;
}

function yiw_slides( $option )
{
    global $yiw_theme_options;
	return yiw_subval_sort( unserialize( $yiw_theme_options[ $option ] ), 'order' );
}          

function yiw_pagination( $pages = '', $range = 10 )
{  
     global $paged;
     if( empty( $paged ) ) $paged = 1;

     if( $pages == '' ) {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         
		 if( !$pages )
             $pages = 1;
     }   

     if( 1 != $pages ) {
         echo "<div class='general-pagination'>";
         if( $paged > 2 ) echo "<a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a>";
         if( $paged > 1 ) echo "<a href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a>";

         for ( $i=1; $i <= $pages; $i++ )
         {
             if( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
             {
                 $class = ( $paged == $i ) ? " class='selected'" : '';
                 echo "<a href='", get_pagenum_link( $i ), "'$class >$i</a>";
             }
         }

         if ( $paged < $pages ) echo "<a href='", get_pagenum_link( $paged + 1 ), "'>&rsaquo;</a>";  
         if ( $paged < $pages - 1 ) echo "<a href='", get_pagenum_link($pages), "'>&raquo;</a>";
         
         clear();
         
         echo "</div>\n";
     }
}         
?>
