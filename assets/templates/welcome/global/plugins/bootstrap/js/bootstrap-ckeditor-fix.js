$.extend($.ui.dialog.overlay, { create: function(dialog){
	if (this.instances.length === 0) {
		// prevent use of anchors and inputs
		// we use a setTimeout in case the overlay is created from an
		// event that we're going to be cancelling (see #2804)
		setTimeout(function() {
			// handle $(el).dialog().dialog('close') (see #4065)
			if ($.ui.dialog.overlay.instances.length) {
				$(document).bind($.ui.dialog.overlay.events, function(event) {
					var parentDialog = $(event.target).parents('.ui-dialog');
					if (parentDialog.length > 0) {
						var parentDialogZIndex = parentDialog.css('zIndex') || 0;
						return parentDialogZIndex > $.ui.dialog.overlay.maxZ;
					}
					
					var aboveOverlay = false;
					$(event.target).parents().each(function() {
						var currentZ = $(this).css('zIndex') || 0;
						if (currentZ > $.ui.dialog.overlay.maxZ) {
							aboveOverlay = true;
							return;
						}
					});
					
					return aboveOverlay;
				});
			}
		}, 1);
		
		// allow closing by pressing the escape key
		$(document).bind('keydown.dialog-overlay', function(event) {
			(dialog.options.closeOnEscape && event.keyCode
					&& event.keyCode == $.ui.keyCode.ESCAPE && dialog.close(event));
		});
			
		// handle window resize
		$(window).bind('resize.dialog-overlay', $.ui.dialog.overlay.resize);
	}
	
	var $el = $('<div></div>').appendTo(document.body)
		.addClass('ui-widget-overlay').css({
		width: this.width(),
		height: this.height()
	});
	
	(dialog.options.stackfix && $.fn.stackfix && $el.stackfix());
	
	this.instances.push($el);
	return $el;
}});
$.fn.modal.Constructor.prototype.enforceFocus = function() {
  modal_this = this
  $(document).on('focusin.modal', function (e) {
    if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length 
    // add whatever conditions you need here:
    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
      modal_this.$element.focus()
    }
  })
};