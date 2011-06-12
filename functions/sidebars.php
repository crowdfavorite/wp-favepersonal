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
		'name' => __('Sidebar Section One', 'favepersonal'),
		'description' => __('Top section in sidebar, first column in footer.', 'favepersonal')
	)));
	
	register_sidebar(array_merge($sidebar_defaults, array(
		'id' => 'sidebar-section-2',
		'name' => __('Sidebar Section Two', 'favepersonal'),
		'description' => __('Middle section in sidebar, second column in footer.', 'favepersonal')
	)));
	
	register_sidebar(array_merge($sidebar_defaults, array(
		'id' => 'sidebar-section-3',
		'name' => __('Sidebar Section Three', 'favepersonal'),
		'description' => __('Bottom section in sidebar, third column in footer.', 'favepersonal')
	)));
	
}

add_action( 'widgets_init', 'cfct_widgets_init' );

?>