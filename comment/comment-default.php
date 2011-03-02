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

global $post, $comment;

extract($data); // for comment reply link

?>
<div id="comment-<?php comment_ID(); ?>" <?php comment_class(''); ?>>
	<div class="entry-content comment-content">
<?php 

if ($comment->comment_approved == '0') {

?>
		<p class="notification"><strong><?php _e('(Your comment is awaiting moderation)', 'carrington-text'); ?></strong></p>
<?php 

}
comment_text();

?>
	</div><!--.entry-content-->
	<div class="clear"></div>
	<div class="meta">

<?php

edit_comment_link(__('Edit', 'carrington-text'), '<span class="comment-editlink">', '</span>');

if (function_exists('get_avatar')) { 
	echo get_avatar($comment, 25);
}

echo '<span class="author">',comment_author_link(),'</span> &mdash; <a href="'.htmlspecialchars(get_comment_link( $comment->comment_ID )).'">',comment_date(),' @ ',comment_time(),'</a>';

if (function_exists('comment_reply_link') && get_option('thread_comments')) {
	echo ' &mdash; ',comment_reply_link(array_merge( $args, array('respond_id' => 'respond-p' . $post->ID, 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment, $post);
}

?>
	</div>
</div>