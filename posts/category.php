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

<div id="primary">
	<div class="heading">
<?php 
cfpt_page_title('<h1 class="page-title">', '</h1>');
	
if ($category_description = category_description()) {
?>
		<div class="heading-description">
			<?php echo $category_description; ?>
		</div>
<?php
}
?>
	</div>
<?php

cfct_loop();
cfct_misc('nav-posts');

?>
</div>

<div id="secondary">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>