/* Replace .no-js class with .js class. Very useful for accessible Javascript FOUC
prevention with CSS */
;(function (doc) {
	h = doc.getElementsByTagName('html')[0];
	h.className = h.className.replace('no-js', 'js');
})(document);

jQuery(function($) {
// Bio box carousel
	var $bioCarousel = $('#bio-carousel .bio-box-gallery-images');
	var $bioImages = $bioCarousel.find('img');
	if ($bioImages.size() > 1) {
		$bioCarousel.cycle({
			'fx': 'scrollHorz',
			'timeout': 0,
			'next': '#bio-carousel-next, .bio-box-gallery-images img', 
			'prev': '#bio-carousel-prev',
			'speed': 400
		});
		$bioImages.hover(function() {
			$(this).css({'cursor': 'pointer'});
		});
	};
	
// Search form scripts
	//hide the label after typing
	$('.searchform #s').keypress(function() {
		if ($(this).val() == '') {
			$(this).prev('label').hide();
		};
	}).blur(function() {
		if ($(this).val() == '') {
			$(this).prev('label').show();
			$('.searchform label').removeClass('focus');
		};
	});
	$('.searchform label').click(function() {
		$(this).addClass('focus');
	});

// Gallery
	if (typeof cfcpGalleryWidth == 'undefined') {
		cfcpGalleryWidth = 710;
	}
	$('.gallery').cfgallery({
		'stageDimensions': [cfcpGalleryWidth, 474]
	});
	$('.gallery-img-excerpt a').cfShimLinkHash();
});