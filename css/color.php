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

// Include WordPress
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

?>

/** Header
 -------------------------------------------------- */
#header {
	background-color: <?php echo cf_kuler_color('darkest'); ?>;
}
#header .container {
	background-color: <?php echo cf_kuler_color('darkest'); ?>;
}
#header a {
	color: <?php echo cf_kuler_color('lightest'); ?>;
}
#header a:hover {
	color: <?php echo cf_kuler_color('medium'); ?>;
}
#header #nav-main li a {
	border-bottom: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
}
#header #nav-main li a.current,
#header #nav-main li a:hover {
	border-bottom: 3px solid <?php echo cf_kuler_color('dark'); ?>;
}


/** Masthead
 -------------------------------------------------- */
#masthead {
	background-color: <?php echo cf_kuler_color('dark'); ?>;
}
.featured {
	background-color: <?php echo cf_kuler_color('darkest') ?>;
	border: 5px solid <?php echo cf_kuler_color('darkest') ?>;
}
.featured-title a {
	background-color: <?php echo cf_kuler_color('darkest') ?>;
	color: <?php echo cf_kuler_color('lightest') ?>;
}
.featured-content {
	color:<?php echo cf_kuler_color('lightest') ?>;
	min-height: 170px;
	padding: 45px 12px 0 12px;
	z-index: 9;
}

/* rollover */
.featured:hover {
	background-color: <?php echo cf_kuler_color('medium') ?>;
	border: 5px solid <?php echo cf_kuler_color('medium') ?>;
}
.featured:hover .featured-title a {
	background-color: <?php echo cf_kuler_color('medium') ?>;
	color: <?php echo cf_kuler_color('darkest') ?>;
}
.featured:hover .featured-content {
	color:<?php echo cf_kuler_color('dark') ?>;
}
.has-featured-img:hover .featured-content {
	color:<?php echo cf_kuler_color('lightest') ?>;
	background-color: rgba(<?php echo_hex(cf_kuler_color('dark')); ?>.75);
}


/** Post
 -------------------------------------------------- */
.post-title {
	color: <?php echo cf_kuler_color('dark'); ?>;			
}
.post-meta a {
	color: #999;
}
.post-meta a:hover {
	color: <?php echo cf_kuler_color('darkest'); ?>;
}


/** Sidebar
 -------------------------------------------------- */
.bio-box {
	background-color: <?php echo cf_kuler_color('medium'); ?>;	
	color: <?php echo cf_kuler_color('darkest'); ?>;
}
.bio-box a {
	color: <?php echo cf_kuler_color('darkest'); ?>;
}
.bio-box a:hover {
	color: <?php echo cf_kuler_color('darkest'); ?>;				
}
.widget-title {
	color: <?php echo cf_kuler_color('dark'); ?>;
	background-color: <?php echo cf_kuler_color('light'); ?>;
}


/** Footer
 -------------------------------------------------- */
#footer {
	background-color: <?php echo cf_kuler_color('dark'); ?>;
	color: <?php echo cf_kuler_color('darkest'); ?>;
}
#footer a {
	color: <?php echo cf_kuler_color('darkest'); ?>;
}
#footer a:hover {
	color: <?php echo cf_kuler_color('medium'); ?>;
}