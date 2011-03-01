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
$about_text = cfct_about_text();
if (!empty($about_text)) {
?>
	<div id="carrington-about" class="widget">
		<div class="about">
			<h2 class="title"><?php printf(__('About %s', 'carrington-text'), get_bloginfo('name')); ?></h2>
<?php
	echo $about_text;
?>
		</div>
	</div><!--.widget-->
	<hr class="divider" />
<?php
}
?>
	<div id="primary-sidebar">
<?php
$post = $orig_post;
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) {
?>
		<div class="widget">
			<h3 class="widget-title"><?php _e('Search', 'carrington-text'); ?></h3>
			<?php cfct_form('search'); ?>
		</div><!--.widget-->
		<div class="widget">
			<h3 class="widget-title"><?php _e('Pages', 'carrington-text'); ?></h3>
			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
		</div><!--.widget-->
		<div class="widget">
			<h3 class="widget-title"><?php _e('Categories', 'carrington-text'); ?></h2>
			<ul>
				<?php wp_list_cats(); ?>
			</ul>
		</div><!--.widget-->
		<div class="widget">
			<h3 class="widget-title"><?php _e('Tags', 'carrington-text'); ?></h3>
			<?php wp_tag_cloud('smallest=10&largest=18&unit=px'); ?>
		</div><!--.widget-->
		<div class="widget">
			<h3 class="widget-title"><?php _e('Archives', 'carrington-text'); ?></h3>
			<ul>
				<?php wp_get_archives(); ?>
			</ul>
		</div><!--.widget-->
		<div class="widget under meta">
			<?php wp_register('<p>', '</p>'); ?> 
			<p><?php wp_loginout(); ?></p>
		</div><!--.widget-->

<?php
}
?>
	</div><!--#primary-sidebar-->
</div><!--#sidebar-->
