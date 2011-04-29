<style type="text/css">
	/* Temporary CSS - NUKE ME WHEN READY */
	.cf-about-wrap input,
	.cf-about-wrap textarea,
	.cf-about-wrap label {
		float: left;
		display: block;
	}
	label {
		width: 200px;
	}
	.cf-clearfix {
		clear: both;
	}
	.cf-about-wrap fieldset,
	.cf-about-wrap p.submit {
		border-top: 1px solid gray;
		margin: 15px 0;
		padding: 15px 0;
	}
</style>
<div class="wrap cf-about-wrap cf-clearfix">
	<h2><?php _e('About', 'carrington-personal'); ?></h2>
	<form id="cfcp-about-settings" name="cfcp-about-settings" action="options.php" method="post">

		<?php settings_fields(CFCP_ABOUT_SETTINGS); ?>

		<fieldset>
			<p>We're temporarily taking a comma separated input of image ids. UI &amp; interaction TBD.</p>
			<div>
				<label for="cfcp_about_images"><?php _e('Images', 'carrington-personal'); ?></label>
				<input size="50" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[images]" id="cfcp_settings_images" value="<?php echo (is_array($settings['images']) ? implode(', ', $settings['images']) : ''); ?>" />
			</div>
		</fieldset>

		<fieldset>
			<div class="cf-clearfix">
				<label for="cfcp_about_title"><?php _e('Title', 'carrington-personal'); ?></label>
				<input size="50" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[title]" id="cfcp_settings_title" value="<?php echo esc_attr($settings['title']); ?>" />
			</div>
		
			<div class="cf-clearfix">
				<label for="cfcp_about_description"><?php _e('Description', 'carrington-personal'); ?></label>
				<textarea cols="50" rows="10" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[description]" id="cfcp_settings_description"><?php echo esc_attr($settings['description']); ?></textarea>
			</div>
		</fieldset>
				
		<fieldset>
			<p>We're temporarily only taking 2 link inputs here. UI &amp; interaction TBD.</p>
			<div class="cf-clearfix">
				<label for="cfcp_about_links_title_0"><?php _e('Link One Title', 'carrington-personal'); ?></label>
				<input size="50" id="cfcp_about_links_title_0" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][0][title]" value="<?php echo esc_attr($settings['links'][0]['title']); ?>">
				<br  class="cf-clearfix">
				<label for="cfcp_about_links_url_0"><?php _e('Link One Url', 'carrington-personal'); ?></label>
				<input size="50" id="cfcp_about_links_url_0"type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][0][url]" value="<?php echo esc_attr($settings['links'][0]['url']); ?>">
			</div>
			<br /><br />
			<div class="cf-clearfix">
				<label for="cfcp_about_links_title_1"><?php _e('Link Two Title', 'carrington-personal'); ?></label>
				<input size="50" id="cfcp_about_links_title_1" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][1][title]" value="<?php echo esc_attr($settings['links'][1]['title']); ?>">
				<br class="cf-clearfix" />
				<label for="cfcp_about_links_url_1"><?php _e('Link Two Url', 'carrington-personal'); ?></label>
				<input size="50" id="cfcp_about_links_url_1" type="text" name="<?php echo CFCP_ABOUT_SETTINGS; ?>[links][1][url]" value="<?php echo esc_attr($settings['links'][1]['url']); ?>">
			</div>
		</fieldset>
								
		<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'carrington-personal'); ?>" /></p>
	</form>
</div><!-- / cf-about-wrap -->