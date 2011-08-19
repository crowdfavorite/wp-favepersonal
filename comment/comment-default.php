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

global $post, $comment;
extract($data); // for comment reply link

?>
<div id="comment-<?php comment_ID(); ?>" <?php comment_class('social-comment-inner social-clearfix'); ?>>
	<div class="social-comment-header">
		<div class="social-comment-author vcard">
			<?php if (function_exists('get_avatar')) { 
				echo get_avatar($comment, 30);
			} ?>
			<cite class="social-fn fn"><?php comment_author_link(); ?></cite>
		</div><!-- .comment-author .vcard -->
		<div class="social-comment-meta">
			<span class="social-posted-from">Comment</span> 
			<?php echo '<a href="'.esc_url(get_comment_link( $comment->comment_ID )).'" class="social-posted-when">',cfcp_comment_date(),'</a>'; ?>
		</div>
	</div><!--.social-comment-header-->
	<div class="social-comment-body">
		<?php if ($comment->comment_approved == '0') { ?>
			<p class="comment-awaiting-moderation"><strong><?php _e('Your comment is awaiting moderation', 'favepersonal'); ?></strong></p>
		<?php }
			comment_text();
		?>
	</div><!--.social-comment-body-->
	<div class="social-actions">
		<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])), $comment, $post); ?>
	</div><!--.social-actions-->
</div><!--#comment-xx-->
