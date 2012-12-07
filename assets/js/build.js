/* Modernizr 2.0.6 (Custom Build) | MIT & BSD
 * Contains: touch | iepp | cssclasses | teststyles | prefixes
 */
;window.Modernizr=function(a,b,c){function z(a,b){return!!~(""+a).indexOf(b)}function y(a,b){return typeof a===b}function x(a,b){return w(n.join(a+";")+(b||""))}function w(a){k.cssText=a}var d="2.0.6",e={},f=!0,g=b.documentElement,h=b.head||b.getElementsByTagName("head")[0],i="modernizr",j=b.createElement(i),k=j.style,l,m=Object.prototype.toString,n=" -webkit- -moz- -o- -ms- -khtml- ".split(" "),o={},p={},q={},r=[],s=function(a,c,d,e){var f,h,j,k=b.createElement("div");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:i+(d+1),k.appendChild(j);f=["&shy;","<style>",a,"</style>"].join(""),k.id=i,k.innerHTML+=f,g.appendChild(k),h=c(k,a),k.parentNode.removeChild(k);return!!h},t,u={}.hasOwnProperty,v;!y(u,c)&&!y(u.call,c)?v=function(a,b){return u.call(a,b)}:v=function(a,b){return b in a&&y(a.constructor.prototype[b],c)};var A=function(c,d){var f=c.join(""),g=d.length;s(f,function(c,d){var f=b.styleSheets[b.styleSheets.length-1],h=f.cssRules&&f.cssRules[0]?f.cssRules[0].cssText:f.cssText||"",i=c.childNodes,j={};while(g--)j[i[g].id]=i[g];e.touch="ontouchstart"in a||j.touch.offsetTop===9},g,d)}([,["@media (",n.join("touch-enabled),("),i,")","{#touch{top:9px;position:absolute}}"].join("")],[,"touch"]);o.touch=function(){return e.touch};for(var B in o)v(o,B)&&(t=B.toLowerCase(),e[t]=o[B](),r.push((e[t]?"":"no-")+t));w(""),j=l=null,a.attachEvent&&function(){var a=b.createElement("div");a.innerHTML="<elem></elem>";return a.childNodes.length!==1}()&&function(a,b){function s(a){var b=-1;while(++b<g)a.createElement(f[b])}a.iepp=a.iepp||{};var d=a.iepp,e=d.html5elements||"abbr|article|aside|audio|canvas|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",f=e.split("|"),g=f.length,h=new RegExp("(^|\\s)("+e+")","gi"),i=new RegExp("<(/*)("+e+")","gi"),j=/^\s*[\{\}]\s*$/,k=new RegExp("(^|[^\\n]*?\\s)("+e+")([^\\n]*)({[\\n\\w\\W]*?})","gi"),l=b.createDocumentFragment(),m=b.documentElement,n=m.firstChild,o=b.createElement("body"),p=b.createElement("style"),q=/print|all/,r;d.getCSS=function(a,b){if(a+""===c)return"";var e=-1,f=a.length,g,h=[];while(++e<f){g=a[e];if(g.disabled)continue;b=g.media||b,q.test(b)&&h.push(d.getCSS(g.imports,b),g.cssText),b="all"}return h.join("")},d.parseCSS=function(a){var b=[],c;while((c=k.exec(a))!=null)b.push(((j.exec(c[1])?"\n":c[1])+c[2]+c[3]).replace(h,"$1.iepp_$2")+c[4]);return b.join("\n")},d.writeHTML=function(){var a=-1;r=r||b.body;while(++a<g){var c=b.getElementsByTagName(f[a]),d=c.length,e=-1;while(++e<d)c[e].className.indexOf("iepp_")<0&&(c[e].className+=" iepp_"+f[a])}l.appendChild(r),m.appendChild(o),o.className=r.className,o.id=r.id,o.innerHTML=r.innerHTML.replace(i,"<$1font")},d._beforePrint=function(){p.styleSheet.cssText=d.parseCSS(d.getCSS(b.styleSheets,"all")),d.writeHTML()},d.restoreHTML=function(){o.innerHTML="",m.removeChild(o),m.appendChild(r)},d._afterPrint=function(){d.restoreHTML(),p.styleSheet.cssText=""},s(b),s(l);d.disablePP||(n.insertBefore(p,n.firstChild),p.media="print",p.className="iepp-printshim",a.attachEvent("onbeforeprint",d._beforePrint),a.attachEvent("onafterprint",d._afterPrint))}(a,b),e._version=d,e._prefixes=n,e.testStyles=s,g.className=g.className.replace(/\bno-js\b/,"")+(f?" js "+r.join(" "):"");return e}(this,this.document);/**
 * Placeholder
 * Crowd Favorite
 * @requires jQuery v1.2 or above
 *
 * Version: 1.1
 * Patches the HTML5 placeholder atttribute functionality for browsers that don't support it
 */
