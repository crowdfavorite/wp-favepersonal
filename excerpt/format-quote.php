<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/favepersonal/
 *
 * Copyright (c) 2008-2013 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

$source_name = get_post_meta(get_the_ID(), '_format_quote_source_name', true);
$source_url = get_post_meta(get_the_ID(), '_format_quote_source_url', true);

// this is a rare edge case
if (empty($source_name) && !empty($source_url)) {
	$source_name = '#';
}

if (!empty($source_url)) {
	$source = '&mdash; <a href="'.esc_url($source_url).'"><i>'.esc_html($source_name).'</i></a>';
}
else if (!empty($source_name)) {
	$source = '&mdash; <i>'.esc_html($source_name).'</i>';
}
else {
	$source = null;
}

?>
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt clearfix'); ?>>
	<time class="entry-date" datetime="<?php the_time('c'); ?>" pubdate><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></time>
	<div class="entry-content">
		<blockquote>
			<?php the_excerpt(); ?>
		</blockquote>
<?php
if (!empty($source)) {
?>
		<p class="format-quote-attribution"><?php echo $source; ?></p>
<?php
}
?>
	</div>
	<?php cfct_misc('entry-meta-excerpts'); ?>
</article>