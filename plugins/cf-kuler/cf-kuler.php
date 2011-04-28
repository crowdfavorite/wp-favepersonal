<?php

/*
Plugin Name: CF Colors 
Description: Selection of color swatches from Adobe Kuler.
Version: dev 
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/


/* TODO

- Manual override on a per color basis
- Hook up preview window, HTML in place
- Add in usernames for color themes
- On selected color, if it's been customized it will "Custom Theme by..." wordpress username

*/

define('CF_KULER_VERSION', '0.8');
define('CF_KULER_ITEMS_PER_PAGE', 8);
define('CF_KULER_COLORS', 'cf_kuler_colors');
define('CF_KULER_API', 'http://colors.api.crowdfavorite.com/1.0/?url={URL}');

function cfcp_admin_init() {
	if (!empty($_GET['page']) && $_GET['page'] == basename(__FILE__)) {
		add_action('admin_head', 'cfcp_admin_css');
		add_action('admin_head', 'cfcp_admin_scrolljs');
		
		$plugin_dir = trailingslashit(get_template_directory_uri()).'plugins/'.basename(__FILE__, '.php');
		
		// colorpicker version is the last entry date from the changelog since it doesn't appear to have a version defined
		wp_enqueue_script('jquery-colorpicker', $plugin_dir.'/js/colorpicker/js/colorpicker.js', array('jquery'), '20090523');
		wp_enqueue_style('jquery-colorpicker', $plugin_dir.'/js/colorpicker/css/colorpicker.css', array(), '20090523', 'screen');
		
		// our kuler js
		$css_preview_template = sprintf(cfcp_admin_preview_css_template(), '-0-', '-1-', '-2-', '-3-', '-4-');
		$css_preview_template = preg_replace("/[\n|\t]/", '', $css_preview_template);
		wp_enqueue_script('cf-kuler', $plugin_dir.'/js/cf-kuler.js', array('jquery', 'colorpicker', 'jquery-ui-sortable'), CF_KULER_VERSION);
		wp_localize_script('cf-kuler', 'cf_kuler_settings', array(
			'preview_css_template' => $css_preview_template
		));	
	}
}
add_action('admin_init', 'cfcp_admin_init');

/* Let's load some styles that will be used on all theme setting pages */
function cfcp_admin_css() {
    $cfcp_admin_styles = get_bloginfo('template_url').'/plugins/cf-kuler/css/admin.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $cfcp_admin_styles . '" />';
	echo cfcp_admin_preview_css();
}

function cfcp_admin_preview_css() {
	return sprintf(cfcp_admin_preview_css_template(),
	 	cf_kuler_color('darkest'),
		cf_kuler_color('dark'),
		cf_kuler_color('medium'),
		cf_kuler_color('light'),
		cf_kuler_color('lightest')
	);
}

function cfcp_admin_preview_css_template() {
	return '
		<style type="text/css" media="screen" title="kuler-preview-css">
			.cf-kuler-preview-header, 
			.cf-kuler-preview-featured {
				background-color: %s;
			}
			.cf-kuler-preview-masthead,
			.cf-kuler-preview-footer {
				background-color: %s;
			}
			.cf-kuler-preview-bio {
				background-color: %s;
			}
			.cf-kuler-preview-widget {
				background-color: %s;
			}
			.cf-kuler-preview-logo,
			.cf-kuler-preview-link li {
				background-color: %s;
			}
		</style>';
}

