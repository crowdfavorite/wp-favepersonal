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

/* Using as an include since it's used in many places */

?>
<div class="post-meta">
<?php

do_action('favepersonal_content_sidebar_before');

?>
	<p class="post-meta-replies h5"><?php comments_popup_link(__('No Replies', 'favepersonal'), __('1 Reply', 'favepersonal'), __('% Replies', 'favepersonal')); ?></p>
	<?php printf(__('<p class="post-meta-title h6">Categories</p> <p class="post-meta-categories">%s</p>', 'favepersonal'), get_the_category_list(', ')) ?>
	<?php the_tags(__('<p class="post-meta-title h6">Tags</p> <p class="post-meta-tags">', 'favepersonal'), ', ', '</p>'); ?>
<?php

do_action('favepersonal_content_sidebar_after');

?>
</div>
