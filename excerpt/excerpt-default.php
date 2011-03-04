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
<div id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt'); ?>>
	<div class="post-header">
		<h1 class="post-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h1>
		<p class="post-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_date(); ?></abbr></p>
	</div>
	<div class="post-content">
		<?php comments_popup_link(__('No Comments', 'carrington-personal'), __('1 Comment', 'carrington-text'), __('% Comments', 'carrington-personal')); ?>		
	</div>
</div><!-- .excerpt -->