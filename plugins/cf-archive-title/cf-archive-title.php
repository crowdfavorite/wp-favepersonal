<?php

// Copyright (c) 2010-2012 Crowd Favorite (http://crowdfavorite.com)
// Version 1.0
// License: GPL v2.0 - http://opensource.org/licenses/GPL-2.0

load_plugin_textdomain('cfpt');

function cfpt_get_page_title() {
	global $wp_locale;

	$messages = apply_filters('cfpt_messages', array(
		'home_paged' => __('Latest / <em>page %s</em>', 'cfpt'),
		'search' => __('Search results for <em>%s</em>', 'cfpt'),
		'tag' => __('Tag archives for <em>%s</em>', 'cfpt'),
		'category' => __('<em>%s</em> Archives', 'cfpt'),
		'taxonomy' => __('<em>%s</em> Archives', 'cfpt'),
		'post_format' => __('<em>%s</em> Archives', 'cfpt'),
		'post_type' => __('<em>%s</em> Archives', 'cfpt'),
		'author' => __('By <em>%s</em>', 'cfpt'),
		'date' => __('<em>%s</em>', 'cfpt')
	));

	$vars = array(
		'paged' => get_query_var('paged'),
		'cat' => get_query_var('cat'),
		'tag' => get_query_var('tag_id'),
		'post_format' => get_query_var('post_format'),
		's' => get_query_var('s'),
		'year' => get_query_var('year'),
		'm' => get_query_var('m'),
		'monthnum' => get_query_var('monthnum'),
		'day' => get_query_var('day'),
		'author' => get_query_var('author_name'),
		'is_tax' => get_query_var('is_tax')
	);
	// Keep things kosher
	$vars = array_map('esc_html', $vars);

	extract($vars);

	$output = '';

	if (is_front_page() && is_paged()) {
		$output = sprintf($messages['home_paged'], $paged);
	}
	else if (!empty($s)) {
		$output = sprintf($messages['search'], $s);
	}
	else if (!empty($tag)) {
		$output = sprintf($messages['tag'], single_tag_title('', false));
	}
	else if (!empty($cat)) {
		$output = sprintf($messages['category'], single_cat_title('', false));
	}
	else if (is_tax()) {
		$term = get_queried_object();
		$output = sprintf($messages['taxonomy'], esc_html($term->name));
	}
	else if (!empty($post_format)) {
		$output = sprintf($messages['post_format'], ucwords($post_format));
	}
	else if (!empty($author)) {
		$user = get_user_by('slug', $author);
		
		if (is_object($user)) {
			$output = sprintf($messages['author'], esc_html($user->display_name));
		}
	}
	else if (is_post_type_archive()) {
		$post_type_obj = get_queried_object();
		$output = sprintf($messages['post_type'], $post_type_obj->labels->singular_name);
	}
	else if (is_archive() && !empty($year)) {
		$date = '';
		if (!empty($monthnum)) {
			$date .= $wp_locale->get_month($monthnum);
			if (!empty($day)) {
				$date .= ' ' . $day;
			}
			$date .= ', ';
		}
		$date .= $year;
		$output = sprintf($messages['date'], $date);
	}

	return $output;
}

function cfpt_page_title($before = '', $after = '') {
	if ($title = cfpt_get_page_title()) {
		echo $before . $title . $after;
	}
}
