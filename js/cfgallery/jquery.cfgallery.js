/**
 * cfgallery - a light-weight, semantic gallery script with bookmarkable slides.
 */
;(function ($, win, docEl) {
	/* Local variable for hash makes lookups faster and is better for closure compiler */
	var loc = win.location;
	
	/* Constructor */
	var gal = function(options) {
		var opts = $.extend(options, gal.opts),
			fn = gal.fn,
			dim = opts.stageDimensions,
			stage;
			
		gal.opts = opts;

		if (this.length < 1) {
			return;
		};
		
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
		fn.$loading = $('<div class="loading">Loading...</div>')
			.hide()
			.appendTo(stage);
		
		fn.$stage = stage;
		
		// Bind thumb click
		fn.$thumbs.click(function(e){
			var i = fn.getThumbIndex(this);
			fn.show(i);
			e.preventDefault();
		});
		
		fn.$stage.bind('create.cfgal', function(e){
			fn.$loading.show();
		});
		fn.$stage.bind('loaded.cfgal', function(e){
			fn.$loading.hide();
		});
		
		// Bind window load to location hash
		$(win).load(function(){
			var ht = fn.getHashToken(),
				t,
				i;
			if (ht.length > 0) {
				t = fn.$thumbs.filter('#' + ht);
				if (t.length > 0) {
					i = fn.getThumbIndex(t);
					fn.show(i, false);
				};
			}
			else {
				fn.show(opts.start, false);
			};
		});
		
		$(docEl).keyup(function(e){
			// Right arrow
			if (e.keyCode === 39) {
				fn.showNext();
			}
			// Left arrow
			else if (e.keyCode === 37) {
				fn.showPrev();
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
		current: null, // int of active thumb
		loadedImages: [], // array of loaded images as jQuery objects
		
		show: function(i, setHash) {
			var that = this,
				$img,
				innerShow;
			
			innerShow = function (img) {
				var imgThumb = that.$thumbs.eq(i),
					c = gal.opts.activatedClass,
					current = that.current,
					$current;
				
				// Hide old and show new if both are present
				if (current !== null && current !== i) {
					$current = that.getImage(current);
					// Hide others
					that.$stage.children().not($current).hide();
					that.transitionSlides(img, $current);
				}
				// If there is no current (first load) just show.
				if (current === null) {
					that.transitionSlides(img);
				};
				
				that.$thumbs.removeClass(c);
				imgThumb.addClass(c);

				if (setHash !== false) {
					that.setHashToken(imgThumb.attr('id'));
				};
				
				that.current = i;
			};
			
			$img = this.getImage(i);
			if ($img === null) {
				$img = this.createImage(i);
				$img.bind('loaded.cfgal', function(e) {
					innerShow($(e.currentTarget));
				});
			}
			else {
				innerShow($img);
			};
		},
		
		showNext: function() {
			var i,
				max = this.$thumbs.length - 1;
			if (this.current < max) {
				i = this.current + 1;
			}
			else {
				i = 0;
			};
			this.show(i);
		},
		
		showPrev: function() {
			var i,
				max = this.$thumbs.length - 1;
			if (this.current > 0) {
				i = this.current - 1;
			}
			else {
				i = max;
			};
			this.show(i);
		},
		
		/* Allow transition to be overidden using Duck Punching */
		transitionSlides: function ($neue, $old) {
			if ($old !== null && typeof $old !== 'undefined') {
				$old.fadeOut('fast', function(){
					$neue.fadeIn('medium');
				});
			}
			else {
				$neue.fadeIn('medium');
			};
		},
		
		/* Set hash without jumping by prepending with "/" */
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
			if (!(this.loadedImages[i] instanceof jQuery)) { return null; };
			return this.loadedImages[i];
		},
		
		/* Get a full size image jQuery object by it's index.
		If the image doesn't exist yet, this function will create and append it based on the
		thumbnail list markup. */
		createImage: function(i) {
			var src, img;
			
			src = this.$thumbs.eq(i).data('largesrc');
			img = this.loadImage(src)
				.css({
					'position': 'absolute',
					/* Display none is safe, because we've already triggered image
					preload with loadImage() */
					'display': 'none',
					'left': '50%'
				})
				.appendTo(this.$stage)
				.trigger('create.cfgal')
				.load(function() {
					var t = $(this);
					t
						.css({
							// Add CSS for centering.
							'margin-left': -1 * (t.width() / 2)
						})
						.trigger('loaded.cfgal');
				});
			this.loadedImages[i] = img;
			return img;
		},

		loadImage: function(src) {
			var img = new Image(),
				$img;
			img.src = src;
			img.alt = "";
			return $(img);
		},

		/*
		Get the index of a thumb jQuery object in the set of thumb objects. */
		getThumbIndex: function($thumb) {
			return this.$thumbs.index($thumb);
		}
	};
	
	/* Default options for gallery */
	gal.opts = {
		stageDimensions: [710, 400],
		start: 0,
		activatedClass: 'activated'
	};
	
	/* Assign our object to the jQuery function namespace */
	$.fn.cfgallery = gal;
})(jQuery, window, document.documentElement);