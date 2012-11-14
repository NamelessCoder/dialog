var chatTimer = setInterval(function() {
    if (typeof jQuery != 'undefined') {
(function(jQuery){
	jQuery.fn.dialogChat = function(options) {
		var defaults = {
			"refreshFrequency": 1000
		};
		var options = jQuery.extend(defaults, options);
		return this.each(function() {
			var element = jQuery(this);
			var timer = setInterval(updateText, options.refreshFrequency);
			var onCompletedAjax = function(request) {
				var container = element.find('.tx-dialog-chat-text');
				if (parseInt(request.status) != 200) {
					container.html('Nobody has said anything yet - be the first by entering your message below.');
					return;
				};
				var lines = jQuery.parseJSON(request.responseText);
				var html = '';
				for (var i=0; i<lines.length; i++) {

					var parts = lines[i];
					html += '<div class="tx-dialog-chat-line ' + (parts.name == options.name ? 'me' : 'you') + '">';
					html += '<span class="tx-dialog-chat-time">' + parts.time + '</span>';
					html += '<span class="tx-dialog-chat-name">' + parts.name + ':</span>';
					html += '<span class="tx-dialog-chat-message">' + parts.message + '</span>';
					html += '</div>';
				};
				container.html(html).prop({scrollTop: container.prop("scrollHeight")});
			};
			var updateText = function() {
				var request = jQuery.ajax({
					"url" : options.urls.text,
					"async": true,
					"complete": onCompletedAjax
				});
			};
			var chatInputField = element.find('.tx-dialog-chat-input');
			element.find('.tx-dialog-set-name-link').live('click', function() {
				element.find('.tx-dialog-set-name').fadeIn();
				jQuery(this).hide();
			});
			element.find('.tx-dialog-name-button').live('click', function() {
				jQuery.ajax({
					"url": options.urls.setName,
					"complete": function(request) {
						if (request.responseText.indexOf('ERROR:') == 0) {
							alert('Invalid or taken name - please choose another');
						};
						options.name = request.responseText;
						element.find('.tx-dialog-set-name').hide();
						element.find('.tx-dialog-set-name-link').fadeIn().html('Change name (' + request.responseText + ')');
					},
					"data": {
						"tx_dialog_chat": {
							"name": element.find('.tx-dialog-name').val()
						}
					}
				});
			});
			element.find('.tx-dialog-name-cancel-button').live('click', function() {
				element.find('.tx-dialog-set-name').hide();
				element.find('.tx-dialog-set-name-link').fadeIn();
			});
			chatInputField.keypress(function(e) {
				if ((e.keyCode || e.which) == 13) {
					var field = jQuery(this);
					field.html(field.val().substr(0, field.val().length - 1));
					jQuery.ajax({
						"url": options.urls.say,
						"complete": onCompletedAjax,
						"data": {
							"tx_dialog_chat": {
								"chatIdentity": options.chatIdentity,
								"message": field.val()
							}
						}
					});
					setTimeout(function() {
						field.val('');
					}, 200);
				};
			});
			updateText();
		});
	};
})(jQuery);
        clearInterval(chatTimer);
    }
}, 250);