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

global $post, $wp_query, $comments, $comment;

if (post_type_supports($post->post_type, 'comments') && (have_comments() || comments_open())) {
	$comment_count = get_comment_count($post->ID);
?>

<div id="social">

<?php
	if ($comment_count['approved'] > 0) {
?>
		<h2 id="comments" class="comments-title"><span><?php comments_number(__('No Responses (yet)', 'favepersonal'), __('One Response', 'favepersonal'), __('% Responses', 'favepersonal')); ?></h2>
<?php 
	}
?>
	<div class="social-comments">
<?php
	if (!post_password_required()) {
		$comments = $wp_query->comments;
		$comment_count = 0;
		$ping_count = 0;
		foreach ($comments as $comment) {
			if (!in_array(get_comment_type(), array('pingback', 'trackback'))) {
				$comment_count++;
			}
			else {
				$ping_count++;
			}
		}
		if ($comment_count || $ping_count) {
			echo '<ol class="social-commentlist">', wp_list_comments('callback=cfct_threaded_comment'), '</ol>';
		}

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="pagination h6">
				<span class="next"><?php previous_comments_link('Older Comments &raquo;'); ?></span>
				<span class="prev"><?php next_comments_link('&laquo; Newer Comments'); ?></span>
			</div> <!-- .navigation -->
		<?php endif; // check for comment navigation

		cfct_form('comment');
	}
?>

	</div><!-- .social-comments -->
</div><!--#social-->
<?php
}
?>
