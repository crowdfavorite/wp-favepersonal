<div id="cfpf-format-gallery-preview" class="cp-elm-block cp-elm-block-image" style="display: none;">
	<label><span><?php _e('Gallery Images', 'cf-post-format'); ?></span></label>
	<div class="cp-elm-container">
<?php

if (!cfpf_post_has_gallery()) {
?>
		<p class="none"><a href="#" class="button"><?php _e('Upload / Choose', 'cf-post-format'); ?></a></p>
<?php
}
else {
	echo do_shortcode('[gallery columns="9999"]');
}
?>
	</div>
</div>