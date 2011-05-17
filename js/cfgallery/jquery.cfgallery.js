;(function($, win){
	var gal = function(options) {
		var opts = $.extend(options, gal.defaults),
			fn = gal.fn;
		
		// Memoize gallery and thumbs for use later.
		fn.$gal = this;
		fn.$thumbs = this.find('ul a[href][id]');
		
		fn.updateStage(opts.startAt);
		
		fn.$thumbs.click(fn.clickThumb);
		
		$(win).load(function(){
			var loc = win.location.hash,
				t = fn.$thumbs.filter(loc),
				i;
			if (loc && t.length > 0) {
				i = fn.getThumbIndex(t);
				fn.updateStage(i);
			};
		});
	};
	/* Helper functions. These live inside of an object so that
	"this" still points to the parent object (constructors the $.fn space get their
	"this" value set to the jQuery collection passed). Object literal object notation also
	compresses down a little better in Closure Compiler. */
	gal.fn = {
		//$gal: Gallery jQuery object
		//$thumbs: thumb array jQuery object
		
		updateStage: function(i) {
			var src = this.getSrcFromThumb(i),
				nextSrc = this.getSrcFromThumb(i + 1),
				$stage = $('<div class="stage"/>'),
				$img = this.createImage(src),
				$nextImg = this.createImage(nextSrc);

			this.$gal.prepend($stage.append($img));
		},

		/* Create and extend an image object from url */
		createImage: function(src) {
			var that = this,
				img;
			this.$gal.trigger('cfgallery-loading');
			img = this.preloadImage(src);
			img.load(function () {
				that.$gal.trigger('cfgallery-loaded');
			});

			return img;
		},

		preloadImage: function(src) {
			var img = new Image();
			img.src = src;
			img.alt = "";
			return $(img);
		},

		getSrcFromThumb: function(i) {
			return this.$thumbs.eq(i).find('img').attr('src');
		},

		/*
		Get the index of a thumb jQuery object in the set of thumb objects.
		@return int 0-x or -1 if not found. */
		getThumbIndex: function($thumb) {
			return this.$thumbs.index($thumb);
		},

		clickThumb: function(e) {
			var i = this.getThumbIndex(this),
				prevImg,
				nextImg,
				src;

			e.preventDefault();

			if (i > 1) {
				src = this.getSrcFromThumb(i - 1);
				prevImg = this.createImage(src);
			};
			if (i < this.$thumbs.length) {
				src = this.getSrcFromThumb(i + 1);
				nextImg = this.createImage(src);
			};
		}
	};
	/* Default args for gallery */
	gal.defaults = {
		fullSize: [710, 473],
		startAt: 0
	};
	
	$.fn.cfgallery = gal;
})(jQuery, window);