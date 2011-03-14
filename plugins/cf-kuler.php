<?php

/*
Plugin Name: Kuler Test Script 
Description: testing...
Version: dev 
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/


/* TODO

- manual override on a per color basis

*/


/* Let's load some styles that will be used on all theme setting pages */
add_action('admin_head', 'cfcp_admin_css');
function cfcp_admin_css() {
    $cfcp_admin_styles = get_bloginfo('template_url').'/plugins/css/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $cfcp_admin_styles . '" />';
}


define('CF_KULER_ITEMS_PER_PAGE', 10);
define('CF_KULER_COLORS', 'cf_kuler_colors');

if (!function_exists('cf_sort_hex_colors')) {
	function cf_sort_hex_colors($colors) {
		$map = array(
			'0' => 0,
			'1' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
			'7' => 7,
			'8' => 8,
			'9' => 9,
			'a' => 10,
			'b' => 11,
			'c' => 12,
			'd' => 13,
			'e' => 14,
			'f' => 15,
		);
		$c = 0;
		$sorted = array();
		foreach ($colors as $color) {
			$color = strtolower(str_replace('#', '', $color));
			if (strlen($color) == 6) {
				$condensed = '';
				$i = 0;
				foreach (preg_split('//', $color, -1, PREG_SPLIT_NO_EMPTY) as $char) {
					if ($i % 2 == 0) {
						$condensed .= $char;
					}
					$i++;
				}
				$color_str = $condensed;
			}
			$value = 0;
			foreach (preg_split('//', $color_str, -1, PREG_SPLIT_NO_EMPTY) as $char) {
				$value += intval($map[$char]);
			}
			$value = str_pad($value, 5, '0', STR_PAD_LEFT);
			$sorted['_'.$value.$c] = '#'.$color;
			$c++;
		}
		ksort($sorted);
		return $sorted;
	}
}

function cf_kuler_color($key = 'darkest') {
	$color = '';
	if ($colors = get_option(CF_KULER_COLORS)) {
		switch ($key) {
			case 'darkest':
				$color = $colors[0];
				break;
			case 'dark':
				$color = $colors[1];
				break;
			case 'medium':
				$color = $colors[2];
				break;
			case 'light':
				$color = $colors[3];
				break;
			case 'lightest':
				$color = $colors[4];
				break;
		}
	}
	return $color;
}

function cf_kuler_api_get($listType = 'rating', $startIndex = 0, $itemsPerPage = 20) {
	$url = 'http://kuler-api.adobe.com/rss/get.cfm';
	$params = compact('listType', 'startIndex', 'itemsPerPage');
	return cf_kuler_api_request($url.'?'.http_build_query($params));
}

function cf_kuler_api_search($searchQuery, $startIndex = 0, $itemsPerPage = 20) {
	$url = 'http://kuler-api.adobe.com/rss/search.cfm';
	$params = compact('searchQuery', 'startIndex', 'itemsPerPage');
	return cf_kuler_api_request($url.'?'.http_build_query($params));
}

function cf_kuler_api_request($url) {
	$kuler_key = '2931428E4D8D5DBE3EFC8D1040A9ACB0';
	$url .= '&key='.$kuler_key;

	require(ABSPATH.WPINC.'/class-simplepie.php');
	$feed = new SimplePie();
	$feed->enable_cache(false);
	$feed->set_feed_url($url);
	$feed->init();

	$namespace = 'http://kuler.adobe.com/kuler/API/rss/';
	$themes = array();
	foreach ($feed->get_items() as $item) {
		$data = $item->get_item_tags($namespace, 'themeItem');
		$data = $data[0]['child'][$namespace];
		$id = $data['themeID'][0]['data'];
		$theme = array(
			'id' => $id,
			'title' => $data['themeTitle'][0]['data'],
			'url' => 'http://kuler.adobe.com/#themeID/'.$id,
			'image' => $data['themeImage'][0]['data'],
			'swatches' => array()
		);
		foreach ($data['themeSwatches'][0]['child'][$namespace]['swatch'] as $swatch) {
			$theme['swatches'][] = $swatch['child'][$namespace]['swatchHexColor'][0]['data'];
		}
		$theme['swatches'] = cf_sort_hex_colors($theme['swatches']);
		if (count($theme['swatches']) == 5) {
			$themes[cf_kuler_theme_hash($theme)] = $theme;
		}
	}
	return $themes;
}

