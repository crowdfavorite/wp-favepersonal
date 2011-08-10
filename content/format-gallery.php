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

$sizes = cfcp_gallery_max_size('gallery-large-img');

?>
<article id="post-<?php the_ID() ?>" <?php post_class('content clearfix') ?>>
	<div class="post-header">
		<h1 class="post-title"><?php the_title() ?></h1>
		<p class="post-date"><?php echo cfcp_date(); ?></p>
	</div>
	
	<?php
	cfcp_gallery(array(
		'before' => '<div class="post-media">',
		'after' => '</div>',
	));
	cfct_misc('post-meta'); ?>
	
	<div class="post-content clearfix">
		<?php 
			the_content('<span class="more-link">'.__('Continued&hellip;', 'favepersonal').'</span>'); 
			$args = array(
				'before' => '<p class="pages-link">'. __('Pages: ', 'favepersonal'),
				'after' => "</p>\n",
				'next_or_number' => 'number'
			);
			wp_link_pages($args);
		?>
	</div><!--post-content-->
</article><!-- .post -->
<script type="text/javascript">
var cfcpGalleryHeight = <?php echo $sizes['height']; ?>;
var cfcpGalleryWidth = <?php echo $sizes['width']; ?>;
</script>