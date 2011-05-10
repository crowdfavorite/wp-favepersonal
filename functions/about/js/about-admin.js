jQuery(function($) {
	var CF = CF || {};

// Image selector
	
	CF.imgs = function($) {
		var $search = $('#cfp-img-search'),
			$imgActions = $('#cfp-popover-image-actions'),
			$add = $('#cfp-add-img'),
			$list = $('#cfp-about-imgs-input ul');
		
		// keep clicks in the popup from bubbling
		$search.live('click', function(e) {
			e.stopPropagation();
		});
		
		// image search results click handler
		$('#cfp-img-search-results a').live('click', function(e) {
			CF.imgs.selectImg($(this).closest('li'));
			e.preventDefault();
			e.stopPropagation();
		});
		
		// capture click on image to show delete/edit buttons
		$list.find('a').live('click', function(e) {
			CF.imgs.showImgAction(this);
			e.preventDefault();
			e.stopPropagation();
		});
		
		// delete an image from the list
		$('#cfp-about-image-delete').live('click', function(e) {
			if (confirm('Are you sure you want to delete this image?')) {
				CF.imgs.removeImage();
			}
			e.preventDefault();
			e.stopPropagation();
		});
		
		// edit an image
		$('#cfp-about-image-edit').live('click', function(e) {
			CF.imgs.imageActionRedirect();
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
				this.hideImgAction();
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
							CF.imgs.selectImg($(this).find('li.otypeahead-current').clone().removeClass('otypeahead-current'));
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
				$(imgLi).attr('class', false).appendTo($list);
				this.handleEmptyLi();
				this.hideSearch();
				this.refreshSortables();
			},
			
			showImgAction: function(clicked) {
				this.hideSearch();
				$li = $(clicked).closest('li');
				this.currentActionImage = $li;
				var pos = $li.offset();
				
				$imgActions.css({
					top: pos.top + ($li.outerHeight() * 0.88) + 'px',
					left: pos.left + ($li.outerWidth() / 2) - ($imgActions.outerWidth() / 2) + 'px'
				}).show();				
			},
			
			hideImgAction: function(clicked) {
				$imgActions.hide();
			},
			
			imageActionRedirect: function() {
				window.location = this.currentActionImage.find('a').attr('href');
			},
			
			removeImage: function() {
				this.currentActionImage.remove();
				this.refreshSortables();
				this.hideImgAction();
			},
			
			hideAllDialogs: function() {
				this.hideSearch();
				this.hideImgAction();
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
	
	// add image to carousel button handler
	$('#cfp-add-img').live('click', function(e) {
		CF.imgs.toggle();
		e.preventDefault();
		e.stopPropagation();
	});
			
	$('body').live('click', function(e) {
		CF.imgs.hideAllDialogs();
		CF.favicons.hideInputs();
	});	
});