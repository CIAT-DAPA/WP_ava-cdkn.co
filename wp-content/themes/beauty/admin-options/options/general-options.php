<?php           

$premium_link = 'http://freeminimalwordpresstheme.com/?ap_id=yiweb&c_id=panel';     

$yiw_options['general'] = array (          
   
    "title" => array(    
        array( 	"name" => __('General Settings', 'yiw'),
        	   	"type" => "title")
    ),          
	 
    /* =================== GENERAL =================== */
    "general" => array(    
    
        array( "name" => __("General", 'yiw'),
        	   "type" => "section",
               "desc" => __("Manage the main settings for your theme.")),
        array( "type" => "open"),
        	
        array( "name" => __("Active Logo Image", 'yiw'),
        	   "desc" => __("Set if you want to replace the 'Title' and 'description' options of header, with a logo image.", 'yiw'),
        	   "id" => "show_logo", 
        	   "type" => "on-off",
        	   "std" => 0),
        	
        array( "name" => __("Logo URL", 'yiw'),
        	   "desc" => __("Enter the URL to your logo image", 'yiw') . ' ' . __( 'Get <a href="%s">premium version</a> for update button.', 'yiw' ),
        	   "id" => "logo",   
        	   "type" => "text",
        	   "sanitize_call" => 'esc_url',
        	   "std" => '' ),
        	
        array( "name" => __("Logo Width", 'yiw'),
        	   "desc" => __("Enter the width of logo, expressed in pixel. (Leave 0 for default)", 'yiw'),
        	   "id" => "logo_width",    
        	   "sanitize_call" => 'intval',
        	   "type" => "text",
        	   "std" => 0),
        	
        array( "name" => __("Logo Height", 'yiw'),
        	   "desc" => __("Enter the height of logo, expressed in pixel. (Leave 0 for default)", 'yiw'),
        	   "id" => "logo_height",    
        	   "sanitize_call" => 'intval',
        	   "type" => "text",
        	   "std" => 0),
        	
        array( "name" => __("Custom Favicon", 'yiw'),
        	   "desc" => __("A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image", 'yiw') . ' ' . sprintf( __( 'Get <a href="%s">premium version</a> for update button.', 'yiw' ), $premium_link ),
        	   "id" => "favicon",
        	   "type" => "text",
        	   "sanitize_call" => 'esc_url',
        	   "std" => home_url() . "/favicon.ico" ),	  
        	
        array( "name" => __("Custom Style", 'yiw'),
        	   "desc" => __("You can write here your custom css, that will replace the default css.", 'yiw'),
        	   "id" => "custom_style",
        	   "type" => "textarea",
        	   "std" => ''),	         
        	
        array( "type" => "close")
    ),        
    /* =================== END GENERAL =================== */
    
                                                 
    /* =================== BLOG =================== */
    "blog" => array(
        array( "name" => __("Blog Settings", 'yiw'),
        	   "type" => "section",
               "desc" => __("Manage the settings for blog template.")),
        array( "type" => "open"),       
        	
        array( "name" => __("Exclude categories", 'yiw'),
        	   "desc" => __("Select which categories you want exclude from blog.", 'yiw'),
        	   "id" => "blog_cats_exclude",
        	   "type" => "cat",
        	   "cols" => 2,          // number of columns for multickecks
        	   "heads" => array(__("Blog Page", 'yiw'), __("List cat. sidebar", 'yiw')),  // in case of multi columns, specific the head for each column
        	   "std" => ''),          
        	
        array( "name" => __("Featured Images Alignment", 'yiw'),
        	   "desc" => __("Specific the featured images alignment", 'yiw'),
        	   "id" => "blog_image_align",
        	   "type" => "select",
        	   "options" => array(
                    'alignleft' => 'Left', 
                    'alignright' => 'Right', 
                    'aligncenter' => 'Center'
                ),
        	   "std" => 'aligncenter'),
        	
        array( "name" => __("Featured Images Size", 'yiw'),
        	   "desc" => __("Specific the featured images size", 'yiw'),
        	   "id" => "blog_image_size",
        	   "type" => "select",
        	   "options" => array(
                    'post-thumbnail' => 'Standard', 
                    'thumbnail' => 'Thumbnail', 
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'custom' => 'Custom'
                ),
        	   "std" => 'post-thumbnail'),
        	
        array( "name" => __("Featured Images Width", 'yiw'),
        	   "desc" => __("Specific the featured images width, <strong>if you have selected custom size on option above.</strong>", 'yiw'),
        	   "id" => "blog_image_width",   
        	   "sanitize_call" => 'intval',
        	   "type" => "text",
        	   "std" => 0),
        	
        array( "name" => __("Featured Images Height", 'yiw'),
        	   "desc" => __("Specific the featured images height, <strong>if you have selected custom size on option above.</strong>", 'yiw'),
        	   "id" => "blog_image_height",     
        	   "sanitize_call" => 'intval',
        	   "type" => "text",
        	   "std" => 0),
        
        array( "type" => "close")   
    ),
    /* =================== END BLOG =================== */    
    
                                                      
    /* =================== FOOTER =================== */
    "footer" => array(
        array( "name" => __("Footer", 'yiw'),
        	   "type" => "section",
               "desc" => __("Manage the settings for footer.")),
        array( "type" => "open"),   
         
        array( "name" => __("Footer Type", 'yiw'),
        	   "desc" => __("Select the footer type for the theme", 'yiw'),
        	   "id" => "footer_type",
        	   "type" => "select",
        	   "options" => array(
					"normal" => __( "Two Columns Footer", 'yiw' ), 
					"centered" => __( "Centered Footer", 'yiw' )
				),
        	   "std" => "normal"),  
        	
        array( "name" => __("Footer centered text", 'yiw'),
        	   "desc" => __("Enter text used in <strong>centered footer</strong>. It can be HTML.", 'yiw'),
        	   "id" => "footer_text_centered",
        	   "type" => "textarea",
        	   "sanitize_call" => 'wp_kses_data',
        	   "std" => "" ),
        	
        array( "name" => __("Footer copyright text Left", 'yiw'),
        	   "desc" => __("Enter text used in the left side of the footer. It can be HTML. <strong>NB: not figured on 'centered footer'</strong>", 'yiw'),
        	   "id" => "copyright_text_left",
        	   "type" => "textarea",           
        	   "sanitize_call" => 'wp_kses_data',
        	   "std" => 'Copyright <a href="%site_url%"><strong>%name_site%</strong></a> 2013' ),
        	
        array( "name" => __("Footer copyright text Right", 'yiw'),
        	   "desc" => __("Enter text used in the right side of the footer. It can be HTML. <strong>NB: not figured on 'centered footer'</strong>", 'yiw'),
        	   "id" => "copyright_text_right",
        	   "type" => "textarea",          
        	   "sanitize_call" => 'wp_kses_data',),
         
        array( "type" => "close")   
    ),           
    /* =================== END FOOTER =================== */  
 
);   
?>
