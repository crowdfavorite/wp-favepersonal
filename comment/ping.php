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

global $comment;

?>

<div id="comment-<?php comment_ID(); ?>"  class="social-comment-inner">
	<div class="social-comment-header">
		<div class="social-comment-author vcard">
			<cite class="social-fn fn">Pingback</cite>
		</div><!-- .comment-author .vcard -->
		<div class="social-comment-meta">
			<span class="social-posted-from">Pingback</span> 
			<?php echo '<a href="'.htmlspecialchars(get_comment_link( $comment->comment_ID )).'" class="social-posted-when">',cfcp_date(),'</a>';  ?>
		</div>
	</div><!--.social-comment-header-->
	<div class="social-comment-body">
		<p><?php comment_author_link(); ?></p>
		<?php comment_text(); ?>
	</div><!--.social-comment-body-->
	<div class="social-actions">
		<a class="social-comment-email-link" href="#">Email This</a>
		<?php edit_comment_link(__('Edit', 'favepersonal'), ' &middot; <span class="comment-editlink">', '</span>'); ?>
	</div><!--.social-actions-->
</div>