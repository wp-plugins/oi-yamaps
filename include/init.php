<?php
/**
 *
 */

define( 'OIYM_PATH', plugin_dir_path( __FILE__ ));
define( 'OIYM_PREFIX', 'oiym_');
require_once(OIYM_PATH . 'options.php');
require_once(OIYM_PATH . 'thickbox.php');

/* Display a notice that can be dismissed */
add_action('admin_notices', 'oiym_admin_notice');
function oiym_admin_notice()
{
	global $current_user ;
	$user_id = $current_user->ID;
	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'oiym_ignore_notice') && is_admin() )
	{
		print '<div class="updated"><p>';
		printf(__('Check out the <a href="%1$s">option page</a> of Oi Yandex.Maps for WordPress plugin. | <a href="%2$s">Hide Notice</a>','oiyamaps'), 'options-general.php?page=oiym-setting-admin', '?oiym_nag_ignore=0');
		print '</p></div>';
	}
}
add_action('admin_init', 'oiym_nag_ignore');
function oiym_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['oiym_nag_ignore']) && '0' == $_GET['oiym_nag_ignore'] ) {
             add_user_meta($user_id, 'oiym_ignore_notice', 'true', true);
	}
}

?>