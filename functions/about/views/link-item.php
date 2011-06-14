<?php
	$favicon_url = (!empty($link['favicon']) ? cfcp_about_favicon_url($link['favicon']) : cfcp_about_favicon_url('default'));
	// json encoding the link data looks weird but it allows us much more freedom with sortables
	// we can do name="settings[links][]" and let the dom order be the order instead of having to
	// keep track of the items ids and the order during editing
?>
<li class="cfcp_about_link_item" id="link-<?php echo md5(json_encode($link)); ?>">
	<a href="<?php echo esc_url($link['url']); ?>"><img src="<?php echo $favicon_url; ?>" width="16" height="16" /></a>
	<input type="hidden" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][]" value='<?php echo json_encode($link); ?>' />
</li>