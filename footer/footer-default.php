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
		<div class="container">
			<?php cfct_form('search'); ?>
			<ul class="social-network-links">
				<li><a href="http://twitter.com">T</a></li>
				<li><a href="http://facebook.com">FB</a></li>
				<li><a href="http://flickr.com">Fl</a></li>
				<li><a href="http://vimeo.com">V</a></li>
				<li><a href="http://linkedin.com">L</a></li>
			</ul>
		</div><!--.container-->
	</div><!-- #footer -->

	<?php wp_footer() ?>

</body>
</html>