#!/usr/bin/php
<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die('Sorry pal, this script ain\'t for web.'); }

/**
 * http://pwfisher.com/nucleus/index.php?itemid=45
 */
function process_args($argv){
	array_shift($argv); $o = array();
	foreach ($argv as $a){
		if (substr($a,0,2) == '--'){ $eq = strpos($a,'=');
			if ($eq !== false){ $o[substr($a,2,$eq-2)] = substr($a,$eq+1); }
			else { $k = substr($a,2); if (!isset($o[$k])){ $o[$k] = true; } } }
		else if (substr($a,0,1) == '-'){
			if (substr($a,2,1) == '='){ $o[substr($a,1,1)] = substr($a,3); }
			else { foreach (str_split(substr($a,1)) as $k){ if (!isset($o[$k])){ $o[$k] = true; } } } }
		else { $o[] = $a; } }
	return $o;
}
$args = process_args($argv);

/* Get the path to the config file.
The config file is required to include the Bundler class */
if (isset($args['config'])) {
	$config_path = $args['config'];
}
else {
	$config_path = dirname(__FILE__) . '/../config.php';
	if (!file_exists($config_path)) {
		$config_path = './config.php';
	}
	if (!file_exists($config_path)) {
		$config_path = '../config.php';
	}
}
require_once($config_path);

if (!class_exists('Bundler')) {
	throw new Exception('Class Bundler needs to be included in your config file.', 1);
}

/**
 * Call this from the build script. It writes the resulting files.
 */

function write_files($bundler_instance) {
	foreach ($bundler_instance->get_bundles() as $bundle) {
		$built = '';
		foreach ($bundle->get_bundle_items() as $bundle_item) {
			$filepath = $bundler_instance->get_full_path($bundle_item->get_path());

			if (!file_exists($filepath)) {
				throw new Exception('D\'oh! File "'.$filepath.'" could not be found.', 1);
			}

			$file_contents = file_get_contents($filepath);
			
			// Do string replacements
			$file_contents = strtr($file_contents, $bundle_item->get_replacements());
			
			$built .= $file_contents;
		}

		$file = fopen($bundler_instance->get_full_path($bundle->get_bundled_path()), 'w');
		fwrite($file, $built);
		fclose($file);
	}
}

foreach (Bundler::$build_profiles as $bundler) {
	write_files($bundler);
}
?>
