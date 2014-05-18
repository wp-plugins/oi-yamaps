=== Oi Ya.Maps ===
Contributors: Isaenko Alexei
Tags: coordinates, maps, geolocation, location, placemark, yandex
Requires at least: 3.2
Tested up to: 3.9
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

It just add the maps on your pages using Yandex.Maps. You can use shortcode and point the address or coordinates.

== Description ==

This plugin uses Yandex.Map API service to provide maps on your site.
You can point coordinates or address of some place, and you'll get the map on your page.
You can add so many maps on one page as you want.
Use shortcode with parameters: [showyamap address="" header="" body="" footer="" hint="" placemark="" coordinates="" height="" width="" zoom=""]

Default values:

placemark	= twirl#greenIcon
height		= 400px
width		= 100%
zoom		= 16


You able to use only one parameter - address or coordinates:
[showyamap address="Moscow, Birulevskaya st., 1"]

API loads not on every page, but only when it's needed! 

allow_url_fopen in php.ini should be on - allow_url_fopen = 1

== Installation ==

1. Upload `oi-ya-maps` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

 == Screenshots == 

1. Shortcode in admin panel.
2. Map on a front page.

== Changelog ==

= 1.0 =
* Initial release
= 1.1 =
* Maps ID numbers fixed
