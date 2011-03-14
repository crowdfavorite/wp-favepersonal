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
	<aside class="bio-box">
		<div class="bio-box-gallery">
			<img src="<?php bloginfo('template_url'); ?>/img/fpo-bio-img.jpg" width="310" height="205" alt="Fpo Bio Img">
		</div>
		<div class="bio-box-content">
			<h2 class="bio-box-title">About Carrington Personal</h2>
			<p>Lorem ipsum dolor sit amet sed do <a href="#">eiusmod tempor</a> incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
		</div>
		<div class="bio-box-links clearfix">
			<ul>
				<li><a href="http://twitter.com" title="Twitter"><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="Facebook"><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="Flickr"><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="Delicious"><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
				<li><a href="" title="and more..."><img src="<?php bloginfo('template_url'); ?>/img/fpo-favicon.png" width="16" height="16" alt="Fpo Favicon"></a></li>
			</ul>			
		</div>
	</aside>
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
