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

global $post, $user_identity;

$commenter = wp_get_current_commenter();

extract($commenter);

$req = get_option('require_name_email');

// if post is open to new comments
if ('open' == $post->comment_status) {
	// if you need to be regestered to post comments..
	if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>

<p id="you-must-be-logged-in-to-comment"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'favepersonal'), get_bloginfo('wpurl').'/wp-login.php?redirect_to='.urlencode(get_permalink())); ?></p>

<?php
	}
	else { 
?>

<div id="respond" class="mcc-sign-in-form">
		
	<form action="<?php echo trailingslashit(get_bloginfo('wpurl')); ?>wp-comments-post.php" method="post">
		<?php cancel_comment_reply_link() ?>
<?php if (!is_user_logged_in()) { ?>
		<div class="mcc-input-row">
			<label><?php _e('Name', 'favepersonal'); ?></label>
			<input class="mcc-input-text" id="mcc-sign-in-name" type="text" name="author" value="<?php echo $comment_author; ?>" size="22" />
		</div>
		<div class="mcc-input-row">
			<label><?php _e('Email ', 'favepersonal'); ?></label>
			<input class="mcc-input-text" id="mcc-sign-in-email" type="text" name="email" value="<?php echo $comment_author_email; ?>" size="22" />
		</div>
		<div class="mcc-input-row">
			<label><?php _e('Website', 'favepersonal'); ?></label>
			<input class="mcc-input-text" id="mcc-sign-in-website" type="text" name="url" value="<?php echo $comment_author_url; ?>" size="22" />
		</div>
<?php } ?>
		<div class="mcc-input-row">
			<label><?php _e('Comment', 'favepersonal'); ?></label>
			<textarea id="mcc-sign-in-comment" name="comment"></textarea>
		</div>
		<div class="mcc-input-row">
			<input class="mcc-input-submit" name="submit" type="submit" value="<?php _e('Post Comment', 'favepersonal'); ?>" />
		</div>
<?php 
		comment_id_fields();
		do_action('comment_form', $post->ID);
?>
	</form>
</div><!--#respond-->

<?php 
	} // If registration required and not logged in 
} // If you delete this the sky will fall on your head
?>