;(function($, win){
	var gal = function(options) {
		var opts = $.extend(options, gal.defaults);
		gal.$gal = this;
		gal.$thumbs = this.find('ul a[href][id]');
		gal.updateStage(opts.startAt);
		
		gal.$thumbs.click(gal.clickThumb);
		
		$(win).load(function(){
			var loc = win.location.hash,
				t = gal.$thumbs.filter(loc),
				i;
			if (loc && t.length > 0) {
				i = gal.getThumbIndex(t);
				gal.updateStage(i);
			};
		});
	};
	/* Default args for gallery */
	gal.defaults = {
		fullSize: [710, 473],
		startAt: 0
	};
	
	gal.updateStage = function(i) {
		var src = gal.getSrcFromThumb(i),
			nextSrc = gal.getSrcFromThumb(i + 1),
			$stage = $('<div class="stage"/>'),
			$img = gal.createImage(src),
			$nextImg = gal.createImage(nextSrc);
		
		gal.$gal.prepend($stage.append($img));
	};
	
	/* Create and extend an image object from url */
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
		return gal.$thumbs.index($thumb);
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