function cf_kuler_theme_hash($theme) {
	$swatches = cf_sort_hex_colors($theme['swatches']);
// concat as string
	$str = '';
	foreach ($swatches as $swatch) {
		$str .= $swatch;
	}
// hash
	return md5($str);
}

function cf_kuler_themes_html($themes) {
	$html = '';
	if (count($themes)) {
		foreach ($themes as $theme) {
			$html .= cf_kuler_theme_html($theme);
		}
	}
	return $html;
}

function cf_kuler_theme_html($theme) {
	$html = '
<div class="cf-kuler-theme" data-swatches="'.implode(',', $theme['swatches']).'">
	<p><a href="'.$theme['url'].'">'.$theme['title'].'</a> <em>by User Name</em></p>
	<ul>
	';
	foreach ($theme['swatches'] as $color) {
		$html .= '
		<li style="background-color: '.$color.';"></li>
		';
	}
	$html .= '
	</ul>
</div>
	';
	return $html;
}

function cf_kuler_colors_html($colors) {
	$html = '
<div class="cf-kuler-theme" data-swatches="'.implode(',', $colors).'">
	<ul>
	';
	foreach ($colors as $color) {
		$html .= '
		<li style="background-color: '.$color.';"></li>
		';
	}
	$html .= '
	</ul>
	<p><a href="#link-me">Enter Theme Name</a> <em>by User Name</em></p>
</div>
	';
	return $html;
}

function cf_kuler_admin_js() {
?>
<script type="text/javascript">
jQuery(function($) {
	$('#cf-kuler-menu a').click(function(e) {
		$('#cf-kuler-menu a').removeClass('current');
		$(this).addClass('current');
		$swatches = $('#cf-kuler-swatch-selector');
		$swatches.html('<div>Loading...</div>');
		$.post(
			ajaxurl,
			{
				'action': 'cf_kuler',
				'request': $(this).attr('data-request'),
				'listType': $(this).attr('data-listtype'),
				'startIndex': $(this).attr('data-start'),
				'itemsPerPage': $(this).attr('data-items')
			},
			function(response) {
				$swatches.html(response);
			},
			'html'
		);
		e.preventDefault();
	});
	$('#cf-kuler-search-form').submit(function(e) {
		$swatches = $('#cf-kuler-swatch-selector');
		$swatches.html('<div>Loading...</div>');
		$.post(
			ajaxurl,
			{
				'action': 'cf_kuler',
				'request': 'search',
				'searchQuery': $(this).find('#cf_kuler_search').val(),
				'startIndex': $(this).attr('data-start'),
				'itemsPerPage': $(this).attr('data-items')
			},
			function(response) {
				$swatches.html(response);
			},
			'html'
		);
		e.preventDefault();
	});
	$('a.cf-kuler-paging').live('click', function(e) {
		$swatches = $('#cf-kuler-swatch-selector');
		$swatches.html('<div>Loading...</div>');
		$.post(
			ajaxurl,
			{
				'action': 'cf_kuler',
				'request': $(this).attr('data-request'),
				'listType': $(this).attr('data-listtype'),
				'searchQuery': $(this).attr('data-search'),
				'startIndex': $(this).attr('data-start'),
				'itemsPerPage': $(this).attr('data-items')
			},
			function(response) {
				$swatches.html(response);
			},
			'html'
		);
		e.preventDefault();
	});
	$('#cf-kuler-swatch-selector .cf-kuler-theme li').live('click', function(e) {
// select swatch
		$selected = $('#cf-kuler-swatch-selected');
		$selected.html('');
		$theme = $(this).closest('.cf-kuler-theme');
		$theme.clone().find('p').remove().end().appendTo($selected);
// populate hidden field
// show save button
		$('#cf_kuler_settings_form')
			.find('#cf_kuler_colors').val($theme.attr('data-swatches')).end()
			.find('input[type=submit]').show().end();
		e.preventDefault();
	});
});
</script>
<?php
}

