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

/* add items to array as strings

function my_status_meta($meta_items) {
	$meta_items[] = 'in reply to <a href="http://examplecom/username/statuses/123456">@username</a>';
	return $meta_items;
}
add_filter('cfcp_format_status_meta', 'my_status_meta');

*/
$meta_items = apply_filters('cfcp_format_status_meta', array());
$meta_items = apply_filters('cfcp_format_status_meta_excerpt', $meta_items);

?>
<article id="post-content-<?php the_ID() ?>" <?php post_class('content'); ?>>
	<p class="post-date"><?php echo cfcp_date(); ?></p>
	<div class="post-content">
		<div class="post-status-content">
			<?php
				the_content();
			?>
		</div>
<?php
if (count($meta_items)) {
?>
		<p class="post-status-meta"><?php echo implode(' &middot; ', $meta_items); ?></p>
<?php
}
?>
	</div><!--post-content-->	
</article><!-- .excerpt -->