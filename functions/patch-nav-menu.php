<?php
class CF_Patch_Nav_Menu {
	public $fallback_cb = null;
	public $wp_page_menu_default_args = array(
		'menu_class' => 'menu-class',
		'container' => 'div'
	);
	
	public function __construct() {
		$this->fallback_cb = array($this, 'page_menu');
	}
	
	/**
	 * Run this once after instantiating.
	 */
	public function attach_hooks() {
		add_filter('wp_page_menu_args', array($this, 'wp_page_menu_args'));
		add_filter('wp_nav_menu_args', array($this, 'wp_nav_menu_args'));
	}
	
	public function wp_nav_menu_args($args) {
		// If using the default fallback_cb, change to the shimmed fallback cb we have in this class.
		if ($args['fallback_cb'] == 'wp_page_menu') {
			$args['fallback_cb'] = $this->fallback_cb;
		}
		return $args;
	}
	
	/**
	 * Take care of delta between argument names in wp_nav_menu vs wp_page menu
	 */
	public function wp_page_menu_args( $args ) {
		$args = array_merge($this->wp_page_menu_default_args, $args);
		// Show home if wp_page_menu is used as fallback
		$args['show_home'] = true;

		return $args;
	}

	/**
	 * Default fallback_cb, but filtered with new classnames and nav_menu_container
	 */
	public function page_menu($args) {
		add_filter('wp_page_menu', array($this, 'nav_menu_container'), 10, 2);
		add_filter('wp_page_menu', array($this, 'shim_classnames'), 10, 2);
		wp_page_menu($args);
		remove_filter('wp_page_menu', array($this, 'nav_menu_container'), 10, 2);
		remove_filter('wp_page_menu', array($this, 'shim_classnames'), 10, 2);
	}

	/**
	 * Reduce delta between markup output of wp_nav_menu and wp_page_menu
	 * Honor container setting for wp_nav_menu in wp_page_menu
	 */
	public function nav_menu_container($menu, $args) {
		// Build ID attr - we'll use it in a bit.
		$id = ($args['container_id'] ? ' id="'.$args['container_id'].'"' : '');
		
		/* Container arg is passed along by wp_nav_menu.
		
		menu_class in wp_page_menu maps to container_class in wp_nav_menu. We'll swap it and
		also reduce the markup delta

		String replacements are brittle, but it's all we have for now.
		Remove menu divs if there is no container specified AND this function has been called by
		our fallback callback. */
		if (!$args['container'] && $args['fallback_cb'] == $this->fallback_cb) {
			$menu = str_replace(array('<div class="'.$args['menu_class'].'">', "</div>\n"), '', $menu);
		}
		// If container is a nav tag, replace div with nav. Include ID, too.
		else if ($args['container'] == 'nav') {
			$menu = str_replace(array('<div class="'.$args['menu_class'].'">', "</div>\n"), array('<nav class="'.$args['container_class'].'" '.$id.'>', "</nav>\n"), $menu);
		}
		// If we have a container, make sure container ID is included
		else if ($args['container_id']) {
			$menu = str_replace('class="'.$args['menu_class'].'"', 'class="'.$args['container_class'].'"'.$id, $menu);
		}
		
		/* Shim classname/id on ul element */
		if ($args['menu_class'] || $args['menu_id']) {
			$id = ($args['menu_id'] ? ' id="'.$args['menu_id'].'"' : '');
			$classname = ($args['menu_class'] ? ' class="'.$args['menu_class'].'"' : '');
			// This is safe, because ul > ul has the class .children when output by wp_page_menu
			$menu = str_replace('<ul>', '<ul'.$classname.$id.'>', $menu);
		}
		
		return $menu;
	}

	/**
	 * Add the .sub-menu class to nested lists.
	 * This matches the classname used when wp_nav_menu is called
	 */
	public function shim_classnames($output, $r) {
		$needles = array(
			'class="children"',
			'class=\'children\''
		);
		$output = str_replace($needles, 'class="children sub-menu"', $output);
		$output = str_replace('current_page_item', 'current_page_item current-menu-item', $output);
		return $output;
	}
}
?>