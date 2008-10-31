<?php
$location = $options_page;

if ('process' == $_POST['stage']) {
	update_option('iewarning_show_times', $_POST['iewarning_show_times']);
	update_option('iewarning_min_version', $_POST['iewarning_min_version']);
	update_option('iewarning_alert_pause', $_POST['iewarning_alert_pause']);
}

?>

<div class="wrap">
	<h2>IE Warning</h2>
	<form name="form1" method="post" action="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=ie-warning/options.php'; ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
	<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
		<tr valign="baseline">
			<th scope="row"><?php _e("How much times we neet to show alert window"); ?></th>
			<td>
				<input type="text" name="iewarning_show_times" value="<?php echo get_option('iewarning_show_times'); ?>" />
				<p><small><?php _e("Try 'inf', if want to show on every page"); ?></small></p>
			</td>
		</tr>
		<tr valign="baseline">
			<th scope="row"><?php _e("Minimum acceptable IE version"); ?></th>
			<td>
				<input type="text" name="iewarning_min_version" value="<?php echo get_option('iewarning_min_version'); ?>" />
				<p><small><?php _e("Set to <strong>x.y</strong> show warning in every IE version less than <strong>x.y</strong>"); ?></small></p>
			</td>
		</tr>
		<tr valign="baseline">
			<th scope="row"><?php _e("Sleep before dispay alert (in milliseconds)"); ?></th>
			<td>
				<input type="text" name="iewarning_alert_pause" value="<?php echo get_option('iewarning_alert_pause'); ?>" />
				<p><small><?php _e("Default is 2000 (2 seconds)"); ?></small></p>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e("Save Changes"); ?>" />
	</p>
	</form>
</div>