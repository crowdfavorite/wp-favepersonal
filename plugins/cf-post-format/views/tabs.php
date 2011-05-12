<div id="cf-post-format-tabs" class="cf-nav">
	<ul class="clearfix">
	<?php
		foreach ($post_formats as $format) {
			$class = ($format == $current_post_format || (empty($current_post_format) && $format == 'standard') ? 'current' : '');
			
			if ($format !== 'standard') {
				$format_string = get_post_format_string($format);
				$format_hash = 'post-format-'.$format;
			}
			else {
				$format_string = __('Standard Post', 'carrington-personal');
				$format_hash = 'post-format-0';
			}
			
			echo '<li><a '.(!empty($class) ? 'class="'.$class.'"' : NULL).' href="#'.$format_hash.'">'.$format_string.'</a></li>';
		}
	?>
	</ul>
</div>