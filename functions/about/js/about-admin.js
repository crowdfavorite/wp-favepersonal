jQuery(function($) {
	// For older IE implementations - SUCK!
	// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Object/keys (expanded for readability)
	if (!Object.keys) {
		Object.keys = function(o){
			if (o !== Object(o)) {
				throw new TypeError('Object.keys called on non-object');
			}
			var ret=[],p;
			for(p in o) {
				if(Object.prototype.hasOwnProperty.call(o,p)) {
					ret.push(p);
				}
			}
			return ret;
		};
	}
	
// Objects
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
				if (CF.aboutLinks != undefined) {
					CF.aboutLinks.hideAllDialogs();
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
						action: 'cfcp_about',
						cfcp_about_action: 'cfcp_image_search',
						cfcp_search_exclude: this.getSelectedIds()
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
	
	CF.aboutLinks = function($) {
		var $add = $('#cfp-add-link'),
			$edit = $('#cfp-link-edit'),
			$remove = $('#cfp-link-remove'),
			$list = $('#cfp-link-items'),
			$preview = $('#cfp_icon_preview'),
			$previewBlock = $('#cfp_link_icon_preview'),
			$customIconField = $('#cfp_link_custom_favicon'),
			_fetchIconUrl = null,
			_timer = null;
		
		// store the original preview source image url
		$.data($preview, 'src-orig', $preview.attr('src'));
		
		$add.live('click', function(e) {
			CF.aboutLinks.hideRemove();
			CF.aboutLinks.toggleInputs(true);
 			e.stopPropagation();
 			e.preventDefault();
		});
		
		// save button
		$edit.find('input[name="submit_button"]').live('click', function(e) {
			CF.aboutLinks.saveFavicon();
			e.preventDefault();
			e.stopPropagation();
		});
		
		// cancel
		$edit.find('input[name="cancel"]').live('click', function(e) {
			CF.aboutLinks.hideInputs();
			e.preventDefault();
			e.stopPropagation();			
		});
		
		// keep clicks in the popup from bubbling
		$edit.live('click', function(e) {
			e.stopPropagation();
		});
		
		$list.find('li.cfcp_about_link_item a').live('click', function(e) {
			CF.aboutLinks.showRemove(e, $(this));
			e.stopPropagation();
			e.preventDefault();
		});
		
		// customize favicon url
		$('#cfp-link-icon-edit, #cfp-link-icon-preview-custom .cfp-action-remove').live('click', function() {
			CF.aboutLinks.togglePreviewEdit();
		});
		
		// clear custom icon input
		$('#cfp-cancel-link-icon-edit').live('click', function(e) {
			CF.aboutLinks.togglePreviewEdit();
			e.stopPropagation();
			e.preventDefault();
		});
		
		// init sortables
		$list.sortable({
			axis: 'x',
			items: 'li',
			cursor: 'crosshair',
			helper: 'clone',
			placeholder: 'cfp-link-img-placeholder'
		});
		
		return {
			requestObj: null,
			resetXHR: function() {
				if (this.requestObj != null) {
					this.requestObj.abort();
					this.requestObj = null;
				}
			},
			
			toggleInputs: function(showNew) {
				if (this.isVisible()) {
					this.hideInputs(showNew);
				}
				else {
					this.showInputs(showNew);
				}
			},
			
			showInputs: function(showNew) {
				$edit.addClass('new');
				
				if (CF.imgs != undefined) {
					CF.imgs.hideAllDialogs();
				}
				CF.aboutLinks.hideAllDialogs();
				
				this.resetIconPreview();
				
				$add.addClass('open');
				var pos = $add.offset();
				$edit.css({
					top: pos.top + 13 + 'px',
					left: (pos.left + $add.outerWidth() / 2) - ($edit.outerWidth()) + 27 + 'px'
				}).show().find('input#cfp_link_title').focus();
				
				// timer for live favicon fetch
				$edit.find('input#cfp_link_url').unbind('keyup').keyup(function() {
					if (_timer != null) {
						clearTimeout(_timer);
					}
					actionFunc = function(parentObj) {
						parentObj.fetchFaviconUrl();
					};
					_timer = setTimeout(actionFunc, 500, CF.aboutLinks);
				});
			},
			
			hideInputs: function() {
				$add.removeClass('open');
				$edit.hide();
				this.resetInputs();
			},
			
			// reset our inputs for editing
			resetInputs: function() {
				$edit.find('input[type!="button"]').val('').end()
					.find('input#cfp_link_url').val('http://').end()
					.find('img').attr('src', '#');
				_fetchIconUrl = null;
				CF.aboutLinks.iconToggleAuto();
			},
			
			showRemove: function(e, $elem) {
				if (CF.imgs != undefined) {
					CF.imgs.hideAllDialogs();
				}
				CF.aboutLinks.hideAllDialogs();

				$remove.find('a').unbind().click(function(e) {
					CF.aboutLinks.hideRemove();
					$elem.closest('li').fadeOut(function() {
						$(this).remove();
					});
					e.stopPropagation();
					e.preventDefault();
				});
				var data = $.parseJSON($elem.closest('li').find('input[name="cfcp_about_settings[links][]"]').val());
				var pos = $elem.offset();
				$remove.find('p.title').text(data.title).end()
					.find('p.url').text(data.url).end()
					.css({
						top: pos.top + 13 + 'px',
						left: (pos.left + $elem.outerWidth() / 2) - 27 + 'px'
					}).show();
			},
			
			hideRemove: function() {
				$remove.find('a').unbind();
				$remove.hide();
			},

			hideAllDialogs: function() {
				CF.aboutLinks.hideInputs();
				CF.aboutLinks.hideRemove();
			},
						
			isVisible: function() {
				return $edit.is(':visible');
			},
			
			fetchFaviconUrl: function() {
				this.resetXHR();
				this.resetIconPreview(false);
				
				var _url = $('#cfp_link_url').val();

				if (_url.length > 7) {
					$previewBlock.show();
					if (_url != _fetchIconUrl) {
						_fetchIconUrl = _url;
						this.requestObj = $.post(ajaxurl,
							{
								action: 'cfcp_about',
								cfcp_about_action: 'cfcp_fetch_favicon',
								url: _url
							},
							function(r) {
								if (r.success) {
									CF.aboutLinks.setIconPreview(r.favicon_url, r.favicon_status);
								}
								else {
									CF.aboutLinks.setIconPreview(r.favicon_url, r.favicon_status);
									CF.aboutLinks.setErrorMessage(cfcp_about_settings.favicon_fetch_error + _url);
								}
								CF.requestObj = null;
							},
							'json'
						);
					}
				}
			},
			
			setIconPreview: function(src, status) {
				$preview.attr('src', src);
				$('#cfp_link_favicon').val(src);
				$('#cfp_link_favicon_status').val(status);
			},
			
			// set the icon preview back to a "loading" state
			resetIconPreview: function(hide) {
				if (hide == undefined || hide == true) {
					$previewBlock.hide();
				}
				this.clearErrorMessage();
				this.setIconPreview($.data($preview, 'src-orig'), '');
			},
			
			setErrorMessage: function(msg) {
				$('#cfp_link_icon_message').html(msg);
			},
			
			clearErrorMessage: function() {
				$('#cfp_link_icon_message').html('');
			},
			
			// show and hide the custom favicon edit box
			// also stores the current favicon preview state on the "cancel" button
			togglePreviewEdit: function() {
				var $previewCustom = $edit.find('#cfp-link-icon-preview-custom');
				if ($previewCustom.is(':visible')) {
					CF.aboutLinks.iconToggleAuto();
				}
				else {
					CF.aboutLinks.iconToggleCustom();
				}
			},
			
			iconToggleAuto: function() {
				var $previewAuto = $edit.find('#cfp-link-icon-preview-auto');
				var $previewCustom = $edit.find('#cfp-link-icon-preview-custom');
				$previewCustom.hide();
				$previewAuto.show();
			},

			iconToggleCustom: function() {
				var $previewAuto = $edit.find('#cfp-link-icon-preview-auto');
				var $previewCustom = $edit.find('#cfp-link-icon-preview-custom');

				$('#cfp_link_custom_favicon').val('');

				this.editSaveFaviconState();
				$customIconField.keyup(function() {
					if (_timer != null) {
						clearTimeout(_timer);
					}
					actionFunc = function(parentObj) {
						parentObj.setCustomFavicon();
					};
					_timer = setTimeout(actionFunc, 500, CF.aboutLinks);
				});

				$previewAuto.hide();
				$previewCustom.show();
			},
			
			// store a url on the "cancel" button so that we can revert when field is cleared
			editSaveFaviconState: function() {
				$('#cfp-cancel-link-icon-edit').data('favicon', $preview.attr('src')).data('status', $('#cfp-link-favicon-status').val());
			},
			
			// restore the favicon preview from the last known state before the custom icon field was messed with
			editRestoreFaviconState: function() {
				$preview.attr('src', $('#cfp-cancel-link-icon-edit').data('favicon'));
				$('#cfp-link-favicon-status').val($('#cfp-cancel-link-icon-edit').data('status'));
			},
			
			setCustomFavicon: function() {
				CF.aboutLinks.setIconPreview($customIconField.val(), 'custom');
			},
			
			saveFavicon: function() {
				var _url = $.trim($('#cfp_link_url').val()),
					_title = $.trim($('#cfp_link_title').val()),
					_favicon = '',
					_favicon_status = $.trim($('#cfp_link_favicon_status').val()),
					errors = {};
				
				switch (_favicon_status) {
					case 'custom':
						_favicon = $.trim($('#cfp_link_custom_favicon').val());
						break;
					default:
						_favicon = $.trim($('#cfp_link_favicon').val());
				}
					
				this.clearNotices();
					
				
				if (_title.length == 0) {
					errors.cfp_link_title = cfcp_about_settings.err_link_title;
				}
				if (_url.length < 8) {
					errors.cfp_link_url = cfcp_about_settings.err_link_url;
				}
				
				this.displayNotices(errors);
				if (Object.keys(errors).length) {
					return false;
				}
				
				$form = $('#cfp-link-edit');
				$button = $form.find('input[name="submit_button"]');

				$form.addClass('saving');
				$button.val(cfcp_about_settings.loading);

				$.post(ajaxurl,
					{
						action: 'cfcp_about',
						cfcp_about_action: 'cfcp_save_favicon',
						link: {
							url: _url,
							title: _title,
							favicon: _favicon,
							favicon_status: _favicon_status
						}
					},
					function(r) {
						if (r.success) {
							CF.aboutLinks.insertLinkItem(r.html);
							CF.aboutLinks.hideInputs();
						}
						else {
							$('#cfp-link-edit', $edit).append('<div class="cf-error">' + r.error + '</div>');
						}
						$form.removeClass('saving');
						$button.val(cfcp_about_settings.add);
					},
					'json'
				);
				return true;
			},
			
			displayNotices: function(errors) {
				this.clearNotices();
				if (errors !== undefined) {
					$.each(errors, function(id, errorString) {
						$('#' + id, $edit).closest('div').append($('<span class="cf-error">' + errorString + '</span>'));
					});
				}
			},
			
			clearNotices: function() {
				$('.cf-error', $edit).remove();
			},
			
			insertLinkItem: function(link) {
				$list.append($(link));
				this.handleEmptyLi();
			},
			
			handleEmptyLi: function() {
				if ($list.find('li').size() > 1) {
					$list.find('.no-link-item').hide();
				}
				else {
					$list.find('no-link-item').show();					
				}
			},
			
			refreshSortables: function() {
				$list.sortable('refresh');
			}
		};
	}(jQuery);
	
// Init
	
	// hide all pop-overs on bubbled body click
	$('body').live('click', function(e) {
		CF.imgs.hideAllDialogs();
		CF.aboutLinks.hideAllDialogs();
	});
	// hide all pop-overs when hitting ESC
	$(document).keyup(function(e) {
		switch (e.which) {
			case 27: // esc
				$('body').click();
				break;
		}
	});

// this is a good idea but pop-over menus get disconnected when the animation happens
// 	$('.cf-updated-message-fade')
// 		.animate({'opacity': 1.0}, 8000) // faux timeout, animates nothing for 8 seconds
// 		.slideUp('slow');
});