(function(c){c.fn.placeholder=function(f){var g=c.extend({},c.fn.placeholder.settings,f);var e=null;var h=function(){c("["+g.attribute+"]."+g.classname).val("")};if(g.attribute=="placeholder"&&g.disableIfSupported==true&&"placeholder" in document.createElement("input")){return}if("undefined"===typeof document.activeElement){if(c().jquery.split(".")>="1.6".split(".")){e=c(c("*:focus").get(0))}}else{e=c(document.activeElement)}this.each(function(){var i=c(this);i.focus(function(){b(i,g)});i.blur(function(){d(i,g)});i.blur();i.parents("form").submit(function(){});if(i.filter(c(e)).length){c(e).focus()}});c(window).unbind("unload",h);c(window).unload(h)};c.fn.placeholder.settings={classname:"cfp-placeholder",attribute:"placeholder",disableIfSupported:true};c.placeholders=function(e){var f=c.extend({},c.fn.placeholder.settings,e);c("["+f.attribute+"]").placeholder(f)};function b(e,f){e=c(e);if(e.hasClass(f.classname)){e.val("");e.removeClass(f.classname)}}function d(e,f){e=c(e);if(e.val()===""){e.addClass(f.classname);e.val(e.attr(f.attribute))}}function a(f,e){c(f).find("["+e.attribute+"]").each(function(){var g=c(this);if(g.hasClass(e.classname)){g.val("")}})}})(jQuery);/*global jQuery *//*! 
* FitVids 1.0
*
* Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/(function(a){a.fn.fitVids=function(b){var c={customSelector:null},d=document.createElement("div"),e=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0];return d.className="fit-vids-style",d.innerHTML="&shy;<style>               .fluid-width-video-wrapper {                 width: 100%;                              position: relative;                       padding: 0;                            }                                                                                   .fluid-width-video-wrapper iframe,        .fluid-width-video-wrapper object,        .fluid-width-video-wrapper embed {           position: absolute;                       top: 0;                                   left: 0;                                  width: 100%;                              height: 100%;                          }                                       </style>",e.parentNode.insertBefore(d,e),b&&a.extend(c,b),this.each(function(){var b=["iframe[src^='http://player.vimeo.com']","iframe[src^='http://www.youtube.com']","iframe[src^='http://www.kickstarter.com']","object","embed"];c.customSelector&&b.push(c.customSelector);var d=a(this).find(b.join(","));d.each(function(){var b=a(this),c=this.tagName=="OBJECT"?b.attr("height"):b.height(),d=c/b.width();b.wrap('<div class="fluid-width-video-wrapper" />').parent(".fluid-width-video-wrapper").css("padding-top",d*100+"%"),b.removeAttr("height").removeAttr("width")})})}})(jQuery);/*!
 * cfgallery - a light-weight, semantic gallery script with bookmarkable slides.
 * version 1.0
 *
 * Copyright (c) 2011-2012 Crowd Favorite (http://crowdfavorite.com)
 */
