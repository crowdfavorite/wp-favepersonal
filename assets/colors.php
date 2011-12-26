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

/**
 * All color related styles from Kuler integration
 * Colors are set in the theme settings within the WordPress admin
 * enquequed from the functions.php and loaded into the header
 */
function cfcp_color_css() {
?>
<style type="text/css" media="screen">
body {
	background-color: <?php echo cf_kuler_color('dark', 'body_background'); ?>;
}
a,
a:visited { 
	color: <?php echo cf_kuler_color('darkest', 'a'); ?>;
}
a:hover,
a:active {
	color: <?php echo cf_kuler_color('medium', 'a_hover'); ?>;
}
::-moz-selection {
	background: <?php echo cf_kuler_color('darkest', 'selection_background'); ?>;
}
::selection {
	background: <?php echo cf_kuler_color('darkest', 'selection_background'); ?>;
}

/** Header
 -------------------------------------------------- */
#header {
	background-color: <?php echo cf_kuler_color('darkest', 'header_background'); ?>;
	border-bottom: 4px solid <?php echo cf_kuler_color('dark', 'header_border'); ?>;
}
#header a,
#nav-main {
	color: <?php echo cf_kuler_color('lightest', 'header_a'); ?>;
}
#header a:hover {
	color: <?php echo cf_kuler_color('medium', 'header_a_hover'); ?>;
}

/* Menu */
#nav-main li {
	border-color: <?php echo cf_kuler_color('darkest', 'header_menu_li_border'); ?>;
}
#nav-main li:hover,
#nav-main li.current-menu-item,
#nav-main li.current-menu-parent {
	border-color: <?php echo cf_kuler_color('dark', 'header_menu_li_border_hover'); ?>;
}

/* Sub Menu */
#nav-main .sub-menu a:hover {
	color: <?php echo cf_kuler_color('darkest', 'header_menu_li_a_hover'); ?>;
}
#nav-main .sub-menu {
	background: <?php echo cf_kuler_color('dark', 'header_menu_ul_ul_background'); ?>;
	border-color: <?php echo cf_kuler_color('darkest', 'header_menu_ul_ul_border'); ?>;
}
#nav-main .sub-menu li.current-menu-item > a {
	border-left-color: <?php echo cf_kuler_color('darkest', 'header_menu_current_a_border_left'); ?>;
	border-right-color: <?php echo cf_kuler_color('darkest', 'header_menu_current_a_border_right'); ?>;
}

/* Menu in dropdown mode */
@media only screen and (max-width: 767px) {
	#nav-main h1 {
		border-color: <?php echo cf_kuler_color('dark', 'header_h1_border'); ?>;
	}
	#nav-main .menu {
		background-color: <?php echo cf_kuler_color('dark', 'header_menu_background'); ?>;
		border-color: <?php echo cf_kuler_color('darkest', 'header_menu_border'); ?>;
	}
}

/** Masthead
 -------------------------------------------------- */
#masthead {
	background-color: <?php echo cf_kuler_color('dark', 'masthead_background'); ?>;
}
/* featured posts */
#featured-posts .featured {
	background-color: <?php echo cf_kuler_color('darkest', 'featured_posts_background') ?>;
	border-bottom-color: <?php echo cf_kuler_color('darkest', 'featured_posts_border_bottom_color') ?>;
}
#featured-posts .featured-title,
#featured-posts .has-featured-img .featured-format {
	background-color: <?php echo cf_kuler_color('darkest', 'featured_posts_title_background') ?>;
	color: <?php echo cf_kuler_color('lightest', 'featured_posts_title_color') ?>;
}
#featured-posts .featured-content {
	color: <?php echo cf_kuler_color('lightest', 'featured_posts_content_color') ?>;
}
/* gallery */
/* set bg color to tile featured gallery with less than 4 images */
#featured-posts .gallery-img-excerpt li.excerpt-img-0 {
	background-color: <?php echo cf_kuler_color('light', 'featured_gallery_img_0') ?>;
}
#featured-posts .gallery-img-excerpt li.excerpt-img-1 {
	background-color: <?php echo cf_kuler_color('medium', 'featured_gallery_img_1') ?>;
}
#featured-posts .gallery-img-excerpt li.excerpt-img-2 {
	background-color: <?php echo cf_kuler_color('medium', 'featured_gallery_img_2') ?>;
}
#featured-posts .gallery-img-excerpt li.excerpt-img-3 {
	background-color: <?php echo cf_kuler_color('light', 'featured_gallery_img_3') ?>;
}
/* video */
#featured-posts .featured-format-video {
	background-color: <?php echo cf_kuler_color('light', 'featured_format_video_background') ?>;
	border-bottom-color: <?php echo cf_kuler_color('light', 'featured_posts_border_bottom_color') ?>;
}

