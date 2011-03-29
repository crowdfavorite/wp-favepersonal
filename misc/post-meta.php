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

/* Using as an include since it's used in many places */
?>
<div class="post-meta">
	<p class="h5"><?php comments_popup_link(__('No Replies', 'carrington-personal'), __('1 Comment', 'carrington-personal'), __('% Comments', 'carrington-personal')); ?></p>
	<?php printf(__('<p class="h6">Categories</p> <p>%s</p>', 'carrington-personal'), get_the_category_list(', ')) ?>
	<?php the_tags(__('<p class="h6">Tags</p> <p>', 'carrington-personal'), ', ', '</p>'); ?>
</div>