/*!
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
;(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$.browser.msie&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);

/*! jQuery Mobile (touch support only) v1.2.0 jquerymobile.com | jquery.org/license */
;(function(a,b,c){typeof define=="function"&&define.amd?define(["jquery"],function(d){return c(d,a,b),d.mobile}):c(a.jQuery,a,b)})(this,document,function(a,b,c,d){(function(a,b){var d={touch:"ontouchend"in c};a.mobile=a.mobile||{},a.mobile.support=a.mobile.support||{},a.extend(a.support,d),a.extend(a.mobile.support,d)})(a),function(a,b,c,d){function x(a){while(a&&typeof a.originalEvent!="undefined")a=a.originalEvent;return a}function y(b,c){var e=b.type,f,g,i,k,l,m,n,o,p;b=a.Event(b),b.type=c,f=b.originalEvent,g=a.event.props,e.search(/^(mouse|click)/)>-1&&(g=j);if(f)for(n=g.length,k;n;)k=g[--n],b[k]=f[k];e.search(/mouse(down|up)|click/)>-1&&!b.which&&(b.which=1);if(e.search(/^touch/)!==-1){i=x(f),e=i.touches,l=i.changedTouches,m=e&&e.length?e[0]:l&&l.length?l[0]:d;if(m)for(o=0,p=h.length;o<p;o++)k=h[o],b[k]=m[k]}return b}function z(b){var c={},d,f;while(b){d=a.data(b,e);for(f in d)d[f]&&(c[f]=c.hasVirtualBinding=!0);b=b.parentNode}return c}function A(b,c){var d;while(b){d=a.data(b,e);if(d&&(!c||d[c]))return b;b=b.parentNode}return null}function B(){r=!1}function C(){r=!0}function D(){v=0,p.length=0,q=!1,C()}function E(){B()}function F(){G(),l=setTimeout(function(){l=0,D()},a.vmouse.resetTimerDuration)}function G(){l&&(clearTimeout(l),l=0)}function H(b,c,d){var e;if(d&&d[b]||!d&&A(c.target,b))e=y(c,b),a(c.target).trigger(e);return e}function I(b){var c=a.data(b.target,f);if(!q&&(!v||v!==c)){var d=H("v"+b.type,b);d&&(d.isDefaultPrevented()&&b.preventDefault(),d.isPropagationStopped()&&b.stopPropagation(),d.isImmediatePropagationStopped()&&b.stopImmediatePropagation())}}function J(b){var c=x(b).touches,d,e;if(c&&c.length===1){d=b.target,e=z(d);if(e.hasVirtualBinding){v=u++,a.data(d,f,v),G(),E(),o=!1;var g=x(b).touches[0];m=g.pageX,n=g.pageY,H("vmouseover",b,e),H("vmousedown",b,e)}}}function K(a){if(r)return;o||H("vmousecancel",a,z(a.target)),o=!0,F()}function L(b){if(r)return;var c=x(b).touches[0],d=o,e=a.vmouse.moveDistanceThreshold,f=z(b.target);o=o||Math.abs(c.pageX-m)>e||Math.abs(c.pageY-n)>e,o&&!d&&H("vmousecancel",b,f),H("vmousemove",b,f),F()}function M(a){if(r)return;C();var b=z(a.target),c;H("vmouseup",a,b);if(!o){var d=H("vclick",a,b);d&&d.isDefaultPrevented()&&(c=x(a).changedTouches[0],p.push({touchID:v,x:c.clientX,y:c.clientY}),q=!0)}H("vmouseout",a,b),o=!1,F()}function N(b){var c=a.data(b,e),d;if(c)for(d in c)if(c[d])return!0;return!1}function O(){}function P(b){var c=b.substr(1);return{setup:function(d,f){N(this)||a.data(this,e,{});var g=a.data(this,e);g[b]=!0,k[b]=(k[b]||0)+1,k[b]===1&&t.bind(c,I),a(this).bind(c,O),s&&(k.touchstart=(k.touchstart||0)+1,k.touchstart===1&&t.bind("touchstart",J).bind("touchend",M).bind("touchmove",L).bind("scroll",K))},teardown:function(d,f){--k[b],k[b]||t.unbind(c,I),s&&(--k.touchstart,k.touchstart||t.unbind("touchstart",J).unbind("touchmove",L).unbind("touchend",M).unbind("scroll",K));var g=a(this),h=a.data(this,e);h&&(h[b]=!1),g.unbind(c,O),N(this)||g.removeData(e)}}}var e="virtualMouseBindings",f="virtualTouchID",g="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),h="clientX clientY pageX pageY screenX screenY".split(" "),i=a.event.mouseHooks?a.event.mouseHooks.props:[],j=a.event.props.concat(i),k={},l=0,m=0,n=0,o=!1,p=[],q=!1,r=!1,s="addEventListener"in c,t=a(c),u=1,v=0,w;a.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500};for(var Q=0;Q<g.length;Q++)a.event.special[g[Q]]=P(g[Q]);s&&c.addEventListener("click",function(b){var c=p.length,d=b.target,e,g,h,i,j,k;if(c){e=b.clientX,g=b.clientY,w=a.vmouse.clickDistanceThreshold,h=d;while(h){for(i=0;i<c;i++){j=p[i],k=0;if(h===d&&Math.abs(j.x-e)<w&&Math.abs(j.y-g)<w||a.data(h,f)===j.touchID){b.preventDefault(),b.stopPropagation();return}}h=h.parentNode}}},!0)}(a,b,c),function(a,b,d){function j(b,c,d){var e=d.type;d.type=c,a.event.handle.call(b,d),d.type=e}a.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "),function(b,c){a.fn[c]=function(a){return a?this.bind(c,a):this.trigger(c)},a.attrFn&&(a.attrFn[c]=!0)});var e=a.mobile.support.touch,f="touchmove scroll",g=e?"touchstart":"mousedown",h=e?"touchend":"mouseup",i=e?"touchmove":"mousemove";a.event.special.scrollstart={enabled:!0,setup:function(){function g(a,c){d=c,j(b,d?"scrollstart":"scrollstop",a)}var b=this,c=a(b),d,e;c.bind(f,function(b){if(!a.event.special.scrollstart.enabled)return;d||g(b,!0),clearTimeout(e),e=setTimeout(function(){g(b,!1)},50)})}},a.event.special.tap={tapholdThreshold:750,setup:function(){var b=this,d=a(b);d.bind("vmousedown",function(e){function i(){clearTimeout(h)}function k(){i(),d.unbind("vclick",l).unbind("vmouseup",i),a(c).unbind("vmousecancel",k)}function l(a){k(),f===a.target&&j(b,"tap",a)}if(e.which&&e.which!==1)return!1;var f=e.target,g=e.originalEvent,h;d.bind("vmouseup",i).bind("vclick",l),a(c).bind("vmousecancel",k),h=setTimeout(function(){j(b,"taphold",a.Event("taphold",{target:f}))},a.event.special.tap.tapholdThreshold)})}},a.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:75,setup:function(){var b=this,c=a(b);c.bind(g,function(b){function j(b){if(!f)return;var c=b.originalEvent.touches?b.originalEvent.touches[0]:b;g={time:(new Date).getTime(),coords:[c.pageX,c.pageY]},Math.abs(f.coords[0]-g.coords[0])>a.event.special.swipe.scrollSupressionThreshold&&b.preventDefault()}var e=b.originalEvent.touches?b.originalEvent.touches[0]:b,f={time:(new Date).getTime(),coords:[e.pageX,e.pageY],origin:a(b.target)},g;c.bind(i,j).one(h,function(b){c.unbind(i,j),f&&g&&g.time-f.time<a.event.special.swipe.durationThreshold&&Math.abs(f.coords[0]-g.coords[0])>a.event.special.swipe.horizontalDistanceThreshold&&Math.abs(f.coords[1]-g.coords[1])<a.event.special.swipe.verticalDistanceThreshold&&f.origin.trigger("swipe").trigger(f.coords[0]>g.coords[0]?"swipeleft":"swiperight"),f=g=d})})}},a.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe",swiperight:"swipe"},function(b,c){a.event.special[b]={setup:function(){a(this).bind(c,a.noop)}}})}(a,this)});

