<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
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


<?php

// Posts that are NOT post_type image
if ( !is_tax('post_format', 'post-format-image') && !is_tax('post_format', 'post-format-video') ) { ?>

<div id="primary">
	<div class="heading">
		<?php cfpt_page_title('<h1 class="page-title">', '</h1>'); ?>
	</div>
<?php

cfct_loop();
cfct_misc('nav-posts');

?>
</div>

<div id="secondary">
	<?php get_sidebar(); ?>
</div>

<?php
// END Posts that are NOT post_type image

// Posts that ARE post_type image or video
}
else {
?>
<div id="primary-full" class="img-vid-archive">
	<div class="full-archive-container clearfix">
		<div class="heading">
			<h1 class="page-title"><em>
			<?php if (is_tax('post_format', 'post-format-image')) {
				echo 'Image';
			}
			else {
				echo 'Video';
			} ?>
			</em> Archives</h1>
		</div>
		<?php

		cfct_loop();
		cfct_misc('nav-posts');

		?>
	</div>
</div>
<div id="secondary-full">
	<?php get_sidebar(); ?>
</div>
<?php } // end Posts that ARE post_type image ?>

<?php get_footer(); ?>