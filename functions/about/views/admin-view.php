<div class="wrap cf cf-about-wrap cf-clearfix">
	<h2><?php _e('About Me, Myself and I', 'carrington-personal'); ?></h2>
	
	<?php 
		if (!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true) {
			echo '<div class="updated below-h2 fade cf-updated-message-fade" id="message"><p>'.__('Settings updated.', 'carrington-personal').'</p></div>';
		}
	?>
	
	<!--Start Working-HTML-->
	<div id="cfp-about-settings">
		<form id="cfcp-about-settings" name="cfcp-about-settings" action="options.php" method="post">

			<?php settings_fields(CFCP_ABOUT_SETTINGS); ?>
			
			<fieldset>
				<div class="cf-elm-block" id="cfp-about-imgs-input">
					<label><?php _e('Profile Photos', 'carrington-personal'); ?></label>
					<div class="cfp-list-img-left cf-clearfix">
						<ul>
						<?php
							echo '<li class="no-image-item'.(empty($settings['images']) ? '' : ' cf-hidden').'"><p>'.__('Click the "+" to the right to start adding images', 'carrington-personal').'</p></li>';
							if (!empty($settings['images'])) {
								$post_type_object = get_post_type_object('attachment');
								$img_size = 'tiny-img';
								foreach ($settings['images'] as $img_id) {
									echo '<li>'.cfcp_load_view('functions/about/views/image-item.php', compact('img_id', 'post_type_object', 'img_size')).'</li>';
								}
							}
						?>
						</ul>
					</div><!--cfp-about-imgs-->
					<a href="#add-photo" class="cfp-add-link" id="cfp-add-img"><?php _e('Add', 'carrington-personal'); ?></a>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="cf-elm-block cf-elm-width-full">
					<label for="title"><?php _e('Title', 'carrington-personal'); ?></label>
					<input type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[title]" class="cf-elm-text" id="cfcp_settings_title" value="<?php echo esc_attr($settings['title']); ?>">
				</div>
		
				<div class="cf-elm-block cf-elm-width-full">
					<label for="bio"><?php _e('Bio', 'carrington-personal'); ?></label>
					<textarea rows="6" cols="40" class="cf-elm-textarea" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[description]" id="cfcp_settings_description"><?php echo esc_textarea($settings['description']); ?></textarea>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="cf-elm-block">
					<label><?php _e('Links', 'carrington-personal'); ?></label>
					<div class="cfp-list-img-left cf-clearfix">
						<ul>
						<?php
							echo '<li class="no-favicon-item'.(empty($settings['links']) ? '' : ' cf-hidden').'"><p>'.__('Click the "+" to the right to start adding links', 'carrington-personal').'</p></li>';
							if (!empty($settings['links'])) {
								foreach ($settings['links'] as $i => $link) {
									echo cfcp_load_view('functions/about/views/link-item.php', compact('i', 'link'));
								}
							}
						?>
						</ul>
					</div><!--.cfp-link-->
					<a href="#add-link" class="cfp-add-link" id="cfp-add-link"><?php _e('Add', 'carrington-personal'); ?></a>
				</div>
			</fieldset>
			
			<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'carrington-personal'); ?>" /></p>
		</form>
	</div><!--#cfp-about-->
</div><!-- / cf-about-wrap -->
<?php
	// images popover
	$img_search_popover_html = cfcp_load_view('functions/about/views/img-search-popover.php', array());
	echo cfp_get_popover_html('cfp-img-search', array(
		'html' => $img_search_popover_html,
		'arrow_pos' => 'right'
	));
	
	// links popover
	$link_edit_popover_html = cfcp_load_view('functions/about/views/link-edit-popover.php', array());
	echo cfp_get_popover_html('cfp-link-edit', array(
		'html' => $link_edit_popover_html,
		'arrow_pos' => 'right'
	));
?>