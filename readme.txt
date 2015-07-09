=== Oi Yandex.Maps for WordPress ===
Contributors: Isaenko Alexei
Donate link: https://money.yandex.ru/topup/card/carddetails.xml?receiver=41001112308777&skr_sum=350
Tags: coordinates, maps, geolocation, location, placemark, yandex
Requires at least: 3.2
Tested up to: 4.1
Stable tag: 2.32
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 

The plugin allows you to use Yandex.Maps on your site pages and put the placemarks on the map. Without an API key.

== Description ==
<h4>!!! При обновлении до версии 2.31 произошла ошибка, следует произвести обновление до версии 2.32 !!!</h4>

Этот плагин использует API Яндекс.Карт для отображения карт на вашем сайте. 
Плагин работает без использования API ключа.
Вы можете указать координаты или адреса каких либо мест и поместить карту с меткой на любую страницу сайта.
Вы можете добавить на страницу так много карт и так много меток на каждую карту, сколько хотите.
Просто используйте шорткоды с параметрами. Так же можно использовать произвольные поля latitude и longitude, соответственно.
Теперь вы можете использовать визуальный редактор шорткода.
API загружается на страницу только если на ней выводится карта!

<h4>Oi Yandex.Maps for WordPress необходима Ваша поддержка</h4>
Если Вам нравится данный плагин, Вы можете поддержать меня материально, перечислив любую сумму. Но даже если Вы этого не сделаете, Вы можете пользоваться плагином без каких-либо ограничений.

Ваш вклад поможет дальнейшему развитию плагина и обеспечит лучшую поддержку пользователей.

This plugin uses <a target="_blank" href="http://maps.yandex.com/">Yandex.Map</a> API service to provide maps on your site.
You can point coordinates or address of some places, and put your map to any page of your site.
You can add so many maps on one page and so many placemarks on a map as you want.
Just use shortcode with parameters. You can use custom fields - 'latitude' and 'longitude'.
Now you can use visual shortcode editor.

API loads not on every page, but only when it's needed! 

<h4>Oi Yandex.Maps for WordPress Needs Your Support</h4>
If you like this plugin, you can support me and <a target="_blank" href="https://money.yandex.ru/topup/card/carddetails.xml?receiver=41001112308777&skr_sum=350">make a donation</a>. But even if you don't, you can use the plugin without any restrictions.
Your donation will help encourage and support the plugin's continued development and better user support.

== Installation ==

1. Upload `oi-ya-maps` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How can I add Stretchy Icons? =

Just add the "iconcontent" attribute [showyamap address="Moscow, Birulevskaya st., 1" iconcontent="Content"]

= How can I change Stretchy Icon color? =

Use simple twirl icons "twirl#nightIcon" or twirl icons with dot "twirl#nightDotIcon". If you use "iconcontent" then icon automaticaly turns to stretchy.

= Russian description =
http://www.easywebsite.ru/shop/plugins-wordpress/oi-ya-maps

 == Screenshots == 

1. Shortcode in admin panel.
2. Map on a front page.
3. Shortcode button.
4. Visual shortcode editor.

== Changelog ==

= 2.3 =
* fix showmap coordinates missing;
* fix: fixed error when showmap doesn't contain coordinates;
* new: now you can turn off map controls
* new: added custom placemark image
* new: map center depends on placemarks
= 2.2 =
* fix: fixed error when coordinates used
* fix: fixed error whith map center
* new: added shortcode button
* new: localization: russian language added
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