;(function($) {
	/* Local variable for hash makes lookups faster and is better for closure compiler */
	var loc = window.location,
		docEl = window.document.documentElement,
		stageCounter = 0;
	
	/* Constructor */
	var gal = function(options) {
		var opts = $.extend(gal.opts, options),
			fn = gal.helpers,
			dim = opts.stageDimensions,
			bgColor = opts.bgColor,
			currentStageId = 0;
		
		gal.opts = opts;

		if (this.length < 1) {
			return;
		};

		this.each(function() {
			var gallery = $(this);
			var stageId = stageCounter++;

			// Stage setup. Look for a div if one is provided.
			var stage = $('.gallery-stage', this);

			// Create a stage if not.
			if (stage.length < 1) {
				stage = $('<div class="gallery-stage" />').appendTo(this);
			};

			stage.css({
				'position': 'relative',
				'width': dim[0],
				'height': dim[1],
				'background-color': bgColor
			});

			stage.data('stage-id', stageId);

			var thumbs = $(this).find('ul a[href][id][data-largesrc]')
				.each(function() {
					$(this).data('stage-id', stageId);
				})
				.click(function(e) {

					var id = $(this).attr('id');

					if (currentStageId != stageId) {
						fn.exhibit(id, stage, thumbs, gallery);
					}

					currentStageId = stageId;
					fn.setHashToken(id);

					e.preventDefault();
				});

			var loading = $('<div class="loading">Loading...</div>').hide().appendTo(stage);

			// Bind loading message to image create and loaded events.
			gallery.bind({
				'create.cfgal': function(e) {
					loading.show();
				},
				'loaded.cfgal': function(e) {
					loading.hide();
				}
			});

			stage.bind({
				'click': function() {
					var stageChange = false;

					if (currentStageId != stageId) {
						currentStageId = stageId;
						stageChange = true;
					}

					fn.setNextHashToken(thumbs, stage);

					if (stageChange) {
						/* Change image on hashChange (relies on jquery.hashchange shim) */
						var id = fn.getHashToken();
						fn.exhibit(id, stage, thumbs, gallery);
					}

					return false;
				},
				'swiperight': function() {
					currentStageId = stageId;
					fn.setNextHashToken(thumbs, stage);
					return false;
				},
				'swipeleft': function() {
					currentStageId = stageId;
					fn.setPrevHashToken(thumbs, stage);
					return false;
				}
			});


			$(docEl).keyup(function(e) {
				if (currentStageId == stageId) {
					// Right arrow
					if (e.keyCode === 39) {
						fn.setNextHashToken(thumbs, stage);
						return false;
					}
					// Left arrow
					else if (e.keyCode === 37) {
						fn.setPrevHashToken(thumbs, stage);
						return false;
					};
				}
			});

			$(window)
				.hashchange(function(e) {
					if (currentStageId == stageId) {
						/* Change image on hashChange (relies on jquery.hashchange shim) */
						var id = fn.getHashToken();
						fn.exhibit(id, stage, thumbs, gallery);
					}
				})
				.ready(function() {
					fn.patchHashToken(thumbs);
				})
				.load(function() {
					/* If hash is set onload, show the appropriate image.
					If not, will show the start image. */
					var ht = fn.getHashToken();
					fn.exhibit(ht, stage, thumbs, gallery);
				});
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
		
		/* Show an image on the stage by it's thumb's ID token.
		- Loads image if not already loaded
		- Preloads it's siblings afterwords
		*/
		exhibit: function(token, stage, thumbs, gallery) {

			var that = this,
				$img,
				$thumb = $( '#' + (token || this.getToken(null, thumbs)) , gallery),
				i = this.getThumbIndex($thumb, thumbs);
			
			var callback = function (img) {
				var c = gal.opts.activatedClass,
					current = $(stage).data('gallery-current'),
					$current;

				// Hide old and show new if both are present
				if (current !== null && current !== i) {
					$current = this.getImage(current, thumbs);
					// Hide others / Dequeue all animations before starting a new one.
					stage.children().not($current).stop().removeClass('init').hide();
					// Dequeue all animations before starting a new one.
					stage.find('figure').stop(true, true);
					this.transitionSlides(img, $current);
				}
				
				// If there is no current (first load) just show.
				if (current === null) {
					this.transitionSlides(img);
				};
				
				thumbs.removeClass(c);
				$thumb.addClass(c);

				$(stage).data('gallery-current', i);

				this.preloadNeighbors(i, stage, thumbs);
			};

			$img = this.getImage(i, thumbs);
			if (typeof $img == 'undefined') {
				$img = this.createImage(i, stage, thumbs, function(img) {
					callback.apply(that, [img]);
				});
			}
			else {
				callback.apply(that, [$img]);
			};
		},
		
		/* Allow transition to be overidden using Duck Punching */
		transitionSlides: function($img, $old) {
			var that = this;
			if ($old !== null && typeof $old !== 'undefined') {
				$old.fadeOut('fast', function() {
					that.showSlide($img);
				});
			}
			else {
				that.showSlide($img);
			}
			// show captions
		},
		
		showSlide: function($neue) {
			$neue.stop().addClass('init').fadeIn('medium', function() {
				$(this).css({ opacity: 1 });
				var func = $.proxy(function() {
					$(this).removeClass('init');
				}, this);
				var timeout = setTimeout(func, 1600);
			});
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
		patchHashToken: function(thumbs) {
			var l = loc.hash;
			if (l.indexOf('#/') === -1 && thumbs.filter(l).length > 0) {
				loc.hash = this.makeHashToken(l.replace('#', ''));
			}
		},
		
		setNextHashToken: function(thumbs, stage) {
			var max = thumbs.length - 1,
				t;

			var current = stage.data('gallery-current') || 0;
			if (++current > max) {
				current = 0;
			}

			t = this.getToken(current, thumbs);
			
			this.setHashToken(t);
		},
		
		setPrevHashToken: function(thumbs, stage) {
			var max = thumbs.length - 1,
				t;

			var current = stage.data('gallery-current') || 0;
			if (--current < 0) {
				current = max;
			}

			t = this.getToken(current, thumbs);

			this.setHashToken(t);
		},
		
		/*
		Get the index of a thumb jQuery object in the set of thumb objects. */
		getThumbIndex: function($thumb, thumbs) {
			return thumbs.index($thumb);
		},
		
		getToken: function(i, thumbs) {
			var a = i || gal.opts.start;
			return thumbs.eq(a).attr('id');
		},
		
		getImage: function(i, thumbs) {
			return thumbs.eq(i).data('cfgalExpanded');
		},
		
		getImageData: function($thumb) {
			var title = $thumb.data('title'),
				caption = $thumb.data('caption');

			/* Favor title if they're the same */
			if (title === caption) {
				caption = '';
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
		createImage: function(i, stage, thumbs, callback) {
			var data, $img, $figure,
				opts = gal.opts,
				$thumb = thumbs.eq(i),
				// Used in callback
				scale = this.scale;
			
			data = this.getImageData($thumb);
			$figure = this.createFigure($thumb, data);

			$img = this.loadImage(data.src, function() {
				var t = $(this),
					dims = scale(
						[t.width(), t.height()],
						[stage.width(), stage.height()]
					);
				
				$figure.css({
					'display': 'none'
				});
				
				t.css({
					'width': dims[0],
					'height': dims[1],
					// Add CSS for centering.
					'margin-left': -1 * (dims[0] / 2),
					'margin-top': -1 * (dims[1] / 2),
					'visibility': 'visible'
				})
				.trigger('loaded.cfgal');

				if ($.isFunction(callback)) {
					callback($figure);
				}
			});
			
			$img.css({
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
			.trigger('create.cfgal');
			
			$img.prependTo($figure);
			$figure.appendTo(stage);
			
			$thumb.data('cfgalExpanded', $figure);
			return $figure;
		},
		
		createFigure: function ($thumb, data) {
			var opts = gal.opts,
			$figure, $title, $caption, $figcaption;
			
			$figure = $('<figure/>').addClass(opts.figureClass);

			if (data.title || data.caption) {
				$figcaption = $('<figcaption/>')
					.addClass(opts.figcaptionClass)
					.appendTo($figure);
				
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
			
			return $figure;
		},
		
		preloadNeighbors: function(index, stage, thumbs) {
			var check = [1, 2, -1],
				max = thumbs.length -1,
				i,
				a;
			for (i = check.length - 1; i >= 0; i--){
				a = index + check[i];
				if (a >= 0 && a <= max && !this.getImage(a, thumbs)) {
					this.createImage(a, stage, thumbs);
				};
			};
		},

		loadImage: function(src, callback) {
			var img = new Image();
			/* Really roundabout stuff to get around IE < 8's insane image
			caching behavior.
			1. src MUST be set after load event is bound
			2. image MUST be passed through jQuery's factory twice to be updated in IE (at least I think that's what's happening)
			3. Load event must run on a timeout, or else IE will ignore for cached images (it fires load) before it populates the data
			   for cached images, apparently.
			 */
			$(img).load(function (e) {
				var cb = $.proxy(callback, this);
				setTimeout(function () {
					cb(e);
				}, 2);
			});
		 	img.src = src;
			img.alt = '';
		
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
})(jQuery);jQuery(function($) {
	$('.entry-media').fitVids();
	
	var activate = (Modernizr.touch && navigator.userAgent.toLowerCase().indexOf('blackberry') == -1 ? 'touchend' : 'click');
	$('#nav-main h1').bind(activate, function(e) {
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
	if ($bioCarousel.size() > 0 && typeof $bioCarousel.cycle === 'function') {
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
	// make placeholder attribute work in older browsers
	// requires jquery.placeholder.min.js
	$('#s').placeholder();

// Gallery
	var $gal = $('.cfgallery'),
		viewportW = $(window).width(),
		scale = $.fn.cfgallery.helpers.scale,
		dims = [];
	
	// set defaults
	var w = $gal.data('width');
	var h = $gal.data('height');
	dims[0] = (typeof w === 'undefined' ? 710 : w);
	dims[1] = (typeof h === 'undefined' ? 474 : h);
	
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
		'stageDimensions': dims,
		'titleClass': 'h3'
	});
	$('.gallery-img-excerpt li:not(.gallery-view-all) a').cfShimLinkHash();
});
