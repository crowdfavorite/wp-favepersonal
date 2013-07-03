<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

global $post;
if (!is_post_type_hierarchical($post->post_type)) {
?>
<div class="pagination h6 clearfix">
	<span class="next"><?php previous_post_link('%link &raquo') ?></span>
	<span class="prev"><?php next_post_link('&laquo; %link') ?></span>
</div>
<?php
}
