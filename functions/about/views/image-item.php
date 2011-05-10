<?php
	$img = wp_get_attachment_image($img_id, $img_size, false, array());

	// bail if the image is missing
	if (empty($img)) {
		return '';
	}
?>
<a href="<?php echo admin_url(sprintf($post_type_object->_edit_link.'&amp;action=edit', $img_id)); ?>"><?php echo $img; ?></a>
<input type="hidden" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[images][]" value="<?php esc_attr_e($img_id); ?>" />