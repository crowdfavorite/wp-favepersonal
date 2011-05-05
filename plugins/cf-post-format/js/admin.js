jQuery(function($){
	var CF = CF || {};
	
	CF.pfTabs = function($) {
		var $tabs = $('#cf-post-format-tabs');
		
		// we found tabs, hide the default post-format box
		if ($tabs.size() > 0) {
			$('#formatdiv').hide();
		}
		
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
			}
		};
	}(jQuery);
		
	// move tabs in to place
	$('#cf-post-format-tabs').insertBefore($('form#post'));
	
	// tab switch
	$('#cf-post-format-tabs a').live('click', function(e) {
		CF.pfTabs.switchTab(this);
		e.stopPropagation();
		e.preventDefault();
	});
});