/**
 * cfgallery - a light-weight, semantic gallery script with bookmarkable slides.
 */
;(function ($, win) {
	loc = win.location;
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
			fn.setHashToken($(this).attr('id'));
			e.preventDefault();
			e.stopPropagation();
		});
		
		// Bind window load to location hash
		$(win).load(function(){
			var t = fn.$thumbs.filter('#' + fn.getHashToken()),
				i;
			if (t.length > 0) {
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
		// $gal: Gallery div jQuery object
		// $stage: Stage div jQuery object
		// $thumbs: thumb array jQuery object
		current: 0, // int of active thumb
		loadedImages: [], // array of loaded images as jQuery objects
		
		updateStage: function(i) {
			var $img = this.getImage(i),
				$current = this.getImage(this.current),
				$siblings = this.$stage.children().not(this.loadedImages[this.current]);
			$siblings.hide();
			$current.fadeOut('fast', function(){
				$img.fadeIn('fast');
			});
			this.current = i;
		},
		
		// Set hash without jumping by prepending /
		setHashToken: function(str) {
			loc.hash = '/' + str;
		},
		
		getHashToken: function() {
			if (!loc.hash) {
				return '';
			};
			return loc.hash.slice(2);
		},
		
		getImage: function(i) {
			var src, img,
				that = this;
			// Preload image if we don't already have it in the array.
			if (!(this.loadedImages[i] instanceof jQuery)) {
				src = this.getSrcFromThumb(i);
				
				this.$gal.trigger('cfgallery-loading');
				
				img = this.loadImage(src)
					.css({
						'position': 'absolute'
					})
					.appendTo(this.$stage)
					.load(function () {
						that.$gal.trigger('cfgallery-loaded');
					});

				this.loadedImages[i] = img;
			};
			return this.loadedImages[i];
		},

		loadImage: function(src) {
			var img = new Image();
			img.src = src;
			img.alt = "";
			return $(img);
		},

		getSrcFromThumb: function(i) {
			return this.$thumbs.eq(i).data('largesrc');
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