<?php

include(CFCT_PATH.'header/featured/init.php');

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<?php echo $image; ?>
					<div class="featured-content">
						<span class="featured-format"></span>
						<h2 class="featured-title"><?php the_title(); ?></h2>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 160, "<p>", "&hellip;</p>"); ?>
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Read More', 'favepersonal'); ?></a>
				</article><!-- .featured -->
