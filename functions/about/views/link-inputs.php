<?php
	$this_link = CFCP_ABOUT_SETTINGS."[links][{$i}]";
?>
<fieldset>
	<div class="cf-clearfix">
		<label for="cfcp_about_links_title_<?php echo $i; ?>"><?php _e('Link Title', 'carrington-personal'); ?></label>
		<input size="50" id="cfcp_about_links_title_<?php echo $i; ?>" type="text" name="<?php echo $this_link; ?>[title]" value="<?php esc_attr_e($link['title']); ?>" />
	</div>
	<div class="cf-clearfix">
		<label for="cfcp_about_links_url_<?php echo $i; ?>"><?php _e('Link Url', 'carrington-personal'); ?></label>
		<input size="50" id="cfcp_about_links_url_<?php echo $i; ?>"type="text" name="<?php echo $this_link; ?>[url]" value="<?php esc_attr_e($link['url']); ?>" />
		<?php
			if (!empty($settings['links'][$i]['favicon'])) {
				echo '<img src="'.cf_about_favicon_url($link['favicon']).'" width="16" height="16" style="margin-left: -22px; margin-top: 5px;" />';
			}					
		?>
	</div>
	<input type="hidden" name="<?php echo $this_link; ?>[favicon]" value="<?php echo esc_attr_e($link['favicon']); ?>" />
</fieldset>