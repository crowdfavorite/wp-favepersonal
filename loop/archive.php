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

if (have_posts()) {
	echo '<ol class="archive">';
	while (have_posts()) {
		the_post();
?>
	<li>
<?php
	// image archive
	if ( is_tax('post_format', 'post-format-image') ) {
		cfct_template_file('excerpt', 'format-image-archive');
	}
	// video archive
	else if ( is_tax('post_format', 'post-format-video') ) {
		cfct_template_file('excerpt', 'format-video-archive');
	}
	// other archives
	else {
		cfct_excerpt();
	}
?>
		<div id="post-<?php the_ID(); ?>-target"></div>
<?php
	}
	echo '</ol>';
}

?>