function initializeJQueryWidget(elementId, widgetType, options, instanceName) {
	var localTimer = setInterval(function() { if (typeof jQuery != 'undefined') { window[instanceName] = jQuery('#' + elementId)[widgetType](options); clearInterval(localTimer); }; }, 250);
};