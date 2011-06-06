<div class="cfp-popover-content" id="cfp-link-edit">
	
<!-- link data -->
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-title"><?php _e('Title', 'carrington-personal'); ?></label>
		<input type="text" name="title" id="cfp_link_title" class="cf-elm-text" value="" />
	</div>
	
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-url"><?php _e('Link', 'carrington-personal'); ?></label>
		<input type="text" name="url" id="cfp_link_url" class="cf-elm-text" value="" />
	</div>

	<input type="hidden" name="favicon" id="cfp_link_favicon" value="" />
	<input type="hidden" name="favicon_status" id="cfp_link_favicon_status" value="" />
<!-- /link data -->
	
<!-- favicon fetch & preview -->
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full" id="cfp_link_icon_preview" style="display: none;">
		<label for="cfp-link-icon"><?php _e('Icon', 'carrington-personal'); ?></label>
		<span class="cfp-icon-preview"><img id="cfp_icon_preview" src="<?php echo trailingslashit(get_template_directory_uri()); ?>img/admin/ajax-loader.gif" width="16" height="16" /></span>
		<input type="button" name="edit" id="cfp-link-icon-edit" class="cfp-action-edit" value="Edit" />
		
		<div id="cfp-link-icon-preview-custom" class="cf-hidden">
			<input type="text" name="custom_favicon" id="cfp_link_custom_favicon" class="cf-elm-text" value="" />
			<input type="button" name="remove" class="cfp-action-remove" value="Remove" />
			<div class="cf-elm-help"><?php printf(__('Image Url or <a href="%s">upload a new photo</a>', 'carrington-personal'), '#'); ?></div>
		</div>
		<div id="cfp_link_icon_message" class="cf-elm-help"></div>
	</div>
<!-- / favicon fetch & preview -->
	
</div>

<div class="cfp-popover-footer">
	<input class="button button-primary" type="button" name="submit" value="<?php _e('Save', 'carrington-personal'); ?>" />
	<input class="button" type="button" name="cancel" value="<?php _e('Cancel', 'carrington-personal'); ?>" />
	<a href="#" class="cf-remove-link"><?php _e('Remove', 'carrington-personal'); ?></a>
</div>