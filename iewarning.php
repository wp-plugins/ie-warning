<?php
/*
Plugin Name: IE warning
Plugin URI: http://bobrik.name/
Description: Adds a splash warning to every blog page, if reader using Internet Explorer.
Version: 0.12
Author: Ivan Babrou <ibobrik@gmail.com>
Author URI: http://bobrik.name/

Copyright (C) 2007 Ivan Babroŭ <ibobrik@gmail.com> http://bobrik.name

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

function header_files() {
	if (eregi("msie", $_SERVER['HTTP_USER_AGENT'])) {
		?><script type='text/javascript'>
			//<![CDATA[
			function iewarning() {
				var d=document.createElement("div");
				d.id="ie-warning";
				d.innerHTML="<div><h1>Stop using IE!</h1><br/><p>Please, stop using Internet Exporer as browser at all. It's slow, unsecure and doesn't render web pages correctly.</p><p>You may download free and <strong>better</strong> browser like <a href='http://www.mozilla.com/firefox'>Mozilla Firefox</a> or <a href='http://opera.com/'>Opera</a>.</p><p style=\"text-align: center\"><a href=\"javascript:iewarningclose()\">Close</a></p></div>";
				document.body.appendChild(d);
				document.getElementsByTagName("body").className="opacity70";
			}
			
			function iewarningclose() {
				document.body.removeChild(document.getElementById("ie-warning"));
				document.getElementsByTagName("body").className="";
			}
			setTimeout('iewarning()',2000);
			//]]>
		</script>
			<style type="text/css">
			<!--
			#ie-warning{position: absolute;top:200px;left:0;width:100%}
			#ie-warning div{width: 320px;margin:auto;background:#eeeeec;border:1px solid #3465a4;padding: 1em;text-align:center}
			#ie-warning div a{color:#3465a4}
			.opacity70{opacity:0.7}
			//-->
			</style>
		<?php
	}
}

add_action('wp_head', 'header_files');

?>
