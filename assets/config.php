<?php
// Navigate to asset root using realpath.
$abspath = realpath(dirname(__FILE__));
require_once($abspath . '/lib/Bundler.php');

$bundler = Bundler::create($abspath);

$bundle_css = new Bundle('css/build.css');
$bundle_css
	->set_bundle_key('bundle-personal')
	->set_language('css')
	->add('base', 'css/base.css')
	->add('utility', 'css/utility.css')
	->add('content', 'css/content.css')
	->add('masthead', 'css/masthead.css')
	->add('media-mobile', 'css/media-mobile.css')
	->add('media-tablet', 'css/media-tablet.css')
	->add('social', 'css/social.css');
$bundler->push($bundle_css);

$bundle_js = new Bundle('js/build.js');
$bundle_js
	->set_bundle_key('bundle-personal')
	->set_language('javascript')
	->set_meta('dependencies', array('jquery'))
	->add('modernizr', 'js/modernizr.custom.js')
	->add('cfgallery', 'js/cfgallery/jquery.cfgallery.js')
	->add('global', 'js/global.js');
$bundler->push($bundle_js);
?>