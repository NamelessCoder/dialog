function initializeJQueryWidget(elementId, widgetType, options, instanceName) {
	var localTimer = setInterval(function() { if (typeof jQuery != 'undefined') { window[instanceName] = jQuery('#' + elementId)[widgetType](options); clearInterval(localTimer); }; }, 250);
};
jQuery(document).ready(function($) {
	var timer;
	var resetTimer = function() {
		clearInterval(timer);
		timer = setTimeout(resizeAllTextAreas, 100);
	};
	$('.tx-dialog-discussion textarea')
		.keyup(resetTimer)
		.focus(resetTimer)
		.blur(resetTimer);
	resetTimer();
});


var resizeAllTextAreas = function() {
	$('textarea.expanding').each(function() {
		var area = $(this).removeAttr('rows').removeAttr('cols').removeClass('input-xlarge');
		var shouldBeHeight = area.get(0).scrollHeight;
		var isHeight = area.innerHeight();
		var space = 0;
		if (shouldBeHeight > isHeight) {
			area.css({
				"height": shouldBeHeight + space,
				"maxHeight": shouldBeHeight + space,
				"minHeight": shouldBeHeight + space
			});
		} else {
			area.css({
				"height": space,
				"maxHeight": space,
				"minHeight": space
			});
			isHeight = area.innerHeight();
			shouldBeHeight = area.get(0).scrollHeight;
			area.css({
				"height": shouldBeHeight + space,
				"maxHeight": shouldBeHeight + space,
				"minHeight": shouldBeHeight + space
			});
		};
	});
};