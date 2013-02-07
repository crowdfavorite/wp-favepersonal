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

?>

	<?php if ( ! is_tax('post_format', 'post-format-image') ) { ?>
		</div><!-- .container -->		
	<?php } ?>				
	</section><!-- #content -->


	<footer id="footer">
		<div class="container clearfix">
<?php
if (cfct_get_option('credit') == 'yes') { 
?>
			<p class="credit"><?php 
			printf(
				__('Powered by <a href="http://wordpress.org/">WordPress</a> %3$s <a href="%4$s" title="A powerful, personal WordPress theme.">%2$s</a> by <a href="%5$s" title="Elegant WordPress development and design services.">%1$s</a>', 'favepersonal'), 
				'Crowd Favorite',
				'FavePersonal',
				'&nbsp;&middot;&nbsp;',
				'http://crowdfavorite.com/wordpress/themes/favepersonal/',
				'http://crowdfavorite.com'
			);
			?></p>
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