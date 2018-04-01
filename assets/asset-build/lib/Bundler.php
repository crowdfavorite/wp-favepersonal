<?php
/**
 * Combine files together. Hooray!
 */
class Bundler {
	/**
	 * Keeps a globally-accessible list of bundles that need to be built
	 */
	public static $build_profiles = array();
	protected $asset_path_prefix;
	protected $bundles = array();
	
	/**
	 * Constructor does not have public access - use factory to initialize
	 */ 
	protected function __construct($asset_path_prefix) {
		$this->asset_path_prefix = self::add_trailing_slash($asset_path_prefix);
	}
	
	/**
	 * Factory method. Use this to create a new Bundler.
	 */
	public static function create($asset_path_prefix = '') {
		$ins = new Bundler($asset_path_prefix);
		
		// Add to $build_profiles so we know what needs to be built
		self::$build_profiles[] = $ins;
		
		return $ins;
	}
	
	/**
	 * Add a configured Bundle object to the Bundler
	 */
	public function push($bundle) {
		if (!($bundle instanceof Bundle)) {
			throw new Exception("You can only push objects that are an instanceof Bundler", 1);
		}
		$this->bundles[] = $bundle;
	}
	
	public function get_bundles() {
		return $this->bundles;
	}
	
	public function get_path_prefix() {
		return $asset_path_prefix;
	}
	
	public function get_bundled_paths() {
		foreach ($this->bundles as $bundle) {
			$my_array[$bundle->get_bundle_key] = $this->get_full_path($bundle->get_bundled_path());
		}
		return $my_array;
	}
	
	public function get_original_paths() {
		foreach ($this->bundles as $bundle) {
			foreach($bundle->get_original_paths() as $original_bundle_key => $original_bundle_path) {
				$my_array[$original_bundle_key] = $this->get_full_path($original_bundle_path);
			}
		}
		return $my_array;
	}
	
	/**
	 * We're using this instead of trailingslashit, because Bundler is designed to work
	 * outside of WordPress
	 */
	public static function add_trailing_slash($my_path) {
		return (substr($my_path, -1)!='/')?$my_path.'/':$my_path;
	}
	
	public function get_full_path($my_path_suffix) {
		return $this->asset_path_prefix . $my_path_suffix;
	}
}

class Bundle {
	protected $bundle_key = null;
	protected $output_path;
	protected $bundle_items = array();
	protected $meta = array();
	
	public function __construct($my_path) {
		$this->output_path = $my_path;
	}
	
	public function add($bundle_item_key, $my_path) {
		$this->bundle_items[$bundle_item_key] = new BundleItem($bundle_item_key, $my_path, $my_replacements = array());
		return $this;
	}
	
	/**
	 * Best to use this after configuring the bundle
	 */
	protected function manufacture_bundle_key() {
		$keys = array();
		foreach($this->bundle_items as $bundle_item) {
			$key[]=$bundle_item->get_key();
		}
		return 'bundle-'.implode('-', $key);
	}
	
	public function set_bundle_key($key) {
		$this->bundle_key = (string) $key;
		return $this;
	}
	
	public function get_bundle_key() {
		if (!$this->bundle_key) {
			$this->bundle_key = $this->manufacture_bundle_key();
		}
		return $this->bundle_key;
	}
	
	public function get_bundle_items() {
		return $this->bundle_items;
	}
	
	public function get_bundled_path() {
		return $this->output_path;
	}
	
	public function get_original_paths() {
		foreach($this->bundle_items as $bundle_item) {
			$my_array[$bundle_item->get_key()] = $bundle_item->get_path();
		}
		
		return $my_array;
	}
	
	public function set_language($language) {
		return $this->set_meta('language', $language);
	}
	
	public function get_language() {
		return($this->meta['language'])?$this->meta['language']:'';
	}
	
	public function set_meta($key, $value) {
		$this->meta[$key] = $value;
		return $this;
	}
	
	public function get_meta($key) {
		$ret='';
		if(isset($this->meta[$key])) {
			$ret = $this->meta[$key];
		}
		return $ret;
	}
}

class BundleItem {
	protected $key;
	protected $path;
	protected $replacements = array();
	
	public function __construct($my_key, $my_path, $my_replacements = array()) {
		$this->key = $my_key;
		$this->path = $my_path;
		$this->replacements = $my_replacements;
	}
	
	public function add_replacement($find, $replace) {
		$this->replacements[$find] = $replace;
	}
	
	public function get_key() {
		return $this->key;
	}
	
	public function get_path() {
		return $this->path;
	}
	
	public function get_replacements() {
		return $this->replacements;
	}
}
?>
