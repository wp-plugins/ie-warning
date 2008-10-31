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
        <th scope="row">How much times we neet to show alert window</th> 
        <td>
			<input type="text" name="iewarning_show_times" value="<?php echo get_option('iewarning_show_times'); ?>" />
			<p><small>Try 'inf', if want to show on every page</small></p>
        </td>
        </tr>
		<tr valign="baseline">
        <th scope="row">Minimum acceptable IE version</th> 
        <td>
			<input type="text" name="iewarning_min_version" value="<?php echo get_option('iewarning_min_version'); ?>" />
			<p><small>Set to <strong>x.y</strong> show warning in every IE version less than <strong>x.y</strong></small></p>
        </td>
        </tr>
		<tr valign="baseline">
        <th scope="row">Sleep before dispay alert (in milliseconds)</th> 
        <td>
			<input type="text" name="iewarning_alert_pause" value="<?php echo get_option('iewarning_alert_pause'); ?>" />
			<p><small>Default is 2000 (2 seconds)</small></p>
        </td>
        </tr>
     </table>

    <p class="submit">
      <input type="submit" name="Submit" value="Save Changes" />
    </p>
  </form>
</div>