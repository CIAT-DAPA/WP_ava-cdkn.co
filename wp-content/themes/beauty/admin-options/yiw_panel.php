<?php                             
function yiw_panel_url()
{
	return get_template_directory_uri() . '/admin-options';
}     

$yiw_themename = __( "Theme Options", 'yiw' );

function yiw_message()
{
	global $yiw_themename;
	
	$yiw_messages = array(
		'settings-updated' => '<div id="yiw_message" class="updated fade"><p><strong>'.$yiw_themename.' '.__('settings saved', 'yiw').'.</strong></p></div>',
		'reset' => '<div id="yiw_message" class="updated fade"><p><strong>'.$yiw_themename.' '.__('settings reset', 'yiw').'.</strong></p></div>',
	); 
	
	if ( isset( $_REQUEST['yiw-action'] ) && $_REQUEST['yiw-action'] == 'reset' ) {
        echo $yiw_messages['reset'];
        return;
    }
	
	foreach( $yiw_messages as $id => $yiw_message )
    	if( isset( $_GET[ $id ] ) && $_GET[ $id ] )
    		echo $yiw_message;
}                       

/**
 * ARRAYS
 */ 
require_once 'arrays.php';
// -------------                          

$yiw_options = $yiw_theme_options = array();    

foreach( $yiw_submenu_items as $item => $v )
{
    $file = dirname(__FILE__) . '/' . "options/$item-options.php";
    
	if( !file_exists( $file ) )
	   unset( $yiw_submenu_items[$item] );
	
	unset( $file );
}       

include_once 'panel_functions.php';    

// includes options array of current tab    
if ( _is_yiw_panel() )          
    require_once dirname(__FILE__) . '/' . 'options/' . yiw_get_current_tab() . '-options.php';      

// generate array with all default values
function yiw_get_default_options() {
    global $yiw_options, $yiw_submenu_items;
    
    foreach( $yiw_submenu_items as $item => $v )
    {
        $file = dirname(__FILE__) . '/' . "options/$item-options.php";
        
    	if( isset( $_GET['tab'] ) AND $_GET['tab'] == $item )
    	   require_once $file;
    	else
    	   require_once dirname(__FILE__) . '/' . "options/general-options.php";
    	
    	unset( $file );
    }       
    
    $default_options = array();
    foreach ( $yiw_options as $tab => $sections )
        foreach ( $sections as $section )
            foreach ( $section as $id => $value )
                if ( isset( $value['std'] ) && isset( $value['id'] ) )
                    $default_options[ $value['id'] ] = $value['std'];   
    
    return $default_options;
}             

// retrive all db options
$yiw_theme_options = get_option( 'yiw_theme_options' );
if ( false === $yiw_theme_options || ( isset( $_REQUEST['yiw-action'] ) && $_REQUEST['yiw-action'] == 'reset' ) ) {
  $yiw_theme_options = yiw_get_default_options();
  update_option( 'yiw_theme_options', $yiw_theme_options );
}


function yiw_add_admin() 
{     
    global $yiw_themename;
    
    add_theme_page( $yiw_themename, $yiw_themename, 'edit_theme_options', 'yiw_panel', 'yiw_admin' );
}                             
add_action('admin_menu', 'yiw_add_admin');     

// add items to admin bar
if( version_compare($wp_version, "3.1", ">=") )
{
	function yiw_add_items_admin_bar()
	{
		global $yiw_submenu_items, $wp_admin_bar, $yiw_themename;      
			
		$wp_admin_bar->add_menu( array(   
			'parent' => false,
			'title' => $yiw_themename,    
	        'id' => "theme-options-home",
	        'href' => admin_url('themes.php')."?page=yiw_panel" 
	    ) );
		
		foreach( $yiw_submenu_items as $item => $title )
		{			
			$wp_admin_bar->add_menu( array(   
				'parent' => "theme-options-home",
				'title' => $title,    
		        'id' => "theme-options-$item",
		        'href' => admin_url('themes.php')."?page=yiw_panel&tab=$item" 
		    ) );
		}
	}
	add_action( 'wp_before_admin_bar_render', 'yiw_add_items_admin_bar' );
}

