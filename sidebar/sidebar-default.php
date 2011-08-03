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
<div id="sidebar-1" class="sidebar">
	<?php if (!dynamic_sidebar('sidebar-section-1')) { ?>
		<aside class="widget">
			<h3 class="widget-title"><?php _e('Archives', 'favepersonal'); ?></h3>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul> 
		</aside>
		<aside class="widget">
			<h3 class="widget-title"><?php _e('Meta', 'favepersonal'); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
	<?php } ?>
</div><!-- #sidebar-1 -->
<div id="sidebar-2" class="sidebar">
	<?php if (!dynamic_sidebar('sidebar-section-2')) {
		// default content here is desired
	} ?>
</div><!-- #sidebar-2 -->
<div id="sidebar-3" class="sidebar">
	<?php if (!dynamic_sidebar('sidebar-section-3')) { 
		// default content here is desired
	} ?>
</div><!-- #sidebar-3 -->
