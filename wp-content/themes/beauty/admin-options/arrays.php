<?php
// items of admin options panel
$yiw_submenu_items = array( 
	'general' => __( 'General', 'yiw' ), 
	'premium' => __( 'Premium', 'yiw' )
);    
 
// all slider types
$yiw_sliders_type = array( 'none' => 'None', 'content' => 'Slider Content', 'fullimages' => 'Slider Full Images' );   

// get all yiw_categories created on theme
$yiw_categories = get_categories('hide_empty=0&orderby=name');
$yiw_wp_cats = array();
foreach ($yiw_categories as $category_list ) 
{
    $yiw_wp_cats[$category_list->category_nicename] = $category_list->cat_name;
}
array_unshift($yiw_wp_cats, __("Choose a category"));  

// number of columns for big footer
$yiw_columns_footer = array( 'three' => 'Three Columns', 'four' => 'Four Columns', 'five' => 'Five Columns' );

// effects
$yiw_fxs = array(
    'blindX' => 'blindX', 		'blindY' => 'blindY', 		'blindZ' => 'blindZ', 		'cover' => 'cover', 		'curtainX' => 'curtainX',
    'curtainY' => 'curtainY', 	'fade' => 'fade', 			'fadeZoom' => 'fadeZoom', 	'growX' => 'growX', 		'growY' => 'growY',
    'scrollUp' => 'scrollUp', 	'scrollDown' => 'scrollDown','scrollLeft' => 'scrollLeft','scrollRight' => 'scrollRight', 	'scrollHorz' => 'scrollHorz',
    'shuffle' => 'shuffle', 	'slideX' => 'slideX', 		'slideY' => 'slideY', 		'toss' => 'toss', 			'turnUp' => 'turnUp',
    'turnLeft' => 'turnLeft', 	'turnRight' => 'turnRight', 'uncover' => 'uncover', 	'wipe' => 'wipe', 			'zoom' => 'zoom',
    'none' => 'none',			'turnDown' => 'turnDown',	'scrollVert' => 'scrollVert'
);

// nivo slider effect
$yiw_nivo_fxs = array(
	'sliceDown' => 'sliceDown',
    'sliceDownLeft' => 'sliceDownLeft',
    'sliceUp' => 'sliceUp',
    'sliceUpLeft' => 'sliceUpLeft',
    'sliceUpDown' => 'sliceUpDown',
    'sliceUpDownLeft' => 'sliceUpDownLeft',
    'fold' => 'fold',
    'fade' => 'fade',
    'random' => 'random',
    'slideInRight' => 'slideInRight',
    'slideInLeft' => 'slideInLeft'
);

// yiw_easings
$yiw_easings = array(
	FALSE => 'none',
	'easeInQuad' => 'easeInQuad',
	'easeOutQuad' => 'easeOutQuad',
	'easeInOutQuad' => 'easeInOutQuad',
	'easeInCubic' => 'easeInCubic',
	'easeOutCubic' => 'easeOutCubic',
	'easeInOutCubic' => 'easeInOutCubic',
	'easeInQuart' => 'easeInQuart',
	'easeOutQuart' => 'easeOutQuart',
	'easeInOutQuart' => 'easeInOutQuart',
	'easeInQuint' => 'easeInQuint',
	'easeOutQuint' => 'easeOutQuint',
	'easeInOutQuint' => 'easeInOutQuint',
	'easeInSine' => 'easeInSine',
	'easeOutSine' => 'easeOutSine',
	'easeInOutSine' => 'easeInOutSine',
	'easeInExpo' => 'easeInExpo',
	'easeOutExpo' => 'easeOutExpo',
	'easeInOutExpo' => 'easeInOutExpo',
	'easeInCirc' => 'easeInCirc',
	'easeOutCirc' => 'easeOutCirc',
	'easeInOutCirc' => 'easeInOutCirc',
	'easeInElastic' => 'easeInElastic',
	'easeOutElastic' => 'easeOutElastic',
	'easeInOutElastic' => 'easeInOutElastic',
	'easeInBack' => 'easeInBack',
	'easeOutBack' => 'easeOutBack',
	'easeInOutBack' => 'easeInOutBack',
	'easeInBounce' => 'easeInBounce',
	'easeOutBounce' => 'easeOutBounce',
	'easeInOutBounce' => 'easeInOutBounce'
);
?>