function yiw_register_settings() {
    register_setting( 'yiw_theme_options', 'yiw_theme_options', 'yiw_options_validate' );
}
add_action( 'admin_init', 'yiw_register_settings' );        

// validation
function yiw_options_validate( $input ) {              
	
	$current_tab = $input['current_tab'];       
	
	$yiw_options = array();
	
	require_once dirname(__FILE__) . '/' . 'options/' . $current_tab . '-options.php'; 
        
    // default
    $default_options = array();
    foreach ( $yiw_options as $tab => $sections )
        foreach ( $sections as $section )
            foreach ( $section as $id => $value )
                if ( isset( $value['std'] ) && isset( $value['id'] ) )
                    $default_options[ $value['id'] ] = $value['std'];  
    
	$valid_input = get_option( 'yiw_theme_options', $default_options );
	
	$submit = ( ! empty( $input['submit-general']) ? true : false );
    $reset  = ( ! empty( $input['reset-general'])  ? true : false );
    
    foreach ( $yiw_options[ $current_tab ] as $section => $data )         
        foreach ( $data as $option ) {      
            if ( isset( $option['sanitize_call'] ) && isset( $option['id'] ) ) {
                if ( is_array( $option['sanitize_call'] ) ) :
                    foreach ( $option['sanitize_call'] as $callback )
                        if ( is_array( $input[ $option['id'] ] ) )
                            $valid_input[ $option['id'] ] = array_map( $callback, $input[ $option['id'] ] );
                        else
                            $valid_input[ $option['id'] ] = call_user_func( $callback, $input[ $option['id'] ] );  
                else :
                    if ( is_array( $input[ $option['id'] ] ) )
                        $valid_input[ $option['id'] ] = array_map( $option['sanitize_call'], $input[ $option['id'] ] );
                    else
                        $valid_input[ $option['id'] ] = call_user_func( $option['sanitize_call'], $input[ $option['id'] ] );  
                endif; 
            }
            else 
                $valid_input[ $option['id'] ] = $input[ $option['id'] ];   
        }      
    
    return $valid_input;
}

function yiw_add_init() 
{
    $file_dir = get_template_directory_uri()."/admin-options/include";         
     
	wp_enqueue_style( "function-panel", $file_dir."/functions.css" );
	wp_enqueue_style( "theme-install" );
                                     
    add_thickbox();                   
		
	wp_enqueue_script( "rm_script", $file_dir."/rm_script.js", array( 'jquery' ), '1.0', true );
}                   
if ( basename( $_SERVER['PHP_SELF'] ) == 'themes.php' AND isset( $_GET['page'] ) AND $_GET['page'] == 'yiw_panel' )                
	add_action('admin_init', 'yiw_add_init');  

function yiw_add_fields() {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    if ( !$current_tab )
        return;
    
    foreach ( $yiw_options[ $current_tab ] as $section => $data ) {
        // section
        add_settings_section( "yiw_settings_{$current_tab}_{$section}", yiw_get_section_title( $section ), create_function( '', 'echo \'<p>\', yiw_get_section_description( \'' . $section . '\' ), \'</p>\';' ), 'yiw' );
    
        // fields
        foreach ( $data as $option )
            if ( isset( $option['id'] ) && isset( $option['type'] ) && isset( $option['name'] ) )
                add_settings_field( "yiw_setting_".$option['id'], $option['name'], create_function( '', 'yiw_render_field( \'' . addslashes( serialize( $option ) ) . '\' );' ), 'yiw', "yiw_settings_{$current_tab}_{$section}", array( 'label_for' => yiw_get_id_field( $option['id'] ) ) );
    }
}              
add_action('admin_init', 'yiw_add_fields');  

function yiw_get_current_tab() {          
    if ( !isset( $_GET['page'] ) || $_GET['page'] != 'yiw_panel' )
        return false;

    if ( isset( $_POST['yiw_tab_options'] ) )
    	return $_GET['yiw_tab_options'];
    elseif ( isset( $_GET['tab'] ) )
    	return $_GET['tab'];
    else
        return 'general'; 
}          