if (is_admin() && $_GET['page'] == basename(__FILE__)) {
	add_action('admin_head', 'cf_kuler_admin_js');
}

function cf_kuler_admin_ajax() {
	if (isset($_POST['request'])) {
		$api_request_type = $_POST['request'];
	}
	else {
		$api_request_type = 'get';
	}
// params
	$params = array(
		'listType' => null,
		'startIndex' => 0,
		'itemsPerPage' => CF_KULER_ITEMS_PER_PAGE,
		'timeSpan' => null, // not currently in use
		'key' => null, // not currently in use
		'searchQuery' => null,
	);
	foreach ($params as $param => $v) {
		if (isset($_POST[$param])) {
			$params[$param] = stripslashes($_POST[$param]);
		}
	}
// execute search
	switch ($api_request_type) {
		case 'get':
			$themes = cf_kuler_api_get(
				$params['listType'], 
				$params['startIndex'], 
				$params['itemsPerPage']
			);
			break;
		case 'search':
			$themes = cf_kuler_api_search(
				$params['searchQuery'], 
				$params['startIndex'], 
				$params['itemsPerPage']
			);
			break;
		default:
			die();
			break;
	}
	$html = '<div class="cf-kuler-swatches cf-clearfix">'.cf_kuler_themes_html($themes).'</div>';

	$params['startIndex'] == 0 ? $prev_page = '' : $prev_page = '<a href="#" class="cf-kuler-paging prev" data-request="'.esc_attr($api_request_type).'" data-listtype="'.esc_attr($params['listType']).'" data-search="'.esc_attr($params['searchQuery']).'" data-start="'.esc_attr($params['startIndex'] - 1).'" data-items="'.esc_attr($params['itemsPerPage']).'">&laquo; '.__('previous', 'cf-kuler').'</a>';
	$next_page = '<a href="#" class="cf-kuler-paging next" data-request="'.esc_attr($api_request_type).'" data-listtype="'.esc_attr($params['listType']).'" data-search="'.esc_attr($params['searchQuery']).'" data-start="'.esc_attr($params['startIndex'] + 1).'" data-items="'.esc_attr($params['itemsPerPage']).'">'.__('next', 'cf-kuler').' &raquo;</a>';

	$html .= '<div class="cf-kuler-pagination">'.$next_page.$prev_page.'</div>';

	die($html);
}
add_action('wp_ajax_cf_kuler', 'cf_kuler_admin_ajax');

function cf_kuler_request_handler() {
	if (!empty($_POST['cf_action'])) {
		switch ($_POST['cf_action']) {
			case 'cf_kuler_update_settings':
				check_admin_referer('cf_kuler_update_settings');
				$colors = stripslashes($_POST['cf_kuler_colors']);
				$colors = explode(',', $colors);
				update_option(CF_KULER_COLORS, $colors);
				wp_redirect(admin_url('themes.php?page='.basename(__FILE__).'&updated=true'));
				die();
				break;
		}
	}
}
add_action('init', 'cf_kuler_request_handler');

function cf_kuler_admin_menu() {
	add_submenu_page(
		'themes.php',
		__('Color Settings', 'cf-kuler'),
		__('Colors', 'cf-kuler'),
		'manage_options',
		basename(__FILE__),
		'cf_kuler_settings_form'
	);
}
add_action('admin_menu', 'cf_kuler_admin_menu');

