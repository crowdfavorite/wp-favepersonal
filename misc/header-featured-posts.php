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

?>

<div id="featured-posts" class="clearfix cf-clearfix">
	<article id="featured-post-1" class="featured has-featured-img">
		<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-1.jpg" width="310" height="180" class="featured-img" />
		<div class="featured-content">
			<h2 class="featured-title">Praesent Placerat</h2>
			<div class="featured-description">
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>							
			</div>
		</div>
		<a href="" class="featured-link">Read More</a>
	</article><!-- .featured -->
	<article id="featured-post-2" class="featured has-featured-img">
		<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-2.jpg" width="310" height="180" class="featured-img" />
		<div class="featured-content">
			<h2 class="featured-title">Vestibulum Auctor Dapibus</h2>
			<div class="featured-description">
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
			</div>
		</div>
		<a href="" class="featured-link">Read More</a>
	</article><!-- .featured -->
	<article id="featured-post-3" class="featured">
		<div class="featured-content">
			<h2 class="featured-title">Integer Vitae Libero</h2>
			<div class="featured-description">
				<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
			</div>
		</div>
		<a href="" class="featured-link">Read More</a>
	</article><!-- .featured -->	
</div>
