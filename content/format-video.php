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

global $previousday;
$previousday = -1;

?>
<article id="post-<?php the_ID() ?>" <?php post_class('content cleafix') ?>>
	<div class="post-header">
		<h1 class="post-title"><?php the_title() ?></h1>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	
	<div class="post-media">
		<iframe src="http://player.vimeo.com/video/13588587?color=ff0065" width="710" height="400" frameborder="0"></iframe>
	</div>
	
	<?php cfct_misc('post-meta'); ?>
	
	<div class="post-content clearfix">
		<?php 
			the_content('<span class="more-link">'.__('Continued...', 'favepersonal').'</span>'); 
			$args = array(
				'before' => '<p class="pages-link">'. __('Pages: ', 'favepersonal'),
				'after' => "</p>\n",
				'next_or_number' => 'number'
			);
			wp_link_pages($args);
		?>
	</div><!--post-content-->
</article><!-- .post -->