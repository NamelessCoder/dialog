(function(jQuery){
	jQuery.fn.dialogComments = function(options) {
		var defaults = {};
		var options = jQuery.extend(defaults, options);
		return this.each(function() {
			var element = jQuery(this);
			var urlForm = element.attr('data-url-form');
			var urlPost = element.attr('data-url-post');
			var urlClose = element.attr('data-url-close');
			var loadCommentForm = function() {
				element.load(urlForm, function() {
					element.removeClass('placeholder').addClass('full').unbind('click');
					element.find('.btn-cancel').attr('href', 'javascript:;');
					element.click(function() {
						element.load(urlClose, function(e) {
							element.addClass('placeholder').removeClass('full');
						});
						element.click(loadCommentForm);
					});
				});
			};
			element.find('.btn-cancel').live('click', function() {
				element.load(urlClose, function(e) {
					element.addClass('placeholder').removeClass('full');
					element.click(loadCommentForm);
					e.cancel();
				});
			});
			if (element.hasClass('placeholder')) {
				element.click(loadCommentForm);
			} else {
				loadCommentForm();
			};
		});
	};
})(jQuery);
