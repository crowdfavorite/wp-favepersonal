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

// attach to add buttons for image search and services
	$('.cfp-add-link').popover({
		my: 'right top',
		at: 'center bottom',
		offset: '27px 0',
		collision: 'none none'
	}).bind('popover-show', function() {
		$(this).addClass('open');
	}).bind('popover-hide', function() {
		$(this).removeClass('open');
	});
	
// Image selector

	CF.imgs = function($) {
		var $search = $('#cfp-img-search-popover'),
			$imgActions = $('#cfp-popover-image-actions'),
			$list = $('#cfp-about-imgs-input ul');
		
		// add image to carousel button handler
		$('#cfp-add-img').bind('popover-show', function() {
			CF.imgs.initSearch();
			$search.find('input#cfp-img-search-term').focus();
		}).bind('popover-hide', function() {
			$search.find('input#cfp-img-search-term').val('');
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
			isVisible: function () {
				return $search.is(':visible');
			},
			
			initSearch: function() {
				$search.find('input#cfp-img-search-term').unbind().oTypeAhead({
					searchParams: {
						action: 'cfcp_about',
						cfcp_about_action: 'cfcp_image_search',
						cfcp_search_exclude: this.getSelectedIds()
					},
					form: '#cfp-img-search',
					url: ajaxurl,
					target: '#cfp-img-search-results',
					resultsCallback: function(target) {
						$('.cfp-search-result img').unbind('click').click(function() {
							CF.imgs.selectImg($(this).closest('li').clone());
						});
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
				if ($list.find('img').size() > 0) {
					$list.find('li.no-image-item').hide();
				}
				else {
					$list.find('li.no-image-item').show();
				}
			},
			
			selectImg: function(imgLi) {
				$(imgLi).attr('class', false).appendTo($list);
				this.handleEmptyLi();
				this.refreshSortables();
				$search.find('input#cfp-img-search-term').val('').focus();
			},
			
			removeImage: function(del) {
				$(del).closest('li')
					.animate({'width': 0}, 500, function() {
						$(this).remove();
						CF.imgs.handleEmptyLi();
					});
			}
			
		};
	}(jQuery);

// Favicon input
	
	CF.aboutLinks = function($) {
		var $add = $('#cfp-add-link'),
			$edit = $('#cfp-link-edit-popover'),
			$remove = $('#cfp-link-remove-popover'),
			$list = $('#cfp-link-items'),
			$preview = $('#cfp_icon_preview'),
			$previewBlock = $('#cfp_link_icon_preview'),
			$customIconField = $('#cfp_link_custom_favicon'),
			_fetchIconUrl = null,
			_timer = null;

		$('#cfp-add-link').bind('popover-show', function() {
			CF.aboutLinks.showInputs();
		});

		// store the original preview source image url
		$.data($preview, 'src-orig', $preview.attr('src'));
		
		// save button
		$edit.find('input[name="submit_button"]').click(function(e) {
			CF.aboutLinks.saveFavicon();
		});
		
		// customize favicon url
		$('#cfp-link-icon-edit, #cfp-link-icon-preview-custom .cfp-action-remove').click(function() {
			CF.aboutLinks.togglePreviewEdit();
		});
		
		// clear custom icon input
		$('#cfp-cancel-link-icon-edit').click(function(e) {
			CF.aboutLinks.togglePreviewEdit();
		});
		
		// init sortables
		$list.sortable({
			axis: 'x',
			items: 'li',
			cursor: 'crosshair',
			helper: 'clone',
			placeholder: 'cfp-link-img-placeholder'
		});
		
		$(function() {
			CF.aboutLinks.initPopover();
		});
		
		return {
			requestObj: null,
			resetXHR: function() {
				if (this.requestObj != null) {
					this.requestObj.abort();
					this.requestObj = null;
				}
			},
			
			initPopover: function() {
				// attach actions to icons for delete actions
				$('.cfp-about-link-item').unbind().popover({
					my: 'left top',
					at: 'center bottom',
					offset: '-27px 0',
					collision: 'none none',
					popover: '#cfp-link-remove-popover'
				}).bind('popover-show', function() {
					$elem = $(this);
					$remove.find('a').unbind('click').click(function(e) {
						$elem.closest('li').fadeOut(function() {
							$(this).remove();
							CF.aboutLinks.handleEmptyLi();
						}).end().data('popover').hide();
						e.preventDefault();
					});
					var data = $.parseJSON($elem.closest('li').find('input[name="cfcp_about_settings[links][]"]').val());
					$remove.find('p.title').text(data.title).end()
						.find('p.url').text(data.url).end()
						.show();
				});
			},
			
			showInputs: function(showNew) {
				this.resetIconPreview();
				$edit.addClass('new').find('input#cfp_link_title').focus();
				
				// timer for live favicon fetch
				var _timer = null;
				$edit.find('input#cfp_link_url').unbind('keyup').keyup(function() {
					if (_timer !== null) {
						clearTimeout(_timer);
					}
					var actionFunc = function() {
						CF.aboutLinks.fetchFaviconUrl();
					};
					_timer = setTimeout(actionFunc, 500);
				});
			},
			
			// reset our inputs for editing
			resetInputs: function() {
				$edit.find('input[type!="button"]').val('').end()
					.find('input#cfp_link_url').val('http://').end()
					.find('img').attr('src', '#');
				_fetchIconUrl = null;
				CF.aboutLinks.iconToggleAuto();
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
						$('#cfp-link-edit-popover input[name="submit_button"]')
							.addClass('disabled').val(cfcp_about_settings.loading);
						this.requestObj = $.post(
							ajaxurl,
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
								$('#cfp-link-edit-popover input[name="submit_button"]')
									.removeClass('disabled').val(cfcp_about_settings.add);
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
				
				$form = $('#cfp-link-edit-popover');
				$button = $form.find('input[name="submit_button"]');

				if ($button.hasClass('disabled') || $form.hasClass('saving')) {
					return;
				}

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
							if (CF.aboutLinks.isVisible()) {
								$('#cfp-add-link').click();
							}
							CF.aboutLinks.resetInputs();
							CF.aboutLinks.initPopover();
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
				if ($list.find('img').size() > 0) {
					$list.find('.no-link-item').hide();
				}
				else {
					$list.find('.no-link-item').show();
				}
			},
			
			refreshSortables: function() {
				$list.sortable('refresh');
			}
		};
	}(jQuery);
	
// Init
	
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