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

remove_filter('post_gallery', 'cfcp_gallery_shortcode', 1, 2);

?>
<p><?php cfpf_gallery_output(array('size' => 'thumb-img')); ?></p>
<?php

cfct_the_excerpt_feed();
