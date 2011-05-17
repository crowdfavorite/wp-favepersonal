/**
 * cfgallery - a light-weight, semantic gallery script with bookmarkable slides.
 */
;(function ($, win) {
	var gal = function(options) {
		var opts = $.extend(options, gal.defaults),
			fn = gal.fn,
			dim = opts.stageDimensions,
			stage;
		
		// Memoize gallery and thumbs for use later.
		fn.$gal = this;
		fn.$thumbs = this.find('ul a[href][id]');
		
		// Stage setup. Look for a div if one is provided.
		stage = this.find('.gallery-stage');
		// Create a stage if not.
		if (stage.length < 1) {
			stage = $('<div class="gallery-stage" />');
			this.prepend(stage);
		};
		stage.css({
			'position': 'relative',
			'width': dim[0],
			'height': dim[1]
		});
		
		fn.$stage = stage;
		
		fn.updateStage(opts.startAt);
		
		// Bind thumb click
		fn.$thumbs.click(function(e){
			var i = fn.getThumbIndex(this);
			fn.updateStage(i);
			e.preventDefault();
		});
		
		// Bind window load to location hash
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
				$img = this.createImage(src),
				$nextImg = this.preloadImage(nextSrc);

			this.$stage.append($img);
		},

		/* Create and extend an image object from url */
		createImage: function(src) {
			var that = this,
				img;
			this.$gal.trigger('cfgallery-loading');
			img = this.preloadImage(src)
				.load(function () {
					that.$gal.trigger('cfgallery-loaded');
				})
				.css({
					'position': 'absolute'
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
		}
	};
	/* Default args for gallery */
	gal.defaults = {
		stageDimensions: [710, 473],
		startAt: 0
	};
	
	$.fn.cfgallery = gal;
})(jQuery, window);