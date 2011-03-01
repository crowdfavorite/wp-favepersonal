<?php

/**
 * @package carrington-personal
 *
 * This file is part of the Carrington Personal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/carrington-personal/
 *
 * Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
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

global $previousday;
$previousday = -1;

?>
<div id="post-content-<?php the_ID() ?>" <?php post_class('hentry full') ?>>
	<h1 class="entry-title full-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h1>
	<div class="entry-content full-content">
<?php 
		the_content('<span class="more-link">'.__('Continued...', 'carrington-text').'</span>'); 
		$args = array(
			'before' => '<p class="pages-link">'. __('Pages: ', 'carrington-text'),
			'after' => "</p>\n",
			'next_or_number' => 'number'
		);
		wp_link_pages($args);
?>
		<div class="clear"></div>
	</div><!--/entry-content-->
	<?php if (!is_singular()) { ?>
		<p class="comments-link"><?php comments_popup_link(__('No Comments', 'carrington-text'), __('1 Comment', 'carrington-text'), __('% Comments', 'carrington-text')); ?></p>
	<?php } ?>
	<div id="post-comments-<?php the_ID(); ?>-target"></div>
	<p class="filed categories"><?php printf(__('Categories: %s.', 'carrington-text'), get_the_category_list(', ')) ?></p>
	<?php the_tags(__('<p class="filed tags">Tags: ', 'carrington-text'), ', ', '</p>'); ?>
	<!--/filed-->
	<div class="by-line">
		<?php edit_post_link(__('Edit', 'carrington-text'), '<div class="entry-editlink">', '</div>'); ?>
		<address class="author vcard full-author">
			<?php printf(__('<span class="by">By</span> %s', 'carrington-blog'), '<a class="url fn" href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="View all posts by ' . attribute_escape(get_the_author()) . '">'.get_the_author().'</a>') ?>
		</address>
		&mdash;
		<span class="date full-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_date(); _e(' at ', 'carrington-text'); the_time(); ?></abbr></span>
	</div><!--/by-line-->
</div><!-- .post -->