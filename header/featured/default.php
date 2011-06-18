<?php

global $post;
$post = get_post($post_id);
setup_postdata($post);

// check for featured image
if (has_post_thumbnail()) {
// set class
	$image_class = 'has-featured-img';
// set image
	ob_start();
	the_post_thumbnail('small-img');
	$image = ob_get_Clean();
}
else {
	$image = $image_class = '';
}

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $image_class; ?>">
					<?php echo $image; ?>
					<div class="featured-content">
						<h2 class="featured-title"><?php the_title(); ?></h2>
						<div class="featured-description">
							<p><?php the_excerpt(); ?></p>							
						</div>
					</div>
					<a href="<?php the_permalink(); ?>" class="featured-link"><?php _e('Read More', 'favepersonal'); ?></a>
				</article><!-- .featured -->
