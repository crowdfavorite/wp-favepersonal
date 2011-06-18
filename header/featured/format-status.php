<?php

include(CFCT_PATH.'header/featured/init.php');

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<div class="featured-content">
						<div class="featured-description">
							<?php the_excerpt(); ?>							
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Read More', 'favepersonal'); ?></a>
				</article><!-- .featured -->