/* rollover */
#featured-posts .featured:hover {
	border-bottom-color: rgba(<?php echo_hex(cf_kuler_color('light', 'featured_posts_hover_border')); ?>, .8);
}
#featured-posts .featured:hover .featured-content {
	background-color: rgb(<?php echo_hex(cf_kuler_color('light', 'featured_posts_hover_background')); ?>); /* fallback for IE */
	background-color: rgba(<?php echo_hex(cf_kuler_color('light', 'featured_posts_hover_background')); ?>, .8);
	color: <?php echo cf_kuler_color('darkest', 'featured_posts_hover_color') ?>;
}


/** Post
 -------------------------------------------------- */
.entry-date a:hover,
.entry-meta a:hover {
	color: <?php echo cf_kuler_color('darkest', 'post_meta_a_hover_color'); ?>;
}
.entry-media a:hover {
	border-bottom-color: <?php echo cf_kuler_color('medium', 'post_media_hover_border'); ?>;
}
.link-screenshot:hover {
	border-bottom-color: <?php echo cf_kuler_color('medium', 'link_screenshot_hover_border'); ?>;
}

/** Sidebar, Widgets, Search Results
 -------------------------------------------------- */
.bio-box a {
	color: <?php echo cf_kuler_color('darkest', 'bio_box_a'); ?>;
}
.bio-box a:hover {
	color: <?php echo cf_kuler_color('lightest', 'bio_box_a_hover'); ?>;
}
.bio-box-gallery a.bio-carousel-nav:hover {
	background-color: <?php echo cf_kuler_color('medium', 'bio_box_carousel_hover_background'); ?>;
}
.bio-box-gallery,
.bio-box-content,
.bio-box-links {
	background-color: <?php echo cf_kuler_color('medium', 'bio_box_content_background'); ?>;
	color: <?php echo cf_kuler_color('lightest', 'bio_box_content_color'); ?>;
}
.bio-box-title {
	color: <?php echo cf_kuler_color('darkest', 'bio_box_title_color'); ?>;
}
.bio-box-links ul li a:hover {
	border-color: <?php echo cf_kuler_color('darkest', 'bio_box_links_a_hover_border'); ?>;
}
.widget-title,
.searchform,
.search-title {
	color: <?php echo cf_kuler_color('dark', 'widget_title_color'); ?>;
	background-color: <?php echo cf_kuler_color('light', 'widget_title_background'); ?>;
}
#primary .heading {
	background-color: <?php echo cf_kuler_color('light', 'widget_title_background'); ?>;
}
#primary .heading .page-title {
	color: <?php echo cf_kuler_color('dark', 'widget_title_color'); ?>;
}
#primary .heading .page-title em {
	color: <?php echo cf_kuler_color('darkest', 'widget_title_color'); ?>;
}

.search-title em {
	color: <?php echo cf_kuler_color('darkest', 'search_title_em_color'); ?>;
}
.searchform #s {
	color: <?php echo cf_kuler_color('darkest', 'widget_search_s_color'); ?>;
}
.searchform label {
	color: <?php echo cf_kuler_color('dark', 'widget_search_label_color'); ?>;
}
.searchform label.focus {
	color: <?php echo cf_kuler_color('medium', 'widget_search_label_focus_color'); ?>;
}
.searchform #searchsubmit:hover,
.searchform #searchsubmit:focus {
	background-color: <?php echo cf_kuler_color('dark', 'widget_search_submit_hover_background'); ?>;
}
.searchform #searchsubmit:active {
	background-color: <?php echo cf_kuler_color('darkest', 'widget_search_submit_active_background'); ?>;
}

