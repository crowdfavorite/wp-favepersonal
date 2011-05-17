;(function($, win){
	var gal = function(options) {
		var opts = $.extend(options, gal.defaults);
		gal.$thumbs = this.find('ul a[href][id]');
		gal.setupStage(this, opts);
		
		gal.$thumbs.click(gal.clickThumb);
		
		$(win).load(function(){
			var id = win.location.hash + '',
				t = gal.$thumbs.find(id);
			console.log(t);
			
			if (t.length > 0) {
				opts.startAt = gal.getThumbIndex(t);
			};
		});
	};
	/* Default args for gallery */
	gal.defaults = {
		fullSize: [710, 473],
		startAt: 0
	};
	gal.setupStage = function($gal, opts) {
		var i = opts.startAt,
			src = gal.getSrcFromThumb(i),
			nextSrc = gal.getSrcFromThumb(i + 1),
			$stage = $('<div class="stage"/>'),
			$img = gal.createImage(src),
			$nextImg = gal.createImage(nextSrc);
		$gal.prepend($stage.append($img));
	};
	gal.createImage = function(src) {
		var img = new Image();
		img.src = src;
		img.alt = "";
		return $(img);
	};
	gal.getSrcFromThumb = function(i) {
		return gal.$thumbs.eq(i).find('img').attr('src');
	};
	
	/*
	Get the index of a thumb jQuery object in the set of thumb objects.
	@return int 0-x or -1 if not found. */
	gal.getThumbIndex = function($thumb) {
		for (var i = gal.$thumbs.length - 1; i >= 0; i--){
			if (gal.$thumbs[i] === $thumb) {
				return i;
			};
		};
		return -1;
	};
	
	gal.clickThumb = function(e) {
		var i = gal.getThumbIndex(this),
			prevImg,
			nextImg,
			src;

		e.preventDefault();

		if (i > 1) {
			src = gal.getSrcFromThumb(i - 1);
			prevImg = gal.createImage(src);
		};
		if (i < gal.$thumbs.length) {
			src = gal.getSrcFromThumb(i + 1);
			nextImg = gal.createImage(src);
		};
	};
	
	$.fn.cfgallery = gal;
})(jQuery, window);