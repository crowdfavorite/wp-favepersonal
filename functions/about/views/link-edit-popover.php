<div class="cfp-popover-content">
	
<!-- link data -->
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-title"><?php _e('Title', 'favepersonal'); ?></label>
		<input type="text" name="title" id="cfp_link_title" class="cf-elm-text" value="" autocomplete="off" />
	</div>
	
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-url"><?php _e('URL', 'favepersonal'); ?></label>
		<input type="text" name="url" id="cfp_link_url" class="cf-elm-text" value="http://" autocomplete="off" />
	</div>

	<input type="hidden" name="favicon" id="cfp_link_favicon" value="" />
	<input type="hidden" name="favicon_status" id="cfp_link_favicon_status" value="" />
<!-- /link data -->
	
<!-- favicon fetch & preview -->
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full" id="cfp_link_icon_preview" style="display: none;">
		<div id="cfp-link-icon-preview-auto">
			<label for="cfp-link-icon"><?php _e('Icon', 'favepersonal'); ?></label>
			<span class="cfp-icon-preview"><img id="cfp_icon_preview" src="<?php echo trailingslashit(get_template_directory_uri()); ?>img/admin/ajax-loader.gif" width="16" height="16" /></span>
			<input type="button" name="edit" id="cfp-link-icon-edit" class="cfp-action-edit" value="Edit" />
		</div>
		<div id="cfp-link-icon-preview-custom" style="display: none;">
			<label for="cfp_link_custom_favicon"><?php _e('Icon', 'favepersonal'); ?></label>
			<input type="text" name="custom_favicon" id="cfp_link_custom_favicon" class="cf-elm-text" value="" />
			<input type="button" name="remove" class="cfp-action-remove" value="Remove" />
			<div class="cf-elm-help"><?php _e('Image URL - http://example.com/favicon.ico', 'favepersonal'); ?></div>
		</div>
		<div id="cfp_link_icon_message" class="cf-elm-help"></div>
	</div>
<!-- / favicon fetch & preview -->
	
</div>

<div class="cfp-popover-footer">
	<input class="button" type="button" name="submit_button" value="<?php _e('Add', 'favepersonal'); ?>" />
</div>