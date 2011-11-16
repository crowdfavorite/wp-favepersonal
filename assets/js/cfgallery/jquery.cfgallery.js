/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
;(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$.browser.msie&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);

/**
 * cfgallery - a light-weight, semantic gallery script with bookmarkable slides.
 */
;(function ($, win) {
	/* Local variable for hash makes lookups faster and is better for closure compiler */
	var loc = win.location,
		docEl = win.document.documentElement,
		gal, helpers;
	
	/* Constructor */
	gal = function(options) {
		var opts = $.extend(gal.opts, options),
			fn = gal.helpers,
			dim = opts.stageDimensions,
			bgColor = opts.bgColor,
			stage;
			
		gal.opts = opts;

		if (this.length < 1) {
			return;
		};
		
		// Memoize gallery and thumbs for use later.
		fn.$gal = this;
		fn.$thumbs = this.find('ul a[href][id][data-largesrc]');
		
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
			'height': dim[1],
			'background-color': bgColor
		});
		fn.$loading = $('<div class="loading">Loading...</div>')
			.hide()
			.appendTo(stage);
		
		fn.$stage = stage;
		
		// Bind thumb click to change hash token
		fn.$thumbs.click(function(e){
			fn.setHashToken($(this).attr('id'));
			e.preventDefault();
		});
		
		stage.click(function (e) {
			fn.setNextHashToken();
			e.preventDefault();
		});
		
		$(docEl).keyup(function(e){
			// Right arrow
			if (e.keyCode === 39) {
				fn.setNextHashToken();
			}
			// Left arrow
			else if (e.keyCode === 37) {
				fn.setPrevHashToken();
			};
		});
		
		$(win)
			.hashchange(function(e){
				/* Change image on hashChange (relies on jquery.hashchange shim) */
				var id = fn.getHashToken();
				fn.exhibit(id);
			})
			.ready(function(){
				fn.patchHashToken();
			})
			.load(function(){
				/* If hash is set onload, show the appropriate image.
				If not, will show the start image. */
				var ht = fn.getHashToken();
				fn.exhibit(ht);
			});

		// Bind loading message to image create and loaded events.
		fn.$stage.bind('create.cfgal', function(e){
			fn.$loading.show();
		});
		fn.$stage.bind('loaded.cfgal', function(e){
			fn.$loading.hide();
		});
	};
	/* Default options for gallery */
	gal.opts = {
		stageDimensions: [710, 474],
		start: 0,
		activatedClass: 'activated',
		figureClass: 'gallery-figure',
		figcaptionClass: 'figcaption',
		captionClass: 'caption',
		titleClass: 'title',
		bgColor: '#000'
	};
	
	/* Helper functions. These live inside of an object so that
	"this" still points to the parent object (constructors the $.fn space get their
	"this" value set to the jQuery collection passed). Object literal object notation also
	compresses down a little better in Closure Compiler. */
	gal.helpers = {
		// $gal: Gallery div jQuery object
		// $stage: Stage div jQuery object
		// $thumbs: thumb array jQuery object
		current: null, // int of active thumb
		
		/* Show an image on the stage by it's thumb's ID token.
		- Loads image if not already loaded
		- Preloads it's siblings afterwords
		- Updates index of this.current */
		exhibit: function(token) {
			var that = this,
				$img,
				$thumb = $( '#' + (token || this.getToken()) ),
				i = this.getThumbIndex($thumb),
				callback;
			
			callback = function (img) {
				var c = gal.opts.activatedClass,
					current = this.current,
					$current;
				
				// Hide old and show new if both are present
				if (current !== null && current !== i) {
					$current = this.getImage(current);
					// Hide others
					this.$stage.children().not($current).hide();
					// Dequeue all animations before starting a new one.
					this.$stage.find('img').stop(true, true);
					this.transitionSlides(img, $current);
				}
				// If there is no current (first load) just show.
				if (current === null) {
					this.transitionSlides(img);
				};
				
				this.$thumbs.removeClass(c);
				$thumb.addClass(c);

				this.preloadNeighbors(i);
				this.current = i;
			};
			
			$img = this.getImage(i);
			if (typeof $img === 'undefined') {
				$img = this.createImage(i);
				$img.bind('loaded.cfgal', function(e) {
					callback.apply(that, [$(e.currentTarget)]);
				});
			}
			else {
				callback.apply(that, [$img]);
			};
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
		
		/* Get ID token from hash string */
		getHashToken: function(location) {
			l = location || loc.hash;
			if (!l) {
				return '';
			};
			return l.slice(2);
		},
		
		/* Set hash without jumping */
		setHashToken: function(str) {
			loc.hash = this.makeHashToken(str);
		},
		
		/* hash without jumping by prepending / to text */
		makeHashToken: function(str) {
			return '#/' + str;
		},
		
		/* Run this on DOMReady or similar
		Turns URLs with hashes anchored to gallery thumbs into #/foo URLs */
		patchHashToken: function() {
			var l = loc.hash;
			if (l.indexOf('#/') === -1 && this.$thumbs.filter(l).length > 0) {
				loc.hash = this.makeHashToken(l.replace('#', ''));
			};
		},
		
		setNextHashToken: function() {
			var i,
				max = this.$thumbs.length - 1,
				t;
			if (this.current < max) {
				i = this.current + 1;
			}
			else {
				i = 0;
			};
			t = this.getToken(i);
			this.setHashToken(t);
		},
		
		setPrevHashToken: function() {
			var i,
				max = this.$thumbs.length - 1,
				t;
			if (this.current > 0) {
				i = this.current - 1;
			}
			else {
				i = max;
			};
			t = this.getToken(i);
			this.setHashToken(t);
		},
		
		/*
		Get the index of a thumb jQuery object in the set of thumb objects. */
		getThumbIndex: function($thumb) {
			return this.$thumbs.index($thumb);
		},
		
		getToken: function(i) {
			var a = i || gal.opts.start;
			return this.$thumbs.eq(a).attr('id');
		},
		
		getImage: function(i) {
			return this.$thumbs.eq(i).data('cfgalExpanded');
		},
		
		getImageData: function ($thumb) {
			var $img = $thumb.find('img'),
				title = $img.attr('title'),
				caption = $img.attr('alt');

			/* Favor caption if they're the same */
			if (title === caption) {
				title = '';
			};

			return {
				src: $thumb.data('largesrc'),
				title: title,
				caption: caption
			};
		},
		
		/* Get a full size image jQuery object by it's index.
		If the image doesn't exist yet, this function will create and append it based on the
		thumbnail list markup. */
		createImage: function(i) {
			var data, $img, $wrapper, $title, $caption,
				opts = gal.opts,
				$thumb = this.$thumbs.eq(i),
				// Used in callback
				$stage = this.$stage,
				scale = this.scale;
			
			data = this.getImageData($thumb);
			
			$wrapper = $('<figure/>').addClass(opts.figureClass);

			if (data.title || data.caption) {
				$figcaption = $('<figcaption/>')
					.addClass(opts.figcaptionClass)
					.appendTo($wrapper);
				
				if (data.title) {
					$title = $('<div />')
						.addClass(opts.titleClass)
						.html(data.title)
						.appendTo($figcaption);
				};

				if (data.caption) {
					$caption = $('<div />')
						.addClass(opts.captionClass)
						.html(data.caption)
						.appendTo($figcaption);
				};
			};
			
			$img = this.loadImage(data.src)
				.css({
					/* We have to do a bit of a dance with image hide/show and centering
					Though the image is loaded through loadImage, making its width/height
					info available in most browsers, IE7 doesn't like to give us the w/h
					without the image being shown. We'll load and place it in the stage,
					then after loading is finished, we'll set w/h for centering and switch
					out visibility:hidden for display:none -- that way we can animate the
					image effectively. */
					'position': 'absolute',
					'left': '50%',
					'top': '50%',
					'visibility': 'hidden'
				})
				.trigger('create.cfgal')
				.load(function() {
					var t = $(this),
						dims = scale(
							[t.width(), t.height()],
							[$stage.width(), $stage.height()]
						);
					
					$wrapper.css({
						'width': dims[0],
						'height': dims[1],
						'display': 'none'
					});
					
					t
						.css({
							'width': dims[0],
							'height': dims[1],
							// Add CSS for centering.
							'margin-left': -1 * (dims[0] / 2),
							'margin-top': -1 * (dims[1] / 2),
							'visibility': 'visible'
						})
						.trigger('loaded.cfgal');
				});
			
			$img.prependTo($wrapper);
			$wrapper.appendTo($stage);
			
			$thumb.data('cfgalExpanded', $wrapper);
			return $wrapper;
		},
		
		preloadNeighbors: function(index) {
			var check = [1, 2, -1],
				max = this.$thumbs.length -1,
				i,
				a;
			for (i = check.length - 1; i >= 0; i--){
				a = index + check[i];
				if (a >= 0 && a <= max && !this.getImage(a)) {
					this.createImage(a);
				};
			};
		},

		loadImage: function(src) {
			var img = new Image(),
				$img;
			img.src = src;
			img.alt = "";
			return $(img);
		},
		
		/**
		 * Proportional scale for image dimensions.
		 * @param array dims [w,h]
		 * @param array boundaries [w,h]
		 * @return array scaled [w,h]
		 */
		scale: function(dims, boundaries) {
			var factor,
				/* @param bywidth: true = width, false = height */
				scaleby = function(bywidth) {
					var x, y;
					if (bywidth) {
						x = 0;
						y = 1;
					}
					else {
						x = 1;
						y = 0;
					}
					
					factor = boundaries[x] / dims[x];
					dims[x] = boundaries[x];
					dims[y] = Math.ceil(dims[y] * factor);
					return dims;
				};
			if (dims[0] > boundaries[0]) {
				return scaleby(true);
			};
			if (dims[1] > boundaries[1]) {
				return scaleby(false);
			};
			return dims;
		},
		
		/* Copyright (c) 2011 Jed Schmidt, http://jed.is
		https://gist.github.com/964849
		Released under MIT license */
		parseUrl: function(a){return function(b,c,d){a.href=b;c={};for(d in a)if(typeof a[d]=="string")c[d]=a[d];return c}}(document.createElement("a"))
	};
	
	// Export gal object as jQuery plugin.
	$.fn.cfgallery = gal;
	
	$.fn.cfShimLinkHash = function() {
		var fn = gal.helpers;
		if (this.length > 0) {
			this.filter('a').each(function(){
				var t = $(this),
					a = fn.parseUrl(t.attr('href')),
					token = fn.makeHashToken(a.hash.replace('#', ''));
					t.attr('href', a.href.replace(a.hash, token));
			});
		};
	};
})(jQuery, window);