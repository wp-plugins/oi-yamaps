<?
/*
Plugin Name: Oi Ya.Maps
Plugin URI: http://www.easywebsite.ru/plugins/oi-ya-maps/
Description: It just add the maps on your pages using Yandex.Maps. You can use shortcode and type the address or coordinates.
Author: Alexei Isaenko
Version: 1.0
Author URI: http://www.sh14.ru
This plugin is Copyright 2012 Sh14.ru. All rights reserved.
*/

// Date: 25.04.2014 - make code as a single plugin from other big project

add_filter('edit_form_advanced', 'oi-ya-map-editor');

function oi_ya_map_options()
{

}

class Ya_map_connected // check, if maps packege is loaded
{
    public static $id = 0; // default value - packege not loaded yet

    public function staticValue() {
        return self::$id; // return actual value
    }
}

function coordinates($address) // get coordinates of a given address
{
	$address=urlencode($address);
	$url="http://geocode-maps.yandex.ru/1.x/?geocode=".$address;
	$content=file_get_contents($url);
	preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
	$coordinates=str_replace(' ',',',trim(strip_tags($point[1])));
	return $coordinates;
}
function showyamap($atts) // show block with the map on a page
{
extract( shortcode_atts( array(
		'address'		=> '',
		'header'		=> '',
		'body'			=> '',
		'footer'		=> '',
		'hint'			=> '',
		'placemark'		=> 'twirl#greenIcon',
		'coordinates'	=> '',
		'height'		=> '400px',
		'width'			=> '100%',
		'zoom'		=> '16',
	), $atts ) );
	$id = Ya_map_connected::$id; // set id of map block
	if($coordinates=='') // get coordinates, if it's not set
	{
		$coordinates = coordinates($address);
	}
	if($coordinates)
	{
		$coordinates = split(',',$coordinates);
		$coordinates = $coordinates[1].', '.$coordinates[0];
		// http://api.yandex.ru/maps/doc/jsapi/2.x/ref/reference/option.presetStorage.xml - разные метки
	$output = '
	<script type="text/javascript">
		// as soon as API loaded and DOM is ready, make init
		ymaps.ready(init);

		function init () {
		// make map with id
			var myMap = new ymaps.Map("YMaps_'.$id.'", {
					// set center and zoom of a map
					center: ['.$coordinates.'],
					zoom: '.$zoom.'
				});
				myMap.controls
					// scale button
					.add("zoomControl")
					// map types
					.add("typeSelector")
					// standart buttons
					.add("mapTools");
					
				// set a placemark
				myPlacemark = new ymaps.Placemark(['.$coordinates.'], {
					balloonContentHeader: "'.$header.'",
					balloonContentBody: "'.$body.'",
					balloonContentFooter: "'.$footer.'",
					hintContent: "'.$hint.'"
				},
				{ preset: "'.$placemark.'" }
				);

				myMap.geoObjects.add(myPlacemark);	// add a placemark to the map
		}
	</script>
	<div id="YMaps_'.$id.'" class="YMaps" style="width:'.$width.';height:'.$height.'"></div>
	';

		if(Ya_map_connected::$id==0) // if no maps on a page...
		{
			Ya_map_connected::$id++; // set new id value and load API...
			return '<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"></script>'.$output; // ...and show the map
		}else{return $output;} // show the map
	}
}
add_shortcode('showyamap', 'showyamap');
?>