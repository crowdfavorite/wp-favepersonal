<?php
if (!empty($settings['images']) && count($settings['images'])) {
	echo '
		<div class="bio-box-gallery"'.(count($settings['images']) > 1 ? ' id="bio-carousel"' : '').'>
			<div class="bio-box-gallery-images">';
	$thumb_size = 'small-img';
	foreach ($settings['images'] as $img_id) {
		echo wp_get_attachment_image($img_id, $thumb_size, false, array());
	}
	echo '
			</div>';
	if (count($settings['images']) > 1) {
		echo '
			<a href="#prev" class="bio-carousel-nav" id="bio-carousel-prev">'.__('prev', 'favepersonal').'</a>
			<a href="#next" class="bio-carousel-nav" id="bio-carousel-next">'.__('next', 'favepersonal').'</a>';
	}
	echo '
		</div>';
}
?>
<div class="bio-box-content">
	<h2 class="bio-box-title"><?php echo $settings['title']; ?></h2>
	<?php echo wpautop(wptexturize($settings['description'])); ?>
</div>
<?php
if (!empty($settings['links'])) {
	echo '<div class="bio-box-links clearfix"><ul>';
	foreach ($settings['links'] as $link) {
		if (empty($link['url']) || empty($link['title'])) {
			continue;
		}
		if (empty($link['favicon'])) {
			$link['favicon'] = 'default';
		}
		echo '<li><a href="'.esc_url($link['url']).'" title="'.esc_attr($link['title']).'">'.
			'<img width="16" height="16" alt="'.esc_attr($link['title']).'" src="'.cf_about_favicon_url($link['favicon']).'" /></a></li>'.PHP_EOL;
	}
	echo '</ul></div>';
}
?>