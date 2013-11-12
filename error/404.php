<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/favepersonal/
 *
 * Copyright (c) 2008-2013 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

get_header();

?>

<div class="page-full clearfix">

	<h1><?php _e('Sorry, we\'re not sure what you\'re looking for here.', 'favepersonal'); ?></h1>
	<p><?php _e('Perhaps searching, or one of the links below, can help.', 'favepersonal'); ?></p>
	<?php cfct_form('search'); ?>		
	
</div><!--.page-full-->

<div id="secondary-full" class="clearfix">
	<?php get_sidebar(); ?>
</div>

<?php

get_footer();

?>