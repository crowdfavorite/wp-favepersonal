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

<p id="you-must-be-logged-in-to-comment"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'favepersonal'), site_url().'/wp-login.php?redirect_to='.urlencode(get_permalink())); ?></p>

<?php
	}
	else { 
?>

	
<div id="respond">

	<h2 id="reply-title"><span><?php printf(__('Post A Comment', 'favepersonal')); ?></span></h2>
		
<form class="social-respond-inner" action="<?php echo trailingslashit(site_url()); ?>wp-comments-post.php" method="post">
	<div class="social-post-form"> 	
<?php if (!is_user_logged_in()) { ?>
		<p class="social-input-row social-input-row-author">
			<label class="social-label" for="social-sign-in-name"><?php _e('Name', 'favepersonal'); ?></label>
			<input class="social-input" id="social-sign-in-name" required="required" type="text" name="author" value="<?php echo $comment_author; ?>" size="22" />
		</p>
		<p class="social-input-row social-input-row-email">
			<label class="social-label" for="social-sign-in-email"><?php _e('Email ', 'favepersonal'); ?></label>
			<input class="social-input" id="social-sign-in-email" required="required" type="text" name="email" value="<?php echo $comment_author_email; ?>" size="22" />
		</p>
		<p class="social-input-row social-input-row-url">
			<label class="social-label" for="social-sign-in-website"><?php _e('Website', 'favepersonal'); ?></label>
			<input class="social-input" id="social-sign-in-website" type="text" name="url" value="<?php echo $comment_author_url; ?>" size="22" />
		</p>
<?php } ?>
<?php if (is_user_logged_in()) { ?>
		<div class="social-input-row"><?php printf(__('Logged in as <a href="%s">%s</a>. ', 'favepersonal'), site_url().'/wp-admin/profile.php', $user_identity); wp_loginout(); ?>.</div>
<?php } ?>
		<p class="social-input-row social-input-row-comment">
			<label class="social-label" for="social-sign-in-comment"><?php _e('Comment', 'favepersonal'); ?></label>
			<textarea id="comment" name="comment" class="social-input" required="required"></textarea>
		</p>
		<p class="form-submit">
			<input name="submit" type="submit" id="submit" value="<?php _e('Post It', 'favepersonal'); ?>">
			<?php cancel_comment_reply_link() ?>
		</p>
<?php
		comment_id_fields();
		do_action('comment_form', $post->ID);
?>
	</div> <!--.social-post-form-->
</form>

</div><!--#respond-->

<?php 
	} // If registration required and not logged in 
} // If you delete this the sky will fall on your head
?>