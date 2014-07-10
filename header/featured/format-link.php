<?php

include(CFCT_PATH.'header/featured/init.php');

$title_attr = the_title_attribute(array('echo' => false));
$title_permalink = sprintf(__('Permanent link to %s', 'favepersonal'), $title_attr);
$title_external = sprintf(__('External link to %s', 'favepersonal'), $title_attr);

$url = get_permalink(get_the_ID());
$title = $title_permalink;

/*

// enable this code if you want header link posts
// to go directly to the page being linked to

$link = get_post_meta(get_the_ID(), '_format_link_url', true);
if (!empty($link)) {
	$url = $link;
	$title = $title_external;
}

*/

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<?php echo $image; ?>
					<div class="featured-content">
						<h1 class="featured-title"><?php the_title(); ?>  &rarr;</h1>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 150, "<p>", "&hellip;</p>"); ?>
						</div>
					</div>
					<a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"  class="featured-link"><?php _e('Go to link', 'favepersonal'); ?> &rarr;</a>
				</article><!-- .featured -->
