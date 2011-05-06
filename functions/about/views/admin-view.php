<div class="wrap cf cf-about-wrap cf-clearfix">
	<h2><?php _e('About Me, Myself and I', 'carrington-personal'); ?></h2>
	
	<!--Start Working-HTML-->
	<div id="cfp-about-settings">
		
		<div class="cf-elm-block">
			<label>Profile Photos</label>
			<div class="cfp-list-img-left cf-clearfix">
				<ul>
					<li><a href="#"><img src="http://placehold.it/50x40"></a></li>
					<li><a href="#"><img src="http://placehold.it/50x40"></a></li>
					<li><a href="#"><img src="http://placehold.it/50x40"></a></li>
					<li><a href="#"><img src="http://placehold.it/50x40"></a></li>
					<li><a href="#"><img src="http://placehold.it/50x40"></a></li>
				</ul>
			</div><!--cfp-about-imgs-->
			<a href="#add-photo" class="cfp-add-link">Add</a>
		</div>
		
		<div class="cf-elm-block cf-elm-width-full">
			<label for="title">Title</label>
			<input type="text" name="title" value="" id="title" class="cf-elm-text">
		</div>
		
		<div class="cf-elm-block cf-elm-width-full">
			<label for="bio">Bio</label>
			<textarea name="bio" rows="6" cols="40" id="bio" class="cf-elm-textarea"></textarea>
		</div>
		
		<div class="cf-elm-block">
			<label>Links</label>
			<div class="cfp-list-img-left cf-clearfix">
				<ul>
					<li><a href="#"><img src="http://placehold.it/16x16"></a></li>
					<li><a href="#"><img src="http://placehold.it/16x16"></a></li>
					<li><a href="#"><img src="http://placehold.it/16x16"></a></li>
					<li><a href="#"><img src="http://placehold.it/16x16"></a></li>
				</ul>
			</div><!--.cfp-link-->
			<a href="#add-link" class="cfp-add-link">Add</a>
		</div>
		
	</div><!--#cfp-about-->
	<!--END Working-HTML-->
	
	<div class="cfp-popover cfp-popover-top-center">
		<div class="cfp-popover-notch"></div>
		<div class="cfp-popover-inner">
			<div class="cfp-popover-content">
				<p><strong>.popover</strong></p>
				<p>The notch is an image, the rest is CSS. Still need to style elements that will appear inside the popover.</p>
				<p>Use .cfp-popover-top-right, .cfp-popover-top-right, .cfp-popover-top-center, .cfp-popover-color-preview to position the notch in the proper location.</p>
			</div><!--.cfp-popover-content-->
			<div class="cfp-popover-scroll">
				<p>scrollable list area</p>
				<p>scrollable list area</p>
				<p>scrollable list area</p>
				<p>scrollable list area</p>
				<p>scrollable list area</p>
				<p>scrollable list area</p>
				<p>scrollable list area</p>
			</div><!-- .cfp-popover-scroll -->
			<div class="cfp-popover-footer">
				<input class="button button-primary" type="submit" name="submit" value="Save Settings">
			</div><!-- .cfp-popover-footer -->
		</div><!--.cfp-popover-inner-->
	</div>

	<br clear="both" />
	<hr />
	<br />
	
	<p>This page likely throws php notices at the moment. Please ignore for now.</p>
	<form id="cfcp-about-settings" name="cfcp-about-settings" action="options.php" method="post">

		<?php settings_fields(CFCP_ABOUT_SETTINGS); ?>

		<fieldset>
			<p>We're temporarily taking a comma separated input of image ids. UI &amp; interaction TBD.</p>
			<p>
				<label for="cfcp_about_images"><?php _e('Images', 'carrington-personal'); ?></label><br />
				<input size="50" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[images]" id="cfcp_settings_images" value="<?php echo (is_array($settings['images']) ? implode(', ', $settings['images']) : ''); ?>" />
			</p>
		</fieldset>

		<fieldset>
			<p>
				<label for="cfcp_about_title"><?php _e('Title', 'carrington-personal'); ?></label><br />
				<input size="50" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[title]" id="cfcp_settings_title" value="<?php echo esc_attr($settings['title']); ?>" />
			</p>
		
			<p>
				<label for="cfcp_about_description"><?php _e('Description', 'carrington-personal'); ?></label><br />
				<textarea cols="50" rows="10" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[description]" id="cfcp_settings_description"><?php echo esc_attr($settings['description']); ?></textarea>
			</p>
		</fieldset>
		
		<h3>Links</h3>
		<fieldset>
			<p>We're temporarily only taking 2 link inputs here. UI &amp; interaction TBD.</p>
			<p>Favicon fetching is active and favicons are saved to: <code><?php echo esc_html(CFCP_FAVICON_DIR); ?></code></p>
			<?php
				if (!empty($settings['links'])) {
					for ($i = 0; $i < 2; $i++) {
						$link = $settings['links'][$i];
						include('link-inputs.php');
					}
				}
			?>
		</fieldset>
								
		<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'carrington-personal'); ?>" /></p>
	</form>
</div><!-- / cf-about-wrap -->