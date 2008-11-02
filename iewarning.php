<?php
/*
Plugin Name: IE warning
Plugin URI: http://bobrik.name/
Description: Adds a splash warning to every blog page, if reader using Internet Explorer.
Version: 0.18
Author: Ivan Babrou <ibobrik@gmail.com>
Author URI: http://bobrik.name/

Copyright 2008 Ivan Babroŭ (email : ibobrik@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the license, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; see the file COPYING.  If not, write to
the Free Software Foundation, Inc., 59 Temple Place - Suite 330,
Boston, MA 02111-1307, USA.
*/

$textdomain = 'iewarning';
load_plugin_textdomain($textdomain, false, 'ie-warning');


function header_files() {
	if (need_work()) {
		?><script type='text/javascript'>
			//<![CDATA[
			function iewarning() {
				var d=document.createElement("div");
				d.id="ie-warning";
				d.innerHTML="<div><h1><?php echo trim(get_option('iewarning_alert_message_title')) == '' ? __("Stop using IE!", $textdomain) : str_replace('"', '\"', get_option('iewarning_alert_message_title')); ?></h1><br/><p><?php echo trim(get_option('iewarning_alert_message')) == '' ? __("Please, stop using Internet Exporer as browser at all. It's slow, unsecure and doesn't render web pages correctly.", $textdomain).__("You may download free and <strong>better</strong> browser like <a href='http://www.mozilla.com/firefox'>Mozilla Firefox</a> or <a href='http://opera.com/'>Opera</a>.", $textdomain) : str_replace('"', '\"', get_option('iewarning_alert_message')); ?></p><p style=\"text-align: center\"><a href=\"javascript:iewarningclose()\"><?php _e("Close", $textdomain); ?></a></p></div>";
				document.body.appendChild(d);
			}
			
			function iewarningclose() {
				document.body.removeChild(document.getElementById("ie-warning"));
			}
			setTimeout('iewarning()', <?php echo get_option('iewarning_alert_pause'); ?>);
			//]]>
		</script>
			<style type="text/css">
			<!--
			#ie-warning{position: absolute;top:200px;left:0;width:100%}
			#ie-warning div{width: 320px;margin:auto;background:#eeeeec;border:1px solid #3465a4;padding: 1em;text-align:center}
			#ie-warning div a{color:#3465a4}
			#ie-warning div h1 {color:#3465a4; padding: 0.3em}
			//-->
			</style>
		<?php
	}
}

function set_cookies () {
// 	setcookie('iewarning_show_times', 2);
	if (get_option('iewarning_show_times') != 'inf' && get_option('iewarning_show_times') > 0) {
		if(isset($_COOKIE['iewarning_show_times'])) {
			if ($_COOKIE['iewarning_show_times'] > 0) {
				setcookie('iewarning_show_times', $_COOKIE['iewarning_show_times'] - 1);
			}
		} else {
			setcookie('iewarning_show_times', get_option('iewarning_show_times'));
		}
	}
}

function need_work () {
	if (preg_match('/MSIE (\d.\d+);/', $_SERVER['HTTP_USER_AGENT'], $version)) {
		if (get_option('iewarning_min_version') == 'inf' || get_option('iewarning_min_version') > $version[1]) {
			if (isset($_COOKIE['iewarning_show_times'])) {
				if ($_COOKIE['iewarning_show_times'] > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function options_page() {
	add_options_page('IE Warning', 'IE Warning', 10, 'ie-warning/options.php');
}

add_action('init', 'set_cookies');
add_action('wp_head', 'header_files');
add_action('admin_menu', 'options_page');

add_option('iewarning_show_times', 'inf');
add_option('iewarning_min_version', 9.9);
add_option('iewarning_alert_pause', 2000);
add_option('iewarning_alert_message_title', '');
add_action('iewarning_alert_message', '');

?>