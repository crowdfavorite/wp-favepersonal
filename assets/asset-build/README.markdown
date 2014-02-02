`build.php` is a very simple command line build script designed to take groups of CSS or JS files and combine them into a built file.

## What it has going for it

- Combines files
- Works on the command line
- PHP!

## What it doesn't

`build.php` does not:

- ...Try to do smart URL rewriting by itself. You can, however, specify a list of string replacements for each bundle.
- ...Do any kind of path error checking -- it's up to you to make sure things make sense.
- ...Strip whitespace characters.
- ...Strip comments.
- ...Make you coffee.

## How to use it

Each site's configuration will likely be a little different. I've found it useful to structure assets like this:

	assets/
		config.php
		load.php
		asset-build/ # This repo
			config-example.php # Includes Builder.php. Defines the bundles.
			load-example.php # Includes config.php. Handles enqueueing assets/bundles into WordPress.
			build.php # Includes config.php. The command-line build script.
			lib/
				Bundler.php # This class keeps track of all the assets, bundles, and has a method to write files.
				Bundler_Loader.php

Setting up bundles is easy using the `define_bundle()` and `add_to_bundle()` methods. For example:
	
	$bundler = new Bundler('/asset/path/prefix/');
	$bundler->define('bundle_name', 'path/to/built/file.css');
	$bundler->add_to('bundle_name', 'common/css/base.css');
	$bundler->add_to('bundle_name', 'common/css/main.css', array('../img/', '../../../common/img/'));

At the very end, register your instance of Bundler to be built by the build script like so:

	$bundler->add_to_build_profiles();

To write the files, In the command line,

	$ cd /path/to/build.php
	
then...
	
	$ php build.php

By default, build.php will look for your config file at `../config.php`. You can specify a path to your config file like this, though:

	$ php build.php --config=../path/to/config.php

That's it! Assuming PHP has write access, new files will be created for each bundle in the same directory as your old development files. Your development files will not be touched.