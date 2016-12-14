<?php
/* Define the widgets dashboard */

add_action( 'wp_dashboard_setup', 'yiw_dashboard_widget_setup' );

define( 'YIW_RSS_FORUM_URL', 'http://yithemes.com/feed/?post_type=product' );
define( 'YIW_RSS_URL', 'http://yithemes.com/feed/' );
                  
function yiw_dashboard_widget_setup() {
    wp_add_dashboard_widget( 'yiw_dashboard_news', __( 'Our latest themes' , 'yiw' ), 'yiw_dashboard_forum_news' );
    wp_add_dashboard_widget( 'yiw_news', __( 'News from the YIT Blog' , 'yiw' ), 'yiw_dashboard_news' ); 	
	// Globalize the metaboxes array, this holds all the widgets for wp-admin

	global $wp_meta_boxes;
	
	$widgets_on_side = array(
        'yiw_dashboard_news',
        'yiw_news'
    );
	
    foreach( $widgets_on_side as $meta ) {
        $temp = $wp_meta_boxes['dashboard']['normal']['core'][$meta];
        unset($wp_meta_boxes['dashboard']['normal']['core'][$meta]);
        $wp_meta_boxes['dashboard']['side']['core'][$meta] = $temp;
    }
}                                                                

function yiw_dashboard_forum_news() {
	//$rss = fetch_feed( YIW_RSS_URL );
	$args = array( 'show_author' => 1, 'show_date' => 1, 'show_summary' => 0, 'items'=>10 );
	wp_widget_rss_output( YIW_RSS_FORUM_URL, $args );
}                                               

function yiw_dashboard_news() {
	//$rss = fetch_feed( YIW_RSS_URL );
	$args = array( 'show_author' => 1, 'show_date' => 1, 'show_summary' => 1, 'items'=>3 );
	wp_widget_rss_output( YIW_RSS_URL, $args );
}