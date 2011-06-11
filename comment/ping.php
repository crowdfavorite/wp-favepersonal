<?php

/**
 * @package favepersonal
 *
 * This file is part of the Carrington Personal Theme for WordPress
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


<div id="comment-<?php comment_ID(); ?>"  class="mcc-comment-inner">
	<div class="mcc-comment-header">
		<div class="mcc-comment-author vcard">
			<cite class="mcc-fn fn">Pingback</cite>
		</div><!-- .comment-author .vcard -->
		<div class="mcc-comment-meta">
			<span class="mcc-posted-from">Pingback</span> 
			<?php echo '<a href="'.htmlspecialchars(get_comment_link( $comment->comment_ID )).'" class="mcc-posted-when">',cfcp_date(),'</a>';  ?>
		</div>
	</div><!--.mcc-comment-header-->
	<div class="mcc-comment-body">
		<p><?php comment_author_link(); ?></p>
		<?php comment_text(); ?>
	</div><!--.mcc-comment-body-->
	<div class="mcc-actions">
		<a class="mcc-comment-email-link" href="#">Email This</a>
		<?php edit_comment_link(__('Edit', 'favepersonal'), ' &middot; <span class="comment-editlink">', '</span>'); ?>
	</div><!--.mcc-actions-->
</div>