<?php

include(CFCT_PATH.'header/featured/init.php');

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<div class="featured-content">
						<span class="featured-format"></span>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 170, "<p>", "&hellip;</p>"); ?>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Read More', 'favepersonal'); ?></a>
				</article><!-- .featured -->
