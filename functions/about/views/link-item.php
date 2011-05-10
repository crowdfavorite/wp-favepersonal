<?php
	$favicon_url = cf_about_favicon_url('default'); // @TODO start off with default icon url
	if (!empty($link['favicon'])) {
		$favicon_url = cf_about_favicon_url($link['favicon']);
	}
?>
<li id="cfcp_about_link_<?php echo $i; ?>">
	<a href="<?php echo esc_url($link['url']); ?>"><img src="<?php echo $favicon_url; ?>" width="16" height="16" /></a>
	<input type="hidden" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][]" value='<?php echo json_encode($link); ?>' />
</li>