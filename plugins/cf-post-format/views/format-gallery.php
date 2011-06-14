<div id="cfpf-format-gallery-preview" class="cp-elm-block cp-elm-block-image" style="display: none;">
	<label><span><?php _e('Gallery Images', 'cf-post-format'); ?></span></label>
	<div class="cp-elm-container">
<?php

// TODO - check for images
if (!cfcp_gallery_has_images()) {
?>
		<p class="none"><a href="#" class="button"><?php _e('Upload / Choose', 'cf-post-format'); ?></a></p>
<?php
}
else {
?>
		<ul class="cp-elm-image-gallery clearfix">
<?php
cfcp_gallery_excerpt(array(
	'number' => -1
));
?>
		</ul>
<?php
}
?>
	</div>
</div>