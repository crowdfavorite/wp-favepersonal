<?php

/**
 * @package carrington-personal
 *
 * This file is part of the Carrington Personal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/carrington-personal/
 *
 * Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
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

?>

		</div><!-- .container -->		
	</section><!-- #content -->


	<footer id="footer">
		<div class="container clearfix">
			<p class="credit"><?php _e('Powered by <a href="http://wordpress.org/" rel="generator">WordPress</a></span>', 'carrington-personal'); ?> &nbsp;&middot;&nbsp; <?php printf(__('<a href="http://crowdfavorite.com/themes/carrington-personal" title="Powerful Wordpress theme to power your personal sites">%s</a>', 'carrington-personal'), 'Carrington Personal'); ?> by <?php printf(__('<a href="http://crowdfavorite.com" title="Custom WordPress development, design and backup services." rel="developer designer">%s</a>', 'carrington-text'), 'Crowd Favorite'); ?></p>
			<p><?php _e('Copyright &copy; ', 'carrington-personal'); echo date('Y'); ?> &nbsp;&middot;&nbsp; <?php bloginfo('name'); ?></p>
		</div><!--.container-->
	</footer><!-- #footer -->

	<?php wp_footer() ?>

</body>
</html>