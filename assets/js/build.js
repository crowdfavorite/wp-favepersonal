/* Modernizr 2.0.6 (Custom Build) | MIT & BSD
 * Contains: touch | iepp | cssclasses | teststyles | prefixes
 */
;window.Modernizr=function(a,b,c){function z(a,b){return!!~(""+a).indexOf(b)}function y(a,b){return typeof a===b}function x(a,b){return w(n.join(a+";")+(b||""))}function w(a){k.cssText=a}var d="2.0.6",e={},f=!0,g=b.documentElement,h=b.head||b.getElementsByTagName("head")[0],i="modernizr",j=b.createElement(i),k=j.style,l,m=Object.prototype.toString,n=" -webkit- -moz- -o- -ms- -khtml- ".split(" "),o={},p={},q={},r=[],s=function(a,c,d,e){var f,h,j,k=b.createElement("div");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:i+(d+1),k.appendChild(j);f=["&shy;","<style>",a,"</style>"].join(""),k.id=i,k.innerHTML+=f,g.appendChild(k),h=c(k,a),k.parentNode.removeChild(k);return!!h},t,u={}.hasOwnProperty,v;!y(u,c)&&!y(u.call,c)?v=function(a,b){return u.call(a,b)}:v=function(a,b){return b in a&&y(a.constructor.prototype[b],c)};var A=function(c,d){var f=c.join(""),g=d.length;s(f,function(c,d){var f=b.styleSheets[b.styleSheets.length-1],h=f.cssRules&&f.cssRules[0]?f.cssRules[0].cssText:f.cssText||"",i=c.childNodes,j={};while(g--)j[i[g].id]=i[g];e.touch="ontouchstart"in a||j.touch.offsetTop===9},g,d)}([,["@media (",n.join("touch-enabled),("),i,")","{#touch{top:9px;position:absolute}}"].join("")],[,"touch"]);o.touch=function(){return e.touch};for(var B in o)v(o,B)&&(t=B.toLowerCase(),e[t]=o[B](),r.push((e[t]?"":"no-")+t));w(""),j=l=null,a.attachEvent&&function(){var a=b.createElement("div");a.innerHTML="<elem></elem>";return a.childNodes.length!==1}()&&function(a,b){function s(a){var b=-1;while(++b<g)a.createElement(f[b])}a.iepp=a.iepp||{};var d=a.iepp,e=d.html5elements||"abbr|article|aside|audio|canvas|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",f=e.split("|"),g=f.length,h=new RegExp("(^|\\s)("+e+")","gi"),i=new RegExp("<(/*)("+e+")","gi"),j=/^\s*[\{\}]\s*$/,k=new RegExp("(^|[^\\n]*?\\s)("+e+")([^\\n]*)({[\\n\\w\\W]*?})","gi"),l=b.createDocumentFragment(),m=b.documentElement,n=m.firstChild,o=b.createElement("body"),p=b.createElement("style"),q=/print|all/,r;d.getCSS=function(a,b){if(a+""===c)return"";var e=-1,f=a.length,g,h=[];while(++e<f){g=a[e];if(g.disabled)continue;b=g.media||b,q.test(b)&&h.push(d.getCSS(g.imports,b),g.cssText),b="all"}return h.join("")},d.parseCSS=function(a){var b=[],c;while((c=k.exec(a))!=null)b.push(((j.exec(c[1])?"\n":c[1])+c[2]+c[3]).replace(h,"$1.iepp_$2")+c[4]);return b.join("\n")},d.writeHTML=function(){var a=-1;r=r||b.body;while(++a<g){var c=b.getElementsByTagName(f[a]),d=c.length,e=-1;while(++e<d)c[e].className.indexOf("iepp_")<0&&(c[e].className+=" iepp_"+f[a])}l.appendChild(r),m.appendChild(o),o.className=r.className,o.id=r.id,o.innerHTML=r.innerHTML.replace(i,"<$1font")},d._beforePrint=function(){p.styleSheet.cssText=d.parseCSS(d.getCSS(b.styleSheets,"all")),d.writeHTML()},d.restoreHTML=function(){o.innerHTML="",m.removeChild(o),m.appendChild(r)},d._afterPrint=function(){d.restoreHTML(),p.styleSheet.cssText=""},s(b),s(l);d.disablePP||(n.insertBefore(p,n.firstChild),p.media="print",p.className="iepp-printshim",a.attachEvent("onbeforeprint",d._beforePrint),a.attachEvent("onafterprint",d._afterPrint))}(a,b),e._version=d,e._prefixes=n,e.testStyles=s,g.className=g.className.replace(/\bno-js\b/,"")+(f?" js "+r.join(" "):"");return e}(this,this.document);/*
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
		
		/* Get a full size image jQuery object by it's index.
		If the image doesn't exist yet, this function will create and append it based on the
		thumbnail list markup. */
		createImage: function(i) {
			var src, img,
				$thumb = this.$thumbs.eq(i),
				// Used in callback
				$stage = this.$stage,
				scale = this.scaleWithin;
			
			src = $thumb.data('largesrc');
			img = this.loadImage(src)
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
				.appendTo($stage)
				.trigger('create.cfgal')
				.load(function() {
					var t = $(this),
						dims = scale([t.width(), t.height()], [$stage.width(), $stage.height()]);
					t
						.css({
							'width': dims[0],
							'height': dims[1],
							// Add CSS for centering.
							'margin-left': -1 * (dims[0] / 2),
							'margin-top': -1 * (dims[1] / 2),
							'visibility': 'visible',
							'display': 'none'
						})
						.trigger('loaded.cfgal');
				});
			$thumb.data('cfgalExpanded', img);
			return img;
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
		 * Proportial scale for image dimensions.
		 * @param array dims [w,h]
		 * @param array boundaries [w,h]
		 * @return array scaled [w,h]
		 */
		scaleWithin: function(dims, boundaries) {
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
})(jQuery, window);jQuery(function($) {
	var activate = (Modernizr.touch ? 'touchend' : 'click');
	$('#nav-main h1')
		.bind(activate, function(e){
			$('#nav-main .menu').toggleClass('open');
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
	var $gal = $('.cfgallery'),
		viewportW = $(window).width(),
		scale = $.fn.cfgallery.helpers.scaleWithin,
		dims = [];
	
	dims[0] = (typeof cfcpGalleryWidth === 'undefined' ? 710 : cfcpGalleryWidth);
	dims[1] = (typeof cfcpGalleryHeight === 'undefined' ? 474 : cfcpGalleryHeight);
	
	// Proportional scale based on screen size
	if (viewportW < 480) {
		dims = scale(dims, [300, 999]);
		$gal.addClass('mobile-portrait');
	}
	// iPhone Landscape
	else if (viewportW < 768) {
		dims = scale(dims, [460, 999]);
		$gal.addClass('mobile-landscape');
	}
	
	$gal.cfgallery({
		'stageDimensions': dims
	});
	$('.gallery-img-excerpt li:not(.gallery-view-all) a').cfShimLinkHash();
});(function($) {
$.fn.oTypeAhead = function(options) {
	var defaults = {
		url: null, // will use URL of form if not set
		searchParams: {},
		delay: 300, // ms
		timeout: 2000, // ms
		loading: '<div class="otypeahead-loading">Loading...</div>',
		target: '', // jQuery selector
		items: 'li', // jQuery selector
		disableForm: true,
		form: 'form',
		resultsCallback: function($target) {
			$target.find(options.items).bind('otypeahead-select', function() {
				switch ($(this).data('otypeahead-select-mode')) {
					case 'edit':
						var url = $(this).attr('data-url-edit');
						break;
					case 'view':
						var url = $(this).attr('data-url-view');
						break;
					default:
						var url = $(this).find('a').attr('href');
				}
				if (typeof url != 'undefined') {
					location.href = url;
				}
			});
		},
		typeAheadTrigger: function(sel, term) {
			$field = jQuery(sel);
			if (term == $field.val()) {
				$field.trigger('search');
			}
		}
	};
			
	var options = $.extend(defaults, options);
	return this.attr('autocomplete', 'off').click(function() {
		return false;
	}).each(function() {
		$(this).data('otypeahead-queue', {}).data('otypeahead-cache', {}).data('otypeahead-key', '');
		var $form = $(this).closest(options.form);
		if (options.disableForm) {
			$(this).closest('form').submit( function() {
				return false;
			});
		}
		else {
			$(this).bind('keypress', function(evt) {
				// if not disabling the entire form, just disable enter on this element
				if (evt.which == 13) {
					return false;
				}
				return true;
			});
		}
// set default URL if none passed in
		var url = options.url;
		if (!url) {
			url = $form.attr('action');
		}
// set default target if none passed in
		var $target = $(options.target);
		if (!$target.size()) {
			$target = $form.find('.otypeahead-results');
		}
		if (!$target.size()) {
// still no target, create one
			$(this).after('<div class="otypeahead-results"></div>');
			$target = $form.find('.otypeahead-results');
		}
		$target.addClass('otypeahead-target');
		$('body').click(function() {
			$target.hide();
		});

		$(this).bind('search', function() {
			var $this = $(this);
			var term = $this.val();
// check cache
			var key = url + term;
			$this.data('otypeahead-key', key);
			var queue = $this.data('otypeahead-queue');
			var cache = $this.data('otypeahead-cache');
			if (key in (cache)) {
// set from cache
				$target.html(cache[key]).show();
				options.resultsCallback.call(this, $target);
			}
			else {
				var now = new Date;
				var queued = false;
// check queue
				if (key in (queue) && queue[key].indexOf('pending') != -1) {
					queued = true;
					var requested = queue[key].replace('pending-', '');
					if ((now.getTime() - requested) > options.timeout) {
						queue[key] = 'timeout';
						$this.data('otypeahead-queue', queue);
					}
					else {
						queued = true;
					}
				}
// do search
				if (!queued) {
					$target.html(options.loading).slideDown('fast');
					queue[key] = 'pending-' + now.getTime();
					params = $.extend({}, options.searchParams); // stops options.searchParams from being passed by reference (?! WTF!)
					params['key'] = key;
					params[$(this).attr('name')] = term;
					$.post(
						url,
						params,
						function(response) {
// only show if response matches current search
							if ($this.data('otypeahead-key') == response.key) {
								$target.html(response.html);
								options.resultsCallback.call(self, $target); // changed this to self to pass whole object instead of just the ajax request
							}
// refresh data and add to it
							cache = $this.data('otypeahead-cache');
							cache[key] = response.html;
							$this.data('otypeahead-cache', cache);
							queue = $this.data('otypeahead-queue');
							queue[key] = 'complete';
							$this.data('otypeahead-queue', queue);
						},
						'json'
					);
				}
			}
		}).keyup(function(e) {
			term = $(this).val();
// catch everything except up/down arrow
			$current = $target.find(options.items).filter('.otypeahead-current');
			var _this = this;
			switch (e.which) {
				case 27: // esc
					$target.slideUp('fast', function() {
						$(this).html('');
					});
					e.stopPropagation();
					break;
				case 16: // shift
					$current.data('otypeahead-select-mode', '');
					break;
				case 13: // enter
					if ($current.size()) {
// select item
						$current.trigger('otypeahead-select').each(function() {
							$target.hide().html('');
						});
					}
					else {
// trigger search
						setTimeout(function() {
							options.typeAheadTrigger('#' + $(_this).attr('id'), $.escape(term));
						}, 0);
					}
					return false;
					break;
				case 37: // left
				case 38: // up
				case 39: // right
				case 40: // down
					// do nothing
					break;
				default:
					if (term == '') {
// hide results
						$target.hide().html('');
					}
					else {
// trigger search		
						setTimeout(function() {
							options.typeAheadTrigger('#' + $(_this).attr('id'), $.escape(term));
						}, options.delay);
					}
					break;
			}
		}).keydown(function(e) {
// catch arrow up/down here
			var $items = $target.find(options.items);
			if ($items.size()) {
				var $current = $items.filter('.otypeahead-current');
				switch (e.which) {
					case 16: // shift
						if ($current.size()) {
							$current.data('otypeahead-select-mode', 'edit');
						}
						break;
					case 40: // down
						if (!$current.size()) {
							$item = $items.filter(':first');
							$item.addClass('otypeahead-current');
							$item.parent().animate({scrollTop: '0'}, 200);
						}
						else {
							var i = 0;
							$items.each(function() {
								if ($(this).hasClass('otypeahead-current')) {
									$(this).removeClass('otypeahead-current');
									var $item = $($items[i + 1]);
									if ($item.size()) {
										$item.addClass('otypeahead-current');
										$scroll = $item.parent();
										oTypeAheadScroll($scroll, $item);
									}
									return false;
								}
								i++;
							});
							// $items.filter('.otypeahead-current').removeClass('otypeahead-current').next().addClass('otypeahead-current');
						}
						return false;
						break;
					case 38: // up
						if (!$current.size()) {
							$item = $items.filter(':last');
							$item.addClass('otypeahead-current');
							oTypeAheadScroll($item.parent(), $item);
						}
						else {
							var i = 0;
							$items.each(function() {
								if ($(this).hasClass('otypeahead-current')) {
									$(this).removeClass('otypeahead-current');
									var $item = $($items[i - 1]);
									if ($item.size()) {
										$item.addClass('otypeahead-current');
										$scroll = $item.parent();
										oTypeAheadScroll($scroll, $item);
									}
									return false;
								}
								i++;
							});
							// $items.filter('.otypeahead-current').removeClass('otypeahead-current').prev().addClass('otypeahead-current');
						}
						return false;
						break;
				}
			}
		});
	});
};
})(jQuery);

// jquery.escape 1.0 - escape strings for use in jQuery selectors
// http://ianloic.com/tag/jquery.escape
// Copyright 2009 Ian McKellar <http://ian.mckellar.org/>
// Just like jQuery you can use it under either the MIT license or the GPL
// (see: http://docs.jquery.com/License)
(function() {
escape_re = /[#;&,\.\+\*~':"!\^\$\[\]\(\)=>|\/\\]/;
jQuery.escape = function jQuery$escape(s) {
  var left = s.split(escape_re, 1)[0];
  if (left == s) return s;
  return left + '\\' + 
    s.substr(left.length, 1) + 
    jQuery.escape(s.substr(left.length+1));
};
})();

function oTypeAheadScroll($scroll, $item) {
// if hidden, bottom - position to 5 up from visible bottom
// if hidden, top - position to 4 down from visible top
	var itemTop = Math.floor($item.offset().top);
	var itemHeight = Math.ceil($item.height());
	var scrollHeight = Math.ceil($scroll.height());
	var scrollTop = Math.floor($scroll.scrollTop());
	if (itemTop - itemHeight * 2 < 0) {
// console.log('off top: ' + itemTop + ' : ' + scrollTop);
// scroll up - itemTop is negative, so actually subtracting that amount from scrollTop
		$scroll.animate({scrollTop: (scrollTop + itemTop - itemHeight * 8) + 'px'}, 200);
	}
	else if (itemTop > scrollHeight) {
// console.log('off bottom: ' + itemTop + ' : ' + scrollTop);
// scroll down - add scrollHeight + scrollTop to get accurate position
		$scroll.animate({scrollTop: (itemTop - scrollHeight + scrollTop + itemHeight * 7) + 'px'}, 200);
	}
//	else {
// console.log('visible: ' + itemTop + ' : ' + $scroll.scrollTop());
// do nothing
//	}
}