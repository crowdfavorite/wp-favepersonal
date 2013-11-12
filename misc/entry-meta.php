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

/* Using as an include since it's used in many places */

?>
<footer class="entry-meta">
<?php

do_action('favepersonal_content_sidebar_before');

if (post_type_supports($post->post_type, 'comments')) {
?>
	<p class="h5"><?php comments_popup_link(__('No Replies', 'favepersonal'), __('1 Reply', 'favepersonal'), __('% Replies', 'favepersonal')); ?></p>
<?php
}

$cats = get_the_category_list(', ');
if (!empty($cats)) {
	printf(__('<p><span class="h6 block">Categories</span> %s</p>', 'favepersonal'), $cats);
}
the_tags(__('<p><span class="h6 block">Tags</span> ', 'favepersonal'), ', ', '</p>');
edit_post_link('edit', '<span class="edit-link">', '</span>');

do_action('favepersonal_content_sidebar_after');

?>
</footer>
