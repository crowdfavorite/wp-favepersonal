<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2011 Crowd Favorite, Ltd. All rights reserved.
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

<div id="primary">

	<h1 class="search-title h3"><?php printf(__('Search Results for: <em>%s</em>', 'favepersonal' ), esc_html(get_search_query())); ?></h1>
	
<?php
cfct_loop();
cfct_misc('nav-posts');
?>

</div>

<div id="secondary">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>