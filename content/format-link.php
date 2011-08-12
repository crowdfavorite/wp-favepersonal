<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2011 Crowd Favorite, Ltd. All rights reserved.
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
<article id="post-<?php the_ID() ?>" <?php post_class('content'); ?>>
	<div class="post-header">
		<h1 class="post-title"><a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?> &rarr;</a></h1>
		<time class="post-date" datetime="<?php the_time('c'); ?>" pubdate><?php echo cfcp_date(); ?></time>
		<?php cfct_misc('post-meta'); ?>
	</div>
	<div class="post-content clearfix">
		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php echo $url; ?>" class="link-screenshot"><?php the_post_thumbnail('thumb-img'); ?></a>
		<?php } ?>
		<?php the_content(); ?>
	</div><!--post-content-->
</article><!-- .post -->

