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

global $comment;

?>
<div id="comment-<?php comment_ID(); ?>" <?php comment_class('hentry'); ?>>
	<div class="entry-content comment-content">
<?php 

comment_text();

?>
	</div><!--.entry-content-->
	<div class="clear"></div>
	<div class="meta">

<?php

edit_comment_link(__('Edit', 'carrington-text'), '<span class="comment-editlink">', '</span>');

echo '<span class="author">',comment_author_link(),'</span> &mdash; <a href="'.htmlspecialchars(get_comment_link( $comment->comment_ID )).'">',comment_date(),' @ ',comment_time(),'</a>';

?>
	</div>
</div>