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

<div id="sidebar">
	<?php
	if (!dynamic_sidebar('sidebar-default')) { ?>
	<aside class="widget">
		<h3 class="widget-title"><?php _e('No Widgets Yet!', 'carrington-personal'); ?></h3>
		<p><?php printf(__('It looks like you haven&rsquo;t added any widgets to this sidebar yet. To customize this sidebar (Default Sidebar), go <a href="%s">add some</a>!', 'carrington-personal'), admin_url('widgets.php')); ?></p>
	</aside>
	<?php
	}
	?>
</div><!--#sidebar-->
