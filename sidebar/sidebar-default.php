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

?>

<div id="sidebar-1">
	<?php if (!dynamic_sidebar('sidebar-section-1')) { ?>
		<aside class="widget">
			<h3 class="widget-title">Archives</h3>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul> 
		</aside>
		<aside class="widget">
			<h3 class="widget-title">Meta</h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
	<?php } ?>
</div><!-- #sidebar-1 -->
<div id="sidebar-2">
	<?php if (!dynamic_sidebar('sidebar-section-2')) {
		// default content here is desired
	} ?>
</div><!-- #sidebar-2 -->
<div id="sidebar-3">
	<?php if (!dynamic_sidebar('sidebar-section-3')) { 
		// default content here is desired
	} ?>
</div><!-- #sidebar-3 -->
