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
			toggle: function() {
				if (this.isVisible()) {
					this.hideSearch();
				}
				else {
					this.showSearch();
				}
			},
			
			showSearch: function() {
				if (CF.favicons != undefined) {
					CF.favicons.hideInputs();
				}
				
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
		var $add = $('#cfp-add-link'),
			$edit = $('#cfp-link-edit'),
			$preview = $('#cfp-icon-preview'),
			$previewBlock = $('#cfp-link-icon-preview'),
			_fetchIconUrl = null,
			_timer = null;
		
		// store the original preview source image url
		$.data($preview, 'src-orig', $preview.attr('src'));
		
		$add.live('click', function(e) {
			CF.favicons.toggleInputs();
			e.stopPropagation();
			e.preventDefault();
		});
		
		// keep clicks in the popup from bubbling
		$edit.live('click', function(e) {
			e.stopPropagation();
		});	
		
		return {
			requestObj: null,
			resetXHR: function() {
				if (this.requestObj != null) {
					this.requestObj.abort();
					this.requestObj = null;
				}
			},
			
			toggleInputs: function() {
				if (this.isVisible()) {
					this.hideInputs();
				}
				else {
					this.showInputs();
				}
			},
			
			showInputs: function() {
				if (CF.imgs != undefined) {
					CF.imgs.hideSearch();
				}
				
				this.resetIconPreview();
				
				$add.addClass('open');
				var pos = $add.offset();
				$edit.css({
					top: pos.top + 13 + 'px',
					left: (pos.left + $add.outerWidth() / 2) - ($edit.outerWidth()) + 27 + 'px'
				}).show().find('input#cfp-link-title').focus();
				
				// timer for live favicon fetch
				$edit.find('input#cfp-link-url').keyup(function() {
					if (_timer != null) {
						clearTimeout(_timer);
					}
					actionFunc = function(parentObj) {
						parentObj.fetchFaviconUrl();
					};
					_timer = setTimeout(actionFunc, 500, CF.favicons);
				});			
			},
			
			hideInputs: function() {
				$add.removeClass('open');
				$edit.hide();
				this.resetInputs();
			},
			
			editLink: function() {
				
				this.showInputs();
			},
			
			// reset our inputs for editing
			resetInputs: function() {
				$edit.find('input[type!="submit"]').val('').end()
					.find('img').attr('src', '#');
				_fetchIconUrl = null;
			},
			
			isVisible: function() {
				return $edit.is(':visible');
			},
			
			fetchFaviconUrl: function() {
				this.resetXHR();
				this.resetIconPreview(false);
				$previewBlock.show();
				
				var _url = $('#cfp-link-url').val();
				if (_url.length > 0 && _url != _fetchIconUrl) {
					_fetchIconUrl = _url;
					this.requestObj = $.post(ajaxurl,
						{
							action: 'cfp_about',
							cfp_about_action: 'cfp_fetch_favicon',
							url: _url
						},
						function(r) {
							if (r.success) {
								CF.favicons.setIconPreview(r.favicon_url, r.favicon_status);
							}
							else {
								CF.favicons.setIconPreview(r.favicon_url, r.favicon_status);
								CF.favicons.setErrorMessage(cfcp_about_settings.favicon_fetch_error + _url);
							}
							CF.requestObj = null;
						},
						'json'
					);
				}
			},
			
			setIconPreview: function(src, status) {
				$preview.attr('src', src);
				$('#cfp-link-favicon-status').val(status);
			},
			
			resetIconPreview: function(hide) {
				if (hide == undefined || hide == true) {
					$previewBlock.hide();
				}
				this.clearErrorMessage();
				this.setIconPreview($.data($preview, 'src-orig'), '');
			},
			
			setErrorMessage: function(msg) {
				$('#cfp-link-icon-message').html(msg);
			},
			
			clearErrorMessage: function() {
				$('#cfp-link-icon-message').html('');
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