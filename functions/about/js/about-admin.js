jQuery(function($) {
	var CF = CF || {};

// Image selector
	
	CF.imgs = function($) {
		var $search = $('#cfp-img-search'),
			$imgActions = $('#cfp-popover-image-actions'),
			$add = $('#cfp-add-img'),
			$list = $('#cfp-about-imgs-input ul');
		
		// add image to carousel button handler
		$('#cfp-add-img').live('click', function(e) {
			CF.imgs.toggle();
			e.preventDefault();
			e.stopPropagation();
		});
		
		// keep clicks in the popup from bubbling
		$search.live('click', function(e) {
			e.stopPropagation();
		});
		
		$('.cfp-search-result img').live('click', function() {
			CF.imgs.selectImg($(this).closest('li').clone());
		});
		
		$('.cfp-del-image').live('click', function(e) {
			if (confirm(cfcp_about_settings.image_del_confirm)) {
				CF.imgs.removeImage(this);
			}
			e.preventDefault();
			e.stopPropagation();
		});
		
		// init sortables
		$list.sortable({
			axis: 'x',
			items: 'li',
			cursor: 'crosshair',
			helper: 'clone',
			placeholder: 'cfp-about-img-placeholder'
		});
		
		return {
			currentActionImage: null,
			
			toggle: function() {
				if (this.isVisible()) {
					this.hideSearch();
				}
				else {
					this.showSearch();
				}
			},
			
			showSearch: function() {
				$add.addClass('open');
				// we init search every time we open so that we get a fresh
				// exclusion of existing images during the type ahead search
				this.initSearch();
				var pos = $add.offset();
				$search.css({
					top: pos.top + 13 + 'px',
					left: (pos.left + $add.outerWidth() / 2) - ($search.outerWidth()) + 27 + 'px'
				}).show().find('input#cfp-image-search-term').focus();
			},
			
			hideSearch: function() {
				$add.removeClass('open');
				$search.hide();
			},
			
			isVisible: function () {
				return $search.is(':visible');
			},
			
			initSearch: function() {
				$search.find('input#cfp-image-search-term').unbind().oTypeAhead({
					searchParams: {
						action: 'cfp_about',
						cfp_about_action: 'cfp_image_search',
						cfp_search_exclude: this.getSelectedIds()
					},
					form: '#cfp-image-search',
					url: ajaxurl,
					target: '#cfp-img-search-results',
					resultsCallback: function(target) {
						$(target).unbind().bind('o-typeahead-select', function() {
							CF.imgs.selectImg($(this).find('li.otypeahead-current').clone());
						});
					}
				});
			},
			
			getSelectedIds: function() {
				var ids = [];
				$list.find('li input[type="hidden"]').each(function() {
					ids.push($(this).val());
				});
				return ids;
			},
			
			refreshSortables: function() {
				$list.sortable('refresh');
			},
			
			handleEmptyLi: function() {
				if ($list.find('li').size() > 1) {
					$list.find('li.no-image-item').hide();
				}
				else {
					$list.find('li.no-image-item').show();					
				}
			},
			
			selectImg: function(imgLi) {
				console.log('foo');
				$(imgLi).attr('class', false).appendTo($list);
				this.handleEmptyLi();
				this.hideSearch();
				this.refreshSortables();
			},
			
			removeImage: function(del) {
				$(del).closest('li')
					.animate({'width': 0}, 500, function() {
						$(this).remove();
					});
			},
			
			hideAllDialogs: function() {
				this.hideSearch();
			}
		};
	}(jQuery);

// Favicon input
	
	CF.favicons = function($) {
		
		return {
			showInputs: function() {
				
			},
			
			hideInputs: function() {
				
			}
		};
	}(jQuery);
	
// Init
			
	$('body').live('click', function(e) {
		CF.imgs.hideAllDialogs();
		CF.favicons.hideInputs();
	});

	// $('.cf-updated-message-fade')
	// 	.animate({'opacity': 1.0}, 8000) // faux timeout, animates nothing for 8 seconds
	// 	.slideUp('slow');
});