function yiw_get_tab_title() {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    foreach ( $yiw_options[ $current_tab ] as $sections => $data )
        foreach ( $data as $option )
            if ( isset( $option['type'] ) && $option['type'] == 'title' )
                return $option['name'];
}          

function yiw_get_section_title( $section ) {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    foreach ( $yiw_options[ $current_tab ][ $section ] as $option )
        if ( isset( $option['type'] ) && $option['type'] == 'section' )
            return $option['name'];
}          

function yiw_get_section_description( $section ) {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    foreach ( $yiw_options[ $current_tab ][ $section ] as $option )
        if ( isset( $option['type'] ) && isset( $option['desc'] ) && $option['type'] == 'section' )
            return $option['desc'];
}                 

function yiw_get_include() {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    foreach ( $yiw_options[ $current_tab ] as $sections => $data )
        foreach ( $data as $option )
            if ( isset( $option['type'] ) && $option['type'] == 'title' && isset( $option['include'] ) )
                include $option['include'];
}  

function yiw_if_show_form() {
    global $yiw_options;
    
    $current_tab = yiw_get_current_tab();
    
    foreach ( $yiw_options[ $current_tab ] as $section ) {
        foreach ( $section as $option ) {
            if ( !isset( $option['type'] ) || $option['type'] != 'title' )
                continue;
            
            if ( isset( $option['showform'] ) )
                return $option['showform'];
            else
                return true;
        }
    }
}             

function yiw_get_name_field( $id ) {
    return "yiw_theme_options[$id]";    
}          

function yiw_name_field( $id ) {
    echo yiw_get_name_field( $id );    
}     

function yiw_get_id_field( $id ) {
    return "yiw_theme_options_$id";    
}          

function yiw_id_field( $id ) {
    echo yiw_get_id_field( $id );    
}

