<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 * 
 * Here the first hentry of theme, when all theme will be loaded.
 * On new update of theme, you can not replace this file.
 * You will write here all your custom functions, they remain after upgrade.
 */                                                                               
require_once dirname(__FILE__) . '/includes/functions.php';
/*-----------------------------------------------------------------------------------*/
/* End Theme Load Functions - You can add custom functions below */
/*-----------------------------------------------------------------------------------*/         
// Widget Locations
function wpb_init_widgets($id){
  register_sidebar(array(
    'name'  => 'Sidebar',
    'id'    => 'sidebar',
    'before_widget' => '<div class="sidebar-module">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4>',
    'after_title'   => '</h4>'
  ));
}
add_action('widgets_init', 'wpb_init_widgets');
?>
