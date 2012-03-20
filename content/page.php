<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
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

?>
<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
	<div class="page-header">
		<h1 class="page-title"><?php the_title() ?></h1>
	</div>
	<div class="page-content">
		<?php
			the_content('<span class="more-link">'.__('Continued&hellip;', 'favepersonal').'</span>'); 
			$args = array(
				'before' => '<p class="pages-link">'. __('Pages: ', 'favepersonal'),
				'after' => "</p>\n",
				'next_or_number' => 'number'
			);
			wp_link_pages($args);
		?>
	</div><!--.page-content-->
</article><!-- .post -->