function cf_kuler_settings_form() {
	if ($colors = get_option(CF_KULER_COLORS)) {
		$colors_html = cf_kuler_colors_html($colors);
	}
	else {
		$colors_html = '';
	}
	
	print('
<div class="wrap">
	<h2>'.__('Color Settings', 'cf-kuler').'</h2>
	<div class="cfcp-section">
		<h3 class="cfcp-section-title"><span>'.__('Selected Theme', 'cf-kuler').'</span></h3>
		<div id="cf-kuler-swatch-selected" class="cf-clearfix">
			'.$colors_html.'
		</div>
		<form id="cf_kuler_settings_form" name="cf_kuler_settings_form" action="'.admin_url('themes.php').'" method="post">
			<input type="hidden" name="cf_action" value="cf_kuler_update_settings" />
			<input type="hidden" name="cf_kuler_colors" id="cf_kuler_colors" value="" />
			<p>
				<input type="button" name="preview_button" value="'.__('Preview', 'cf-kuler').'" class="button" />
				<input type="submit" name="submit_button" value="'.__('Save Settings', 'cf-kuler').'" class="button-primary" />
			</p>
		');
		wp_nonce_field('cf_kuler_update_settings');
		print('
		</form>
	</div><!-- .cfcp-section -->

	<div class="cfcp-section">
		<h3 class="cfcp-section-title"><span>'.__('Browse Kuler Colors', 'cf-kuler').'</span></h3>
		<div class="cfcp-nav">
			<form action="#" id="cf-kuler-search-form" data-start="0" data-page="'.CF_KULER_ITEMS_PER_PAGE.'">
				<input type="text" name="cf_kuler_search" id="cf_kuler_search" />
				<input type="submit" class="button" name="" value="Search Colors" />
			</form>
			<ul id="cf-kuler-menu">
				<li><a href="#" data-request="get" data-listtype="popular" data-start="0" data-items="'.CF_KULER_ITEMS_PER_PAGE.'">'.__('Most Popular', 'cf-kuler').'</a></li>
				<li><a href="#" data-request="get" data-listtype="rating" data-start="0" data-items="'.CF_KULER_ITEMS_PER_PAGE.'">'.__('Highest Rated', 'cf-kuler').'</a></li>
				<li><a href="#" data-request="get" data-listtype="recent" data-start="0" data-items="'.CF_KULER_ITEMS_PER_PAGE.'">'.__('Newest', 'cf-kuler').'</a></li>
				<li><a href="#" data-request="get" data-listtype="random" data-start="0" data-items="'.CF_KULER_ITEMS_PER_PAGE.'">'.__('Random', 'cf-kuler').'</a></li>
			</ul>		
		</div>
		<div id="cf-kuler-swatch-selector">
		</div>
	</div><!-- .cfcp-section -->
</div>
	');
}

function cf_kuler_update_settings() {
	if (!current_user_can('manage_options')) {
		return;
	}
// update options
}

/* API endpoints

rss/get.cfm?listType=[listType]&startIndex=[startIndex]&itemsPerPage=[itemsPerPage]&timeSpan=[timeSpan]&key=[key]

Get highest-rated feeds
http://kuler-api.adobe.com/rss/get.cfm?listtype=rating

Get most popular feeds for the last 30 days
http://kuler-api.adobe.com/rss/get.cfm?listtype=popular&timespan=30

Get most recent feeds
http://kuler-api.adobe.com/rss/get.cfm?listtype=recent


rss/search.cfm?searchQuery=[searchQuery]&startIndex=[startIndex]&itemsPerPage=[itemsPerPage]&key=[key]

Search for themes with the word "blue" in the name, tags, user name, etc.
http://kuler-api.adobe.com/rss/search.cfm?searchQuery=blue

Search for themes tagged as "sunset"
http://kuler-api.adobe.com/rss/search.cfm?searchQuery=tag:sunset

*/

//a:23:{s:11:"plugin_name";N;s:10:"plugin_uri";N;s:18:"plugin_description";N;s:14:"plugin_version";N;s:6:"prefix";s:8:"cf_kuler";s:12:"localization";N;s:14:"settings_title";s:14:"Color Settings";s:13:"settings_link";s:6:"Colors";s:4:"init";b:0;s:7:"install";b:0;s:9:"post_edit";b:0;s:12:"comment_edit";b:0;s:6:"jquery";b:0;s:6:"wp_css";b:0;s:5:"wp_js";b:0;s:9:"admin_css";s:1:"1";s:8:"admin_js";s:1:"1";s:8:"meta_box";b:0;s:15:"request_handler";b:0;s:6:"snoopy";b:0;s:11:"setting_cat";b:0;s:14:"setting_author";b:0;s:11:"custom_urls";b:0;}
