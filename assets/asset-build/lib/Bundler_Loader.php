<?php
/**
 * Make it easy to enqueue Bundler bundles in WordPress
 * Unlike the Bundler class, which is designed to be run anywhere, this class requires WordPress.
 * @uses wp_enqueue_script
 * @uses wp_enqueue_style
 * @uses Bundler
 * @uses Bundle
 * @uses Bundle_Item
 */
class Bundler_Loader {
	protected $asset_url_prefix;
	protected $default_ver;
	protected $build_profiles;
	
	public function __construct($asset_url_prefix = '', $build_profiles = array()) {
		if (!count($build_profiles) || !is_array($build_profiles)) {
			$this->build_profiles = Bundler::$build_profiles;
		}
		else {
			$this->build_profiles = $build_profiles;
		}
		$this->asset_url_prefix = Bundler::add_trailing_slash($asset_url_prefix);
	}
	
	public function set_default_ver($ver = '1.0') {
		$this->default_ver = (string) $ver;
		return $this;
	}
	
	protected function enqueue($language, $key, $path, $dependencies, $ver = null) {
		$ver = ($ver ? $ver : $this->default_ver);
		switch($language) {
			case 'javascript':
				wp_enqueue_script($key, $path, $dependencies, $ver);
				break;
			case 'css':
				wp_enqueue_style($key, $path, $dependencies, $ver);
				break;
		}
	}
	
	public function get_all_bundles() {
		$bundles = array();
		foreach ($this->build_profiles as $bundler) {
			foreach($bundler->get_bundles() as $bundle) {
				$bundles[] = $bundle;
			}
		}
		return $bundles;
	}
	
	public function enqueue_bundled_files() {
		foreach ($this->get_all_bundles() as $bundle) {
			$this->enqueue(
				$bundle->get_language(),
				$bundle->get_bundle_key(),
				$this->asset_url_prefix . $bundle->get_bundled_path(),
				$bundle->get_meta('dependencies'),
				$bundle->get_meta('ver')
			);
		}
		return $this;
	}
	
	public function enqueue_original_files() {
		foreach ($this->get_all_bundles() as $bundle) {
			foreach($bundle->get_bundle_items() as $bundle_item) {
				$this->enqueue(
					$bundle->get_language(),
					$bundle_item->get_key(),
					$this->asset_url_prefix . $bundle_item->get_path(),
					$bundle->get_meta('dependencies'),
					$bundle->get_meta('ver')
				);
			}
		}
	}
}
?>