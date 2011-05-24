jQuery(function($) {
// About box carousel
	var $aboutImgs = $('#bio-carousel .bio-box-gallery-images');
	if ($aboutImgs.find('img').size() > 1) {
		$aboutImgs.cycle({
			'fx': 'scrollHorz',
			'timeout': 0,
			'next': '#bio-carousel-next', 
			'prev': '#bio-carousel-prev',
			'speed': 400
		});
	};
	
// Search form scripts
	//hide the label after typing
	$('.searchform #s').keypress(function() {
		var $this = jQuery(this);
		if ($this.val() == '') {
			$this.prev('label').hide();
		};
	});
	$('.searchform #s').blur(function() {
		var $this = jQuery(this);
		if ($this.val() == '') {
			$this.prev('label').show();
			$('.searchform label').removeClass('focus');
		};
	});
	$('.searchform label').click(function() {
		$(this).addClass('focus');
	});
	
	$('.gallery').cfgallery();
	
	$('.gallery-img-excerpt a').cfShimLinkHash();
});

