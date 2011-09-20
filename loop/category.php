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

$category_description = category_description();
if (!empty($category_description)) {
	echo apply_filters('category_archive_meta', '<div class="category-archive-meta">'.$category_description.'</div>');
}

if (have_posts()) {
	echo '<ol class="archive">';
	while (have_posts()) {
		the_post();
?>
	<li>
		<?php cfct_excerpt(); ?>
		<div id="post-<?php the_ID(); ?>-target"></div>
	</li>
<?php
	}
	echo '</ol>';
}

?>