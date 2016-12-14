<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 */     

/* allow shortcodes in sidebar widgets */
add_filter('widget_text', 'do_shortcode');


/** 
 * TEAM    
 * 
 * @description
 *    Show a list of post type team    
 * 
 * @example
 *   [team items=""]
 *   
 * @params
 * 		items - number of item to show   
 * 
**/
function yiw_team_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"items" => 10
	), $atts));
	
	$args = array(
		'post_type' => 'yiw_team'	
	);
	if( !is_null( $items ) ) $args['posts_per_page'] = $items;
	
	$team = new WP_Query( $args );     
	
	$html = '';
	if( !$team->have_posts() ) 
        return $html;
	
	//loop                      
	$html .= '<ul id="team">';
	
    while( $team->have_posts() ) : $team->the_post();
	
		$title = the_title( '', '', false );
		$content = get_the_content();
		
		$html .= '<li>';
		
    		if( has_post_thumbnail() ) 
                $html .= get_the_post_thumbnail( get_the_ID(), 'team-thumb' );
                
            $html .= '<blockquote>' . $content . '</blockquote>';
            
            $html .= '<div class="clear"></div>';
		
		$html .= '</li>';
	
	endwhile;            
		
	$html .= '</ul>';
	
	return $html;
}
add_shortcode("team", "yiw_team_func");    
?>