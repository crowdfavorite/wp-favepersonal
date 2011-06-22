<?php

include(CFCT_PATH.'header/featured/init.php');

$title_attr = the_title_attribute(array('echo' => false));
$title_permalink = sprintf(__('Permanent link to %s', 'favepersonal'), $title_attr);
$title_external = sprintf(__('External link to %s', 'favepersonal'), $title_attr);

$link = get_post_meta(get_the_ID(), '_format_link_url', true);
if (!empty($link)) {
	$url = $link;
	$title = $title_external;
}
else {
	$url = get_permalink(get_the_ID());
	$title = $title_permalink;
}

?>
				<article id="featured-post-<?php echo $slot; ?>" class="featured <?php echo $class; ?>">
					<?php echo $image; ?>
					<div class="featured-content">
						<span class="featured-format"></span>
						<h2 class="featured-title"><?php the_title(); ?>  &rarr;</h2>
						<div class="featured-description">
							<?php echo cf_trim_text(get_the_excerpt(), 160, "<p>", "&hellip;</p>"); ?>
						</div>
					</div>
					<a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"  class="featured-link"><?php _e('Go to link', 'favepersonal'); ?> &rarr;</a>
				</article><!-- .featured -->