function yiw_render_field( $option ) {
    global $yiw_theme_options;
    
    $option = unserialize( stripslashes( $option ) );
    
    // retrieve the value from db or default value
    $db_value = $yiw_theme_options[ $option['id'] ];
    
    switch( $option['type'] ) {
        
        case 'text' :  ?>
            <input type="text" name="<?php yiw_name_field( $option['id'] ) ?>" id="<?php yiw_id_field( $option['id'] ) ?>" value="<?php echo $db_value ?>" /> 
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;
        
        case 'select' : ?>
            <select name="<?php yiw_name_field( $option['id'] ) ?>" id="<?php yiw_id_field( $option['id'] ) ?>">
                <?php foreach( $option['options'] as $key => $value ) : ?><option value="<?php echo $key ?>"<?php selected( $key, $db_value ) ?>><?php echo $value ?></option><?php endforeach; ?>
            </select> 
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;
        
        case 'textarea' : ?>
            <textarea name="<?php yiw_name_field( $option['id'] ) ?>" id="<?php yiw_id_field( $option['id'] ) ?>" rows="8" cols="50" class="widefat"><?php echo $db_value ?></textarea> 
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;
        
        case 'on-off' : ?>
            <select name="<?php yiw_name_field( $option['id'] ) ?>" id="<?php yiw_id_field( $option['id'] ) ?>">
                <?php foreach( array( 1 => 'yes', 0 => 'no' ) as $key => $value ) : ?><option value="<?php echo $key ?>"<?php selected( $key, $db_value ) ?>><?php echo $value ?></option><?php endforeach; ?>
            </select> 
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;
        
        case 'slider_control' : ?>
            <select name="<?php yiw_name_field( $option['id'] ) ?>" id="<?php yiw_id_field( $option['id'] ) ?>">
                <?php for( $i = $option['min']; $i <= $option['max']; $i++ ) : ?><option value="<?php echo $i ?>"<?php selected( $i, $db_value ) ?>><?php echo $i ?></option><?php endfor; ?>
            </select> 
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;
        
        case 'upload' : ?>
            <input type="text" name="<?php yiw_name_field( $option['id'] ) ?>[url]" id="<?php yiw_id_field( $option['id'] ) ?>" value="<?php echo $db_value['url'] ?>" />                        
            <a href="media-upload.php?type=image&TB_iframe=true" class="upload-image thickbox button-secondary" id="<?php yiw_id_field( $option['id'] ) ?>-button"><?php _e('Upload Image', 'yiw') ?></a>
			<input type="hidden" name="<?php yiw_name_field( $option['id'] ) ?>[id]" id="<?php yiw_id_field( $option['id'] ) ?>-id" value="<?php echo $db_value['id'] ?>" class="idattachment" />
            <span class="description"><?php echo $option['desc'] ?></span>
        <?php
        break;      
                 
        case "cat":
			
            $cats = get_categories('orderby=name&use_desc_for_title=1&hierarchical=1&style=0&hide_empty=0');
					             
            $class = $descr = $ext = '';
            $cols = 1;      
			if ( isset( $option['cols'] ) && $option['cols'] )	
            {
                $heads = FALSE;
                if( isset( $option['heads'] ) )
                {
                    $heads = TRUE;    
                }
                $cols = $option['cols'];
                $class = ' small';
                if($cols > 1) $descr = "<small>$option[desc]</small>";
            }	?>
            
            <div class="multi_checkbox">
                <span class="description"><?php echo $option['desc'] ?> <a href="#" class="expand-list hide-if-no-js" rel="<?php yiw_id_field( $option['id'] ) ?>" title="<?php _e( 'Click here to exand the categories', 'yiw' ) ?>"><?php _e( 'Click here to expand the list', 'yiw' ) ?></a></span>
                <div style="clear:both"></div><br/>
                <div id="<?php yiw_id_field( $option['id'] ) ?>" class="container_lists hide-if-js">
                <?php for($i=1;$i<=$cols;$i++) : $ext = ($cols > 1) ? $i : false ?>                           
                    <ul class="list-sortable<?php echo $class ?>">  
    				
                    <?php	
                    
                    //echo '<pre>', print_r($yiw_theme_options[ $option['id'] ] ), '</pre>';die;	                                
            
                    if ( !$ext && isset( $yiw_theme_options[ $option['id'] ] ) )
    		          $selected_cats = $yiw_theme_options[ $option['id'] ];
    		        elseif ( isset( $yiw_theme_options[ $option['id'] ][ $ext ] ) )
    		          $selected_cats = $yiw_theme_options[ $option['id'] ][ $ext ];  
    		        else
    		          $selected_cats = array();
                    
                    if($heads) echo '<li class="head">'.$option['heads'][$i-1].'</li>';
                    
                    $c = 0;
    				foreach($cats as $cat) { 
    				    $checked = '';
                
                        foreach ($selected_cats as $selected_cat) 
                        {
    	                    if($selected_cat == $cat->cat_ID){ $checked = "checked=\"checked\""; break; }else{ $checked = "";}				
        	            }?>
                    
                    	<li>
                            <input type="checkbox" name="<?php yiw_name_field( $option['id'] ) ?>[<?php echo $ext ?>][]" value="<?php echo $cat->cat_ID; ?>" <?php echo $checked ?> id="<?php yiw_id_field( $option['id'] ) ?>-<?php echo $c . $ext ?>" />&nbsp;
                            <label for="<?php yiw_id_field( $option['id'] ) ?>-<?php echo $c . $ext ?>" class="label-check"><?php echo $cat->cat_name; ?></label>
                        </li>
                    <?php $c++;	}  ?>
                    </ul>
                <?php endfor ?>
                </div>
            </div>
        	<?php if($cols <= 1) : ?><small class="description"><?php echo $option['desc']; ?></small><?php endif ?><div class="clearfix"></div>
        </div>
         
        <?php break;
        
    }
}                    

