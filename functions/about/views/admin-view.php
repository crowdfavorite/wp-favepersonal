<div class="wrap cf cf-about-wrap cf-clearfix">
	<?php screen_icon(); ?>
	<h2><?php _e('Bio Widget Settings', 'favepersonal'); ?></h2>
	
<?php 
if (!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true) {
	echo '<div class="updated below-h2 fade cf-updated-message-fade" id="message"><p>'.__('Settings updated.', 'favepersonal').'</p></div>';
}
?>

	<p><?php __('Use this settings screen to set your photos, title, bio text and links for the Bio Widget before adding it to a sidebar.', 'favepersonal')?></p>
	
	<div id="cfp-about-settings">
		<form id="cfp-about-settings" name="cfp-about-settings" action="<?php echo admin_url('options.php'); ?>" method="post">

			<?php settings_fields(CFCP_ABOUT_SETTINGS); ?>
			
			<fieldset>
				<div class="cf-elm-block" id="cfp-about-imgs-input">
					<label class="typ-sc"><?php _e('Profile Photos', 'favepersonal'); ?></label>
					<div class="cfp-list-img-left cf-clearfix">
						<ul>
						<?php
							echo '<li class="no-image-item'.(empty($settings['images']) ? '' : ' cf-hidden').'"><p>'.__('Click the "+" to the right to start adding images', 'favepersonal').'</p></li>';
							if (!empty($settings['images'])) {
								$post_type_object = get_post_type_object('attachment');
								$img_size = 'tiny-img';
								foreach ($settings['images'] as $img_id) {
									echo '<li>'.cfct_template_content(
										'functions/about/views',
										'image-item',
										compact('img_id', 'post_type_object', 'img_size')
									).'</li>';
								}
							}
						?>
						</ul>
					</div><!--cfp-about-imgs-->
					<a href="#cfp-img-search-popover" class="cfp-add-link" id="cfp-add-img"><?php _e('Add', 'favepersonal'); ?></a>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="cf-elm-block cf-elm-width-full">
					<label for="title" class="typ-sc"><?php _e('Title', 'favepersonal'); ?></label>
					<input type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[title]" class="cf-elm-text" id="cfcp_settings_title" value="<?php echo esc_attr($settings['title']); ?>">
				</div>
		
				<div class="cf-elm-block cf-elm-width-full">
					<label for="bio" class="typ-sc"><?php _e('Bio', 'favepersonal'); ?></label>
					<textarea rows="6" cols="40" class="cf-elm-textarea" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[description]" id="cfcp_settings_description"><?php echo esc_textarea($settings['description']); ?></textarea>
				</div>
			</fieldset>
		
			<fieldset>
				<div class="cf-elm-block">
					<label class="typ-sc"><?php _e('Links', 'favepersonal'); ?></label>
					<div class="cfp-list-img-left cf-clearfix">
						<ul id="cfp-link-items">
						<?php
							echo '<li class="no-link-item'.(empty($settings['links']) ? '' : ' cf-hidden').'"><p>'.__('Click the "+" to the right to start adding links', 'favepersonal').'</p></li>';
							if (!empty($settings['links']) && is_array($settings['links'])) {
								foreach ($settings['links'] as $link) {
									if (is_array($link)) {
										cfct_template_file(
											'functions/about/views',
											'link-item',
											compact('link')
										);
									}
								}
							}
						?>
						</ul>
					</div><!--.cfp-link-->
					<a href="#cfp-link-edit-popover" class="cfp-add-link" id="cfp-add-link"><?php _e('Add', 'favepersonal'); ?></a>
				</div>
			</fieldset>
			
			<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'favepersonal'); ?>" /></p>
		</form>
	</div><!--#cfp-about-->
</div><!-- / cf-about-wrap -->
<?php
// images popover
echo cfcp_get_popover_html('cfp-img-search-popover', array(
	'html' => cfct_template_content('functions/about/views', 'img-search-popover'),
	'arrow_pos' => 'right'
));

// links popover
echo cfcp_get_popover_html('cfp-link-edit-popover', array(
	'html' => cfct_template_content('functions/about/views', 'link-edit-popover'),
	'arrow_pos' => 'right'
));

echo cfcp_get_popover_html('cfp-link-remove-popover', array(
	'html' => cfct_template_content('functions/about/views', 'link-remove-popover'),
	'arrow_pos' => 'left'
));
?>