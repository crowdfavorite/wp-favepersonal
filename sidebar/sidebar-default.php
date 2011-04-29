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
		<h5><?php _e('No Widgets Yet!', 'carrington-personal'); ?></h5>
		<p><?php printf(__('It looks like you haven&rsquo;t added any widgets to this sidebar yet. To customize this sidebar (Sidebar Section One), go <a href="%s">add some</a>!', 'carrington-personal'), admin_url('widgets.php')); ?></p>
	</aside>
	<?php } ?>
</div><!-- #sidebar-1 -->
<div id="sidebar-2">
	<?php if (!dynamic_sidebar('sidebar-section-2')) { ?>
	<aside class="widget">
		<h5><?php _e('No Widgets Yet!', 'carrington-personal'); ?></h5>
		<p><?php printf(__('It looks like you haven&rsquo;t added any widgets to this sidebar yet. To customize this sidebar (Sidebar Section Two), go <a href="%s">add some</a>!', 'carrington-personal'), admin_url('widgets.php')); ?></p>
	</aside>
	<?php } ?>
</div><!-- #sidebar-2 -->
<div id="sidebar-3">
	<?php if (!dynamic_sidebar('sidebar-section-3')) { ?>
	<aside class="widget">
		<h5><?php _e('No Widgets Yet!', 'carrington-personal'); ?></h5>
		<p><?php printf(__('It looks like you haven&rsquo;t added any widgets to this sidebar yet. To customize this sidebar (Sidebar Section Three), go <a href="%s">add some</a>!', 'carrington-personal'), admin_url('widgets.php')); ?></p>
	</aside>
	<?php } ?>
</div><!-- #sidebar-3 -->
