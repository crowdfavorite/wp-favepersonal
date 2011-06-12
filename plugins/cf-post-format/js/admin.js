jQuery(function($){
	var CF = CF || {};
	
	CF.postFormats = function($) {
		return {
			switchTab: function(clicked) {
				var $this = $(clicked),
					$tab = $this.closest('li');

				if (!$this.hasClass('current')) {
					$this.addClass('current');
					$tab.siblings().find('a').removeClass('current');
					this.switchWPFormat($this.attr('href'));
				}
			},
			
			switchWPFormat: function(format_hash) {
				$(format_hash).trigger('click');
				switch (format_hash) {
					case '#post-format-0':
						CF.postFormats.standard();
						break;
					case '#post-format-status':
					case '#post-format-link':
					case '#post-format-image':
					case '#post-format-gallery':
					case '#post-format-video':
					case '#post-format-quote':
						eval('CF.postFormats.' + format_hash.replace('#post-format-', '') + '();');
				}
			},

			standard: function() {
console.log('format standard');
			},
			
			status: function() {
			},

			link: function() {
console.log('format link');
			},
			
			image: function() {
			},

			gallery: function() {
			},

			video: function() {
			},

			quote: function() {
			}
		};
	}(jQuery);
	
	// move tabs in to place
	$('#cf-post-format-tabs').insertBefore($('form#post'));
	
	// tab switch
	$('#cf-post-format-tabs a').live('click', function(e) {
		CF.postFormats.switchTab(this);
		e.stopPropagation();
		e.preventDefault();
	});
});