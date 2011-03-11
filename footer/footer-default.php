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
	</div><!-- #content -->


	<div id="footer">
		<div class="container clearfix">
			<p><?php printf(__('<a href="http://crowdfavorite.com" title="Custom WordPress development, design and backup services." rel="developer designer">%s</a>', 'carrington-text'), 'Carrington Theme by Crowd Favorite'); ?></p>
			<p><?php _e('Proudly powered by <a href="http://wordpress.org/" rel="generator">WordPress</a></span> and <span id="theme-link"><a href="http://carringtontheme.com" title="Carrington theme for WordPress">Carrington</a></span>.', 'carrington-text'); ?></p>
		</div><!--.container-->
	</div><!-- #footer -->

	<?php wp_footer() ?>

</body>
</html>