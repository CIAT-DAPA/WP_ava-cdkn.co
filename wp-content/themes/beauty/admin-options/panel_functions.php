<?php
function yiw_process( $var )
{
    global $yiw_theme_options;
    
    if( $yiw_theme_options[ $var['id'] ] != '' )
    {
        return $yiw_theme_options[ $var['id'] ];
    }
    else
    {
        return $var['std'];
    }
}

function yiw_cleanArray($arr)
{
	$new_array = $arr;
	
	foreach($new_array as $key => $values)
	{
		if( is_array($values) )
		{
			foreach($values as $k => $v)
			{
				if( $k == 'order' OR $k == 'content_type' ) continue;
				                 
				if( !empty($v) AND !is_null($v) AND $v != '' AND $v != '0' AND $v != 'none' )
				{
					$clean = FALSE;
					break;  
				}
				else
				{
					$clean = TRUE;   
				}
			}	
			
			if( $clean ) unset( $new_array[$key] ); 
		}
		else return $new_array;
	}
	
	return $new_array;
}    

function yiw_num_( $from, $to )
{
	$r = array();
	
	for( $i = $from; $i <= $to; $i++ )
		$r[$i] = $i;
	
	return $r;
}    

function yiw_check_if_exists( $value, $array )
{
	$match = array();
	
	if( !in_array( $value, $array ) )
		return $value;
	else {
		if( !preg_match( '/([a-z]+)([0-9]+)/', $value, $match ) )
			$i = 1;
		else {
			$i = intval( $match[2] ) + 1;
			$value = $match[1];
		}
		return yiw_check_if_exists( $value . $i, $array );
	}
}
?>
