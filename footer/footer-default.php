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

?>

		</div><!-- .container -->		
	</section><!-- #content -->


	<footer id="footer">
		<div class="container clearfix">
<?php
if (cfct_get_option('credit') == 'yes') { 
?>
			<p class="credit"><?php _e('Powered by <a href="http://wordpress.org/" rel="generator">WordPress</a></span>', 'favepersonal'); ?> &nbsp;&middot;&nbsp; <?php printf(__('<a href="http://crowdfavorite.com/themes/favepersonal" title="A powerful, personal Wordpress theme.">%s</a>', 'favepersonal'), 'FavePersonal'); ?> by <?php printf(__('<a href="http://crowdfavorite.com" title="Elegant WordPress development and design services." rel="developer designer">%s</a>', 'favepersonal'), 'Crowd Favorite'); ?></p>
<?php
}
$colophon = str_replace('%Y', date('Y'), cfct_get_option('cfcp_copyright'));
$sep = ($colophon ? ' &nbsp;&middot;&nbsp; ' : '');
$loginout = cfct_get_loginout('', $sep);
if ($colophon || $loginout) {
	echo '<p>'.$colophon.$loginout.'</p>';
}
?>
		</div><!--.container-->
	</footer><!-- #footer -->

	<?php wp_footer() ?>

</body>
</html>