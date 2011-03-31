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

global $post, $wp_query, $comments, $comment;

if (have_comments() || comments_open()) {
?>

<h2 id="comments" class="comments-title"><?php comments_number(__('No Responses (yet)', 'carrington-personal'), __('One Response', 'carrington-personal'), __('% Responses', 'carrington-personal')); ?></h2>

<div id="mcc">
	<div class="mcc-comments">
<?php 
	if (!post_password_required()) {
		$comments = $wp_query->comments;
		$comment_count = 0;
		$ping_count = 0;
		foreach ($comments as $comment) {
			if (get_comment_type() == 'comment') {
				$comment_count++;
			}
			else {
				$ping_count++;
			}
		}
		if ($comment_count) {
			echo '<ol class="mcc-commentlist commentlist">', wp_list_comments('callback=cfct_threaded_comment'), '</ol>';
			
			previous_comments_link();
			next_comments_link();
		}
		cfct_form('comment');
	}
?>

	</div><!-- #comments -->
</div><!--#mcc-->
<?php 
}
?>
