<?php

include(CFCT_PATH.'header/featured/init.php');

global $wp_embed, $content_width;
$content_width = '310'; // set for this view
add_filter('cfcp_format_video_embed', array(&$wp_embed, 'autoembed'));

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<div class="featured-vid">
						<?php
						echo apply_filters(
							'cfcp_format_video_embed', 
							get_post_meta(get_the_ID(), '_format_video_embed', true)
						);
						?>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Permalink', 'favepersonal'); ?></a>
				</article><!-- .featured -->





