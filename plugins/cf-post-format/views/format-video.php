<div class="cp-elm-block" id="cfpf-format-video-fields" style="display: none;">
	<label for="cfpf-format-video-embed"><?php _e('Video embed code or URL (oEmbed)', 'favepersonal'); ?></label>
	<textarea name="_format_video_embed" id="cfpf-format-video-embed"><?php echo esc_textarea(get_post_meta($post->ID, '_format_video_embed', true)); ?></textarea>
</div>	