/* Now load some extra JS */
function cfcp_admin_scrolljs() {
    $cfcp_admin_scroll = get_bloginfo('template_url').'/js/jquery.scrollTo-1.4.2-min.js';
    echo '<script type="text/javascript" src="' . $cfcp_admin_scroll . '"></script>';
}

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
	if ($colors = cf_kuler_get_colors()) {
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

function cf_kuler_get_colors() {
	$settings = cf_kuler_get_settings();
	return apply_filters('cf-kuler-colors', $settings['colors']);
}

function cf_kuler_get_settings() {
	return get_option(CF_KULER_COLORS, array(
		'colors' => array(
			'#223366',
            '#556699',
            '#8899cc',
            '#d3d3f7',
            '#ffffff'
		),
		'theme' => array(
			'id' => 1248653,
            'guid' => 'http://kuler.adobe.com/index.cfm#themeID/1248653',
            'link' => 'http://kuler.adobe.com/index.cfm#themeID/1248653',
            'title' => 'alexking.org',
            'author' => 'alexkingorg',
            'author_id' => '383498',
            'image' => 'http://kuler-api.adobe.com/kuler/themeImages/theme_1248653.png',
            'swatches' => '#223366,#556699,#8899cc,#d3d3f7,#ffffff'
		)
	));
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
	require(ABSPATH.WPINC.'/class-simplepie.php');
	$feed = new SimplePie();
	$feed->enable_cache(false);
	$feed->set_feed_url(str_replace('{URL}', urlencode($url), CF_KULER_API));
	$feed->init();

	$namespace = 'http://kuler.adobe.com/kuler/API/rss/';
	$themes = array();
	foreach ($feed->get_items() as $item) {
		$data = $item->get_item_tags($namespace, 'themeItem');
		$data = $data[0]['child'][$namespace];
		$id = $data['themeID'][0]['data'];
		$theme = array(
			'id' => $id,
			'guid' => $item->get_id(),
			'link' => $item->get_link(),
			'title' => $data['themeTitle'][0]['data'],
			'url' => 'http://kuler.adobe.com/#themeID/'.$id, // for some reason this triggers a search on kuler.com instead of linking directly to the theme
			'image' => $data['themeImage'][0]['data'],
			'swatches' => array(),
			'author' => $data['themeAuthor'][0]['child'][$namespace]['authorLabel'][0]['data'],
			'author_id' => $data['themeAuthor'][0]['child'][$namespace]['authorID'][0]['data']
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
	$signature = md5(serialize($theme));
	$html = '
		<div class="cf-kuler-theme" data-swatches="'.implode(',', $theme['swatches']).'">
			'.cf_kuler_theme_fields($theme).'
			<p class="cf-kuler-theme-description">'.cf_kuler_theme_desc($theme).'</p>
			'.cf_kuler_colors_list($theme['swatches']).'
			<div class="cf-kuler-theme-actions">
				<p><a id="select-'.$signature.'" href="#selected-theme" class="button cf-kuler-apply">'.__('Select', 'cf-kuler').'</a></p>
				<p><a id="preview-'.$signature.'" href="#preview-me" class="button cf-kuler-apply-preview">'.__('Preview', 'cf-kuler').'</a></p>
			</div>
		</div>
	';
	return $html;
}

function cf_kuler_colors_html($settings) {
	extract($settings); // extracts $colors & $theme
	$html = '
		<div class="cf-kuler-theme" data-swatches="'.implode(',', $colors).'">
			'.cf_kuler_colors_list($colors).'
			<p id="cf-kuler-theme-description" class="cf-kuler-theme-description">'.cf_kuler_theme_desc($theme, ($theme['swatches'] != implode(',', $colors))).'</p>
		</div>
	';
	return $html;
}

function cf_kuler_colors_list($colors) {
	$html = '
		<ul>';
	foreach ($colors as $color) {
		$html .= '
			<li style="background-color: '.$color.';"><a class="cf-kuler-theme-edit-swatch" href="#">'.__('edit', 'cf-kuler').'</a></li>';
	}
	$html .= '
		</ul>';
	return $html;
}

function cf_kuler_theme_desc($theme, $modified = false) {
	return ($modified ? __('Based on', 'cf-kuler').' ' : '').'<a href="'.$theme['link'].'">'.$theme['title'].'</a> <em>'.__('by', 'cf-kuler').' '.$theme['author'].'</em>';
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

/**
 * Grab the CSS output for altering the theme colors preview
 *
 * @return void
 */
function cf_kuler_admin_preview_css() {
	add_filter('cf-kuler-colors', 'cf_kuler_colors_ajax_filter');
	$response = array(
		'success' => true,
		'css' => cfcp_admin_preview_css()
	);
	header('content-type: text/javascript');
	echo json_encode($response);
	exit;
}
add_action('wp_ajax_cf_kuler_preview_css', 'cf_kuler_admin_preview_css');

/**
 * Filter in new colors passed in via ajax
 * Will ignore any passed in fields that contain more data than a full HEX color definition
 * so hacking will return a weird color set, but won't damage anything
 *
 * @param array $colors 
 * @return array
 */
function cf_kuler_colors_ajax_filter($colors) {
	if (!empty($_POST['cf_kuler_colors'])) {
		$_colors = explode(',', $_POST['cf_kuler_colors']);		
		array_map('trim', $_colors);
		foreach ($_colors as $k => $color) {
			if (preg_match('/^#[a-z0-9]{6}$/i', $color)) {
				$colors[$k] = $color;
			}
		}
	}
	return $colors;
}

function cf_kuler_request_handler() {
	if (!empty($_POST['cf_action'])) {
		switch ($_POST['cf_action']) {
			case 'cf_kuler_update_settings':
				check_admin_referer('cf_kuler_update_settings');
				$colors = explode(',', stripslashes($_POST['cf_kuler_colors']));
				$theme = array_map('stripslashes', $_POST['cf_kuler_theme']);
				update_option(CF_KULER_COLORS, compact('colors','theme'));
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

function cf_kuler_admin_bar() {
	global $wp_admin_bar;
	if (current_user_can('manage_options')) {
		$wp_admin_bar->add_menu(array(
			'id' => 'cf-kuler',
			'title' => __('Colors', 'cf-kuler'),
			'href' => admin_url('themes.php?page='.basename(__FILE__)),
			'parent' => 'appearance'
		));
	}
}
add_action('wp_before_admin_bar_render', 'cf_kuler_admin_bar');

function cf_kuler_theme_fields($theme) {
	return '
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[id]" value="'.$theme['id'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[guid]" value="'.$theme['guid'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[link]" value="'.$theme['link'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[title]" value="'.$theme['title'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[author]" value="'.$theme['author'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[author_id]" value="'.$theme['author_id'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[image]" value="'.$theme['image'].'" /> 
	<input class="cf-kuler-theme-data" type="hidden" name="cf_kuler_theme[swatches]" value="'.(is_array($theme['swatches']) ? implode(',', $theme['swatches']) : $theme['swatches']).'" />';
}

function cf_kuler_settings_form() {
	if ($settings = cf_kuler_get_settings()) {
		$colors = implode(',', $settings['colors']);
		$colors_html = cf_kuler_colors_html($settings);
	}
	else {
		$colors = '';
		$colors_html = '';
	}

	$message = '';
	if (!empty($_GET['updated']) && $_GET['updated'] == true) {
		$message = '<div class="updated below-h2 fade cf-kuler-message-fade" id="message"><p>'.__('Settings updated.', 'cf-kuler').'</p></div>';
	}
	
	print('
<div class="wrap cf-kuler-wrap cf-clearfix">
	<h2>'.__('Color Settings', 'cf-kuler').'</h2>
	'.$message.'
	<div class="cfcp-section">
		<h3 id="selected-theme" class="cfcp-section-title"><span>'.__('Selected Theme', 'cf-kuler').'</span></h3>
		<div id="cf-kuler-swatch-selected" class="cf-clearfix">
			'.$colors_html.'
		</div>
		<div id="cf-kuler-color-picker" style="display: none;">
			<p>'.__('Pick a new color:', 'cf-kuler').'</p>
			<p>'.__('Or select from original theme colors:', 'cf-kuler').'</p>
			<div class="theme-swatches">
				<div class="theme-swatches-container">
					'.$colors_html.'
				</div>
			</div>
		</div>
		<form id="cf_kuler_settings_form" name="cf_kuler_settings_form" action="'.admin_url('themes.php').'" method="post">
			<input type="hidden" name="cf_action" value="cf_kuler_update_settings" />
			<input type="hidden" name="cf_kuler_colors" id="cf_kuler_colors" value="'.$colors.'" />
			<div id="cf-kuler-theme-info">
				');
	if (!empty($settings['theme'])) {
		echo cf_kuler_theme_fields($settings['theme']);
	}
	print('
			</div>
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
				<input type="submit" class="button" name="" value="'.__('Search Colors', 'cf-kuler').'" />
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

<div id="cf-kuler-preview" style="display: none;">
	<div class="cf-kuler-preview-page">
		<div class="cf-kuler-preview-header">
			<div class="cf-kuler-preview-logo"></div>
			<ul class="cf-kuler-preview-link">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
		<div class="cf-kuler-preview-masthead">
			<div class="cf-kuler-preview-featured"></div>
			<div class="cf-kuler-preview-featured"></div>
			<div class="cf-kuler-preview-featured"></div>			
		</div>
		<div class="cf-kuler-preview-sidebar">
			<div class="cf-kuler-preview-bio"></div>
			<div class="cf-kuler-preview-widget"></div>
			<div class="cf-kuler-preview-widget"></div>
		</div>
		<div class="cf-kuler-preview-footer"></div>
		</div><!--.cf-kuler-preview-page-->
</div><!--#cf-kuler-preview-->
<script type="text/javascript">
	jQuery(function($) {
		$("#cf-kuler-menu li:first-child a").trigger("click");
	});
</script>
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
