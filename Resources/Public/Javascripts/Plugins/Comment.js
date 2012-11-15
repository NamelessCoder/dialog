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
					element.find('button[type="submit"]').removeAttr('disabled');
					applyCommentFormListeners();
				});
			};
			var closeCommentForm = function() {
				jQuery.ajax({
					url: urlClose,
					type: 'get',
					complete: function(response) {
						var returnedBody = jQuery(response.responseText);
						element.html(returnedBody.html());
						element.addClass('placeholder').removeClass('full');
						element.bind('click', loadCommentForm);
					}
				});
			};
			var applyCommentFormListeners = function() {
				element.find('.btn-cancel').attr('href', 'javascript:;').bind('click', closeCommentForm);
				element.unbind('click', loadCommentForm);
				element.find('button[type="submit"]').bind('click', submitCommentForm);
			};
			var submitCommentForm = function() {
				var postData = {
					subject: element.find('#subject').val(),
					comment: element.find('#words').val(),
					hash: element.find('#hash').val()
				};
				if (typeof postData == 'undefined' || postData.comment.length < 1) {
					element.find('#words').parent().parent().addClass('error');
					return;
				} else {
					element.find('#words').parent().parent().removeClass('error');
				};
				element.find('button[type="submit"]').attr('disabled', 'disabled');
				jQuery.ajax({
					url: urlPost,
					type: 'post',
					data: postData,
					complete: loadCommentForm
				});
			};
			element.find('.btn-cancel').live('click', closeCommentForm);
			if (element.hasClass('placeholder')) {
				element.bind('click', loadCommentForm);
			} else {
				loadCommentForm();
			};
		});
	};
})(jQuery);
