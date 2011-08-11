/**
Workaround: load CSS3 Media Queries shim if IE8, since current build crashes IE8
@see https://github.com/scottjehl/Respond/issues/27

Load respond.js for everyone else.
In future, lets remove this, once respond.js gets it's act together.
 */
(function(window, M, CFCP) {
	var url = CFCP.scriptsDirUrl,
		nav = window.navigator;

	M.load({
		test: (nav.appName === 'Microsoft Internet Explorer' && nav.appVersion.search('MSIE 8.0') > 0),
		yep:  url + 'css3-media-queries.min.js',
		nope: url + 'respond.min.js'
	});
})(window, Modernizr, CFCP);

jQuery(function($) {
	$('#nav-main h1')
		.bind('touchend', function(e){
			$('#nav-main .menu').toggle();
			e.preventDefault();
			e.stopPropagation();
		});
	
	// add hover support for li
	$('li').hover(
		function() { $(this).addClass('hover'); },
		function() { $(this).removeClass('hover'); }
	);

	// Bio box carousel
	var $bioCarousel = $('#bio-carousel .bio-box-gallery-images');
	if ($bioCarousel.length > 0 && typeof $bioCarousel.cycle === 'function') {
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
	};

	// Social link tooltips
	$('.bio-box-links li').each(function() {
		var $this = $(this);
		var $tooltip_html = $('<div class="bio-tooltip"/>')
			.html($this.find('img').attr('alt'));
		
		$(this).append($tooltip_html).find('a').removeAttr('title');
		$tooltip_html.css('margin-left', -1 * ($tooltip_html.outerWidth() / 2) + ($this.outerWidth() / 2));	
	});
	
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
	if (typeof cfcpGalleryHeight == 'undefined') {
		cfcpGalleryHeight = 474;
	}
	if (typeof cfcpGalleryWidth == 'undefined') {
		cfcpGalleryWidth = 710;
	}
	$('.cfgallery').cfgallery({
		'stageDimensions': [cfcpGalleryWidth, cfcpGalleryHeight]
	});
	$('.gallery-img-excerpt a').cfShimLinkHash();

});