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


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

?>
<article id="post-<?php the_ID(); ?>">
	<h3 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
<?php

the_excerpt();

?>
	<div class="meta"><abbr class="published" title="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('M j, Y'); ?></abbr> &mdash; 

<?php

comments_popup_link(__('No comments', 'carrington-personal'), __('1 comment', 'carrington-personal'), __('% comments', 'carrington-personal'));

?>
	</div>
</article><!-- .excerpt -->