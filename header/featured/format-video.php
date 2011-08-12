<?php

include(CFCT_PATH.'header/featured/init.php');

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<?php echo $image; ?>
					<div class="featured-content">
						<h1 class="featured-title"><?php the_title(); ?></h1>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 150, "<p>", "&hellip;</p>"); ?>
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Watch Video', 'favepersonal'); ?></a>
				</article><!-- .featured -->





