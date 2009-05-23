<?php
/*
Plugin Name: IE warning
Plugin URI: http://bobrik.name/code/wordpress/ie-warning/
Description: Shows nice and simple warning to your visitors with Internet Explorer, supports customization and settings
Version: 0.21
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
				d.innerHTML="<div><p class='ie-warning-title'><?php echo trim(get_option('iewarning_alert_message_title')) == '' ? __("Stop using IE!", 'iewarning') : get_option('iewarning_alert_message_title'); ?></p> <p><?php echo trim(get_option('iewarning_alert_message')) == '' ? __("Please, stop using Internet Exporer as browser at all. It's slow, unsecure and doesn't render web pages correctly.", 'iewarning').' '.__("You may download free and <strong>better</strong> browser like <a href='http://www.mozilla.com/firefox'>Mozilla Firefox</a> or <a href='http://opera.com/'>Opera</a>.", 'iewarning') : get_option('iewarning_alert_message'); ?></p> <p class='ie-warning-close'><a href=\"javascript:iewarningclose()\"><?php _e("Close", 'iewarning'); ?></a></p></div>";
				document.body.appendChild(d);
			}
			function wait() {
				if (document.body == null) {
					setTimeout('wait()', 1000);
				} else {
					iewarning();
				}
			}
			function iewarningclose() {
				document.body.removeChild(document.getElementById("ie-warning"));
			}
			setTimeout('wait()', <?php echo get_option('iewarning_alert_pause'); ?>);
			//]]>
		</script>
			<style type="text/css">
			<!--
				<?php echo (trim(get_option('iewarning_alert_css')) != '' ? get_option('iewarning_alert_css') : get_css('top-line')); ?>
			//-->
			</style>
		<?php
	}
}

function set_cookies () {
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

function get_css($layout, $js = false) {
	if ($layout == 'top-line') {
		$value = "#ie-warning{position:absolute;width:100%;top:0px;text-align:center}
			#ie-warning div{background:#fcaf3e;border-bottom:1px solid #204a87;background:url(".get_option('siteurl')."/wp-content/plugins/ie-warning/warning.png);padding:2px}
			#ie-warning div a{color:#204a87;font-weight:bold}
			#ie-warning div p {display:inline;}
			#ie-warning div p.ie-warning-title {visibility:hidden;height:0px;display:block;margin:0px}
			#ie-warning div p.ie-warning-close a {color:#cc0000}";
	} else if ($layout == 'old-splash') {
		$value = "#ie-warning{position:absolute;top:200px;width:100%;text-align:center}
			#ie-warning div{width: 320px;margin:auto;background:#eee;border:1px solid #3465a4;padding: 1em;}
			#ie-warning div a{color:#3465a4} #ie-warning #ie-warning-close {text-align:center}
			#ie-warning div p.ie-warning-title {color:#3465a4; padding: 0.3em; font-size:150%;font-weight:bold}
			#ie-warning div p.ie-warning-close a {color:#cc0000}";
	}
	if ($js) {
		return  str_replace("\t", "",str_replace("\n", "\\n", str_replace('\'', '\\\'', $value)));
	} else {
		return $value;
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
add_option('iewarning_alert_css', '');

?>
