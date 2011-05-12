<div class="cfp-popover-content" id="cfp-link-edit">
	
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-title"><?php _e('Title', 'carrington-personal'); ?></label>
		<input type="text" name="title" id="cfp-link-title" class="cf-elm-text" value="" />
	</div>
	
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full">
		<label for="cfp-link-url"><?php _e('Link', 'carrington-personal'); ?></label>
		<input type="text" name="url" id="cfp-link-url" class="cf-elm-text" value="" />
	</div>
	
	<div class="cf-elm-block cf-lbl-pos-left cf-elm-width-full" id="cfp-link-icon-preview" style="display: none;">
		<label for="cfp-link-icon"><?php _e('Icon', 'carrington-personal'); ?></label>
		<img id="cfp-icon-preview" src="<?php echo trailingslashit(get_template_directory_uri()); ?>img/admin/ajax-loader.gif" width="16" height="16" />
		
		<input type="button" name="edit" id="cfp-link-icon-edit" value="Edit" />
		<input type="hidden" name="favicon_status" id="cfp-link-favicon-status" value="" />
		
		<div class="cf-hidden">
			<input type="text" name="custom_favicon" id="cfp-link-custom-favicon" value="" />
			<p><?php printf(__('Image Url or <a href="%s">upload a new photo</a>', 'carrington-personal'), '#'); ?></p>
		</div>
		<div id="cfp-link-icon-message" class="cf-elm-help"></div>
	</div>
	
</div>

<div class="cfp-popover-footer">
	<input class="button button-primary" type="submit" name="submit" value="<?php _e('Save', 'carrington-personal'); ?>">
	<a href="#" class="cf-remove-link"><?php _e('Remove', 'carrington-personal'); ?></a>
</div>