function yiw_admin() 
{
    global $yiw_themename, $yiw_shortname, $yiw_options, $yiw_submenu_items, $yiw_theme_options;
    
    $i = $show_form = 0;
    $tabs = '';
    
    $current_tab = yiw_get_current_tab();
    
    // tabs    
    foreach ( $yiw_submenu_items as $tab => $tab_value ) {
        $active_class = ( $current_tab == $tab ) ? ' nav-tab-active' : '';
        $tabs .= "<a class=\"nav-tab{$active_class}\" href=\"?page=yiw_panel&tab=$tab\">$tab_value</a>\n";    
    }
?>                 
    <div id="icon-themes" class="icon32"><br /></div>
    <h2 class="nav-tab-wrapper">    
        <?php echo $tabs ?>
    </h2>
                      
    <div id="wrap">
    
        <?php yiw_message(); ?>
    
        <h2><?php echo yiw_get_tab_title( $current_tab ) ?></h2>
        
        <?php yiw_get_include() ?>      
        
        <?php if( yiw_if_show_form() ) : ?>
        <form method="post" action="options.php"> 
        
            <?php do_settings_sections( 'yiw' ); ?>         
        
            <p>&nbsp;</p>
        
            <?php settings_fields( 'yiw_theme_options' ); ?>
            <input type="hidden" name="yiw_theme_options[current_tab]" value="<?php echo $current_tab ?>" />
            <input type="submit" name="yiw_theme_options[submit-<?php echo $current_tab ?>]" class="button-primary" value="<?php _e( 'Save Changes', 'yiw' ) ?>" style="float:left;margin-right:10px;" />
        </form>                   
        
        <form method="post">            
        	<?php $warning = __( 'If you continue with this action, you will reset all options are in this page.', 'yiw' ) ?>
            <input type="hidden" name="yiw-action" value="reset" />
            <input type="submit" name="yiw-reset" class="button-secondary" value="<?php _e( 'Reset Defaults', 'yiw' ) ?>" onclick="return confirm('<?php echo $warning . '\n' . __( 'Are you sure of it?', 'yiw' ) ?>');" />
        </form>
        
        <p>&nbsp;</p>
        <?php endif; ?>
    
    </div>
    

<?php
}

function _is_yiw_panel() {
    return ( isset( $_GET['page'] ) && $_GET['page'] == 'yiw_panel' );
}

function yiw_link_documentation() {	
	if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'yiw_panel' ) && get_option( 'yiw_show_advise_beauty_documentation', 'yes' ) == 'yes' ) :
	?>
    <div id="yiw_message" class="updated fade">
    	<p>
			<?php _e( sprintf( 'You can find the documentation at %s.', '<a href="http://yithemes.com/docs-free/beauty/index.html">' . __( 'this link', 'yiw' ) . '</a>' ), 'yiw' ) ?><br />
			<?php _e( sprintf( 'If you want download this documentation and see it without any internet connection, you can download it by %s', '<a href="http://yithemes.com/docs-free/documentation-beauty.zip">' . __( 'this link', 'yiw' ) . '</a>' ), 'yiw' ) ?><br />
			<span class="close"><img src="<?php echo get_template_directory_uri() . '/images/icons/error.png' ?>" title="<?php _e( 'Close', 'yiw' ) ?>" alt="[x]" /></span>
		</p>
	</div>
	<?php
	endif;
}
add_action('admin_notices', 'yiw_link_documentation');

function yiw_doc_notice_js() {
    ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
        var show_doc = '<?php echo get_option( 'yiw_show_advise_beauty_documentation', 'yes' ); ?>';
        if( show_doc == 'no' )
            { $( '#yiw_message' ).hide(); }
    
    	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    	$( 'span.close' ).click( function() {    
        	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        	var data = {
        		action: 'doc_notice',
        		yiw_show_advise_beauty: 0
        	};
        
        	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        	$.post(ajaxurl, data, function(response) {
        		if( response == 'no' ) {
        		  $( '#yiw_message' ).fadeOut();
        		}
        	});
        });
    });
    </script>
    <?php
}
add_action('admin_print_scripts', 'yiw_doc_notice_js', 20);

function doc_notice_callback() {
    global $wpdb; // this is how you get access to the database
    
	if ( isset( $_POST['yiw_show_advise_beauty'] ) && !$_POST['yiw_show_advise_beauty'] ) {
	    update_option( 'yiw_show_advise_beauty_documentation', 'no' );
	    $_show = 'no';
	} else {	
		$_show = get_option( 'yiw_show_advise_beauty_documentation', 'yes' );
	}
    
    echo $_show;

	die(); // this is required to return a proper result
}
add_action('wp_ajax_doc_notice', 'doc_notice_callback');
?>