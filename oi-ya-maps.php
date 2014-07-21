<?
/*
Plugin Name: Oi Ya.Maps
Plugin URI: http://www.easywebsite.ru/shop/oi-ya-maps
Description: It just add the maps on your pages using Yandex.Maps. You can use shortcode and type the address or coordinates with many placemarks.
Author: Alexei Isaenko
Version: 2.0
Author URI: http://www.sh14.ru
This plugin is Copyright 2012 Sh14.ru. All rights reserved.
*/

// Date: 25.04.2014 - make code as a single plugin from other big project
// Date: 20.05.2014 - Stretchy Icons support added  
// Date: 21.07.2014 - 20.0 release

include "include/init.php";
add_action('init', 'oi_yamaps');
function oi_yamaps() // localization
{
	load_plugin_textdomain( 'oiyamaps', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
}
// do something on plugin activation
register_activation_hook( __FILE__, 'oi_yamaps_activation' );
function oi_yamaps_defaults() // create table
{
	$defaults = array(
		'height' => '400px',
		'width' => '100%',
		'zoom' => '16',
		'placemark' => 'twirl#blueDotIcon',
		'author_link' => '1',
	);
	return $defaults;
}

function oi_yamaps_activation() // set default variables on plugin activation
{
	if( !get_option( OIYM_PREFIX.'options' ) ) // if we don't have any settengs
	{
		update_option( OIYM_PREFIX.'options' , oi_yamaps_defaults() );
	}
}

class Ya_map_connected // check, if maps packege is loaded
{
    public static $id = 0; // default value - packege not loaded yet
    public static $pid = 0; // default value - packege not loaded yet

    public function staticValue() {
        return self::$id; // return actual value
    }
    public function staticValue1() {
        return self::$pid; // return actual value
    }
}

function coordinates($address) // get coordinates of a given address
{
	$address = urlencode($address);
	$url = "http://geocode-maps.yandex.ru/1.x/?geocode=".$address;
	$callback = @file_get_contents($url);
	if($callback == false)
	{
		print '<p class="error">'.__('To show the map cURL must be enabled.', 'oiyamaps').'</p>';
	}else
	{
		$content = $callback;
		preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
		return implode(',',array_reverse(split(' ',trim(strip_tags($point[1])))));
	}
}
function showyamap( $atts, $content ) // show block with the map on a page
{
	$options = get_option( OIYM_PREFIX.'options' );
	foreach($options as $k=>$v) // get variables from DB
	{
		if($$k==''){$$k = $v;}
	}
	extract( shortcode_atts( array(
			'address'		=> '',
			'header'		=> '',
			'body'			=> '',
			'footer'		=> '',
			'hint'			=> '',
			'coordinates'	=> '',
			'height'		=> $height,
			'width'			=> $width,
			'zoom'			=> $zoom,
			'iconcontent'	=> '',
			'placemark'		=> $placemark,
		), $atts, 'showyamap' ) );
	foreach(oi_yamaps_defaults() as $k=>$v) // set empty variables from defaults
	{
		if($$k==''&&$k<>'author_link'){$$k = $v;}
	}
	// if content for placemark given, make placemark stretch
	if($iconcontent<>''){$placemark = str_replace('Icon','StretchyIcon',str_replace('Dot','',$placemark));}
	$id = Ya_map_connected::$id; // set id of map block
	if($coordinates=='') // get coordinates, if it's not set
	{
		if($address<>'') // if we have an address, then...
		{
			$coordinates = coordinates($address); // take coordinates
		}else // if we don't...
		{
			$latitude = get_post_meta( get_the_ID(), 'latitude', true ); // get latitude from post meta
			$longitude = get_post_meta( get_the_ID(), 'longitude', true ); // get longitude from post meta
			if($latitude&&$longitude) // if we have coordinates...
			{
				$coordinates = $latitude . ',' . $longitude; // split theme
			}
		}
	}
	
	if($coordinates<>'')
	{
		$body = str_replace('"',"'",$body);
		if($author_link==1)
			$author_link = '<a class="ymaps-copyright-agreement-black author_link" href="http://easywebsite.ru/">' . __('Oi Ya.Maps', 'oi_ya_maps') . '</a>';
		//$content = '/* '.$content.' */';
		$output = '
		<div id="YMaps_'.$id.'" class="YMaps" style="width:'.$width.';height:'.$height.'">'. $author_link .'</div>
		<script type="text/javascript">
			ymaps.ready(init);

			function init () {
				var myMap = new ymaps.Map("YMaps_'.$id.'", {
						center: ['.$coordinates.'],
						zoom: '.$zoom.'
					});
					myMap.controls
						.add("zoomControl")
						.add("typeSelector")
						.add("mapTools");
						
					myPlacemark_'.$id.' = new ymaps.Placemark(['.$coordinates.'], {
						iconContent: "'.$iconcontent.'",
						balloonContentHeader: "'.$header.'",
						balloonContentBody: "'.$body.'",
						balloonContentFooter: "'.$footer.'",
						hintContent: "'.$hint.'"
					},
					{ preset: "'.$placemark.'" }
					);

					myMap.geoObjects.add(myPlacemark_'.$id.');
				'.do_shortcode(strip_tags($content)).'
			}
		</script>
		';
		Ya_map_connected::$id++; // set new id
		if($id==0) // if no maps on a page...
		{
			return '<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"></script>'.
				'<style>.YMaps {position: relative;} .YMaps .author_link {position: absolute;bottom: 9px; right:316px; z-index: 999;padding:0;display: table;line-height:12px;text-decoration:underline!important;}</style>'.
			"\n".$output; // ...and show the map
		}else{return $output;} // show the map
	}
}
add_shortcode('showyamap', 'showyamap');
function placemark($atts)
{
extract( shortcode_atts( array(
		'address'		=> '',
		'header'		=> '',
		'body'			=> '',
		'footer'		=> '',
		'hint'			=> '',
		'coordinates'	=> '',
		'iconcontent'	=> '',
		'placemark'		=> "twirl#blueDotIcon",
	), $atts ) );
	if($coordinates=='') // get coordinates, if it's not set
	{
		$coordinates = coordinates($address);
	}
	if($coordinates)
	{
		Ya_map_connected::$pid++;
		$pid = Ya_map_connected::$pid;
		$output = '
					myPlacemark_'.$pid.' = new ymaps.Placemark(['.$coordinates.'], {
						iconContent: "'.$iconcontent.'",
						balloonContentHeader: "'.$header.'",
						balloonContentBody: "'.$body.'",
						balloonContentFooter: "'.$footer.'",
						hintContent: "'.$hint.'"
					},
					{ preset: "'.$placemark.'" }
					);

					myMap.geoObjects.add(myPlacemark_'.$pid.');
		
		';
		return $output;
	}
}
add_shortcode('placemark', 'placemark');
?>