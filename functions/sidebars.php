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

/**
 * Register widgetized areas
 * @uses register_sidebar
 */
function cfct_widgets_init() {
	$sidebar_defaults = array(
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	);

	register_sidebar(array_merge($sidebar_defaults, array(
		'id' => 'sidebar-section-1',
		'name' => __('Sidebar Section One', 'carrington-personal'),
		'description' => __('Top section in sidebar, first column in footer.', 'carrington-personal')
	)));
	
	register_sidebar(array_merge($sidebar_defaults, array(
		'id' => 'sidebar-section-2',
		'name' => __('Sidebar Section Two', 'carrington-personal'),
		'description' => __('Middle section in sidebar, second column in footer.', 'carrington-personal')
	)));
	
	register_sidebar(array_merge($sidebar_defaults, array(
		'id' => 'sidebar-section-3',
		'name' => __('Sidebar Section Three', 'carrington-personal'),
		'description' => __('Bottom section in sidebar, third column in footer.', 'carrington-personal')
	)));
	
}

add_action( 'widgets_init', 'cfct_widgets_init' );

?>