/** Footer
 -------------------------------------------------- */
#footer {
	color: <?php echo cf_kuler_color('lightest', 'footer_color'); ?>;
	background-color: <?php echo cf_kuler_color('dark', 'footer_background'); ?>;
}
#footer a {
	color: <?php echo cf_kuler_color('light', 'footer_a'); ?>;
}

/** Utilities
 -------------------------------------------------- */
.wp-caption dd {
	color: <?php echo cf_kuler_color('dark', 'wp_caption_dd_color'); ?>;
	background-color: <?php echo cf_kuler_color('lightest', 'wp_caption_dd_background'); ?>;
}
.post .gallery-img-excerpt li a:hover,
.attachment-next a:hover,
.attachment-prev a:hover {
	border-bottom-color: <?php echo cf_kuler_color('medium', 'gallery_nav_border_hover'); ?>;
}
.post .gallery-img-excerpt li.gallery-view-all a {
	background-color: <?php echo cf_kuler_color('lightest', 'gallery_view_all_background'); ?>;
}
.post .gallery-img-excerpt li.gallery-view-all a:hover {
	background-color: <?php echo cf_kuler_color('light', 'gallery_view_all_hover_background'); ?>;
}
.post .gallery-thumbs a:hover {
	border-bottom-color: <?php echo cf_kuler_color('medium', 'gallery_thumbs_a_hover_border'); ?>;
}
.post .gallery-thumbs a.activated {
	border-bottom-color: <?php echo cf_kuler_color('darkest', 'gallery_thumbs_a_activated_border'); ?>;
}
.edit-link a {
	background-color: <?php echo cf_kuler_color('dark', 'edit_link_background'); ?>;
}
.edit-link a:hover {
	background-color: <?php echo cf_kuler_color('darkest', 'edit_link_background_hover'); ?>;
}


/* Shortcode Gallery */
#content .gallery-item .gallery-icon a:hover {
	border-bottom-color: <?php echo cf_kuler_color('medium', 'gallery_icon_a_hover_border'); ?>;
}

/* Social */
#social #reply-title,
#social .comments-title,
#social .nocomments,
#social .social-nav,
#social .social-nav a span {
	background-color: <?php echo cf_kuler_color('light', 'social-heading_background'); ?>;
}
#social #reply-title {
	color: <?php echo cf_kuler_color('dark', 'widget_title_color'); ?>;
}
#social .social-heading,
#social .nocomments {
	color: <?php echo cf_kuler_color('dark', 'social_heading_color'); ?>;
}
#social .social-nav a,
#social #submit,
#facebook_signin,
#twitter_signin {
	background-color: <?php echo cf_kuler_color('dark', 'social_button_background'); ?>;
}
#social .social-nav a:hover,
#social #submit:hover,
#facebook_signin:hover,
#twitter_signin:hover {
	background-color: <?php echo cf_kuler_color('darkest', 'social_button_hover_background'); ?>;
}		
#social .social-nav a {
	color: <?php echo cf_kuler_color('dark', 'social_a_color'); ?>;
}
#social .social-current-tab a,
#social .social-nav a:hover {
	color: <?php echo cf_kuler_color('darkest', 'social_nav_a_color'); ?>;
	background-color: <?php echo cf_kuler_color('darkest', 'social_nav_a_background'); ?>;
}
#social .social-posted-from {
	background-color: <?php echo cf_kuler_color('light', 'social_posted_form_background'); ?>;
}
#social .comment-awaiting-moderation {
	background-color: <?php echo cf_kuler_color('light', 'social_moderation_background'); ?>;
	color: <?php echo cf_kuler_color('darkest', 'social_moderation_color'); ?>;
}
#social .social-posted-when:hover,
#social .social-actions a:hover {
	color: <?php echo cf_kuler_color('medium', 'a_hover'); ?>;
}
</style>
<?php
}
add_action('wp_head', 'cfcp_color_css', 8); 
?>