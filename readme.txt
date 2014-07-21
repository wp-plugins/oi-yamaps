=== Oi Ya.Maps ===
Contributors: Isaenko Alexei
Tags: coordinates, maps, geolocation, location, placemark, yandex
Requires at least: 3.2
Tested up to: 3.9.1
Stable tag: 2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

It just add the maps on your pages using Yandex.Maps. You can use shortcode and point the address or coordinates.

== Description ==

This plugin uses Yandex.Map API service to provide maps on your site.
You can point coordinates or address of some places, and you'll get the map on your page.
You can add so many maps on one page and so many placemarks on a page as you want.
Use shortcode with parameters: [showyamap address="" header="" body="" footer="" hint="" iconcontent="" placemark="" coordinates="" height="" width="" zoom=""]

Default values:

placemark	= twirl#blueDotIcon
height		= 400px
width		= 100%
zoom		= 16


You able to use only one parameter - address or coordinates:
[showyamap address="Moscow, Birulevskaya st., 1"]

Placemarks

You able to use many placemarks. Just write it inside content part of shortcode.

[showyamap address="Moscow, Birulevskaya, 1/2"]
	[placemark address="Moscow, Birulevskaya, 1"]
[/showyamap]
First placemark will be taken from showyamap shortcode, second from placemark shortcode.

API loads not on every page, but only when it's needed! 

If you use "address" instead of "coordinates" "allow_url_fopen" in php.ini should be enabled - allow_url_fopen = 1

== Installation ==

1. Upload `oi-ya-maps` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How can I add Stretchy Icons? =

Just add the "iconcontent" attribute [showyamap address="Moscow, Birulevskaya st., 1" iconcontent="Content"]

= How can I change Stretchy Icon color? =

Use simple twirl icons "twirl#nightIcon" or twirl icons with dot "twirl#nightDotIcon". If you use "iconcontent" then icon automaticaly turns to stretchy.

 == Screenshots == 

1. Shortcode in admin panel.
2. Map on a front page.

== Changelog ==

= 2.1 =
* fix: fix html in placemark
* new: center parametr added
* new: curl enable check
= 2.0 =
* fix: Some fixes.
* new: Option page added.
* new: Language support added.
* new: Multi Placemarks support added.
= 1.2 =
* fix: Placemark ID numbers fixed
* new: iconcontent attribute added - Stretchy Icons support
= 1.1 =
* fix: Maps ID numbers fixed
= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.2 =
None critical update. It just add Stretchy Icons support.