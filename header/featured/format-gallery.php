<?php

include(CFCT_PATH.'header/featured/init.php');

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<?php
					cfcp_gallery_featured(array(
						'size' => 'thumb-img',
						'number' => '4',
						'view_all_link' => false,
					));
					?>
					<div class="featured-content">
						<h2 class="featured-title"><?php the_title(); ?></h2>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 150, "<p>", "&hellip;</p>"); ?>
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Read More', 'favepersonal'); ?></a>
				</article><!-- .featured -->
