<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Base class for jQuery widgets
 *
 * @package Dialog
 * @subpackage ViewHelpers/Widget
 */
abstract class Tx_Dialog_ViewHelpers_Widget_AbstractJQueryWidgetViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * Initializes a jQuery-based Widget using options and giving in an instance name in JS
	 *
	 * @param type $domElementId The DOM element ID which should contain the Widget (and possibly the template contents used by the Widget)
	 * @param type $widgetType The name of the function on jQuery.fn which is used to initialize the Widget (for example: "autocomplete" for jQuery('someelement').autocomplete() widget)
	 * @param type $widgetOptions An array of options used to initialize the jQuery Widget
	 * @param type $instanceName If you do not care about the instance variable name used in JS you can leave this out
	 */
	protected function initializeWidget($domElementId, $widgetType, $widgetOptions, $instanceName=NULL) {
		if (!is_array($widgetOptions) || count($widgetOptions) == 0) {
				// this ensures correct encoding of options
			$widgetOptions = array('defaults' => 'none');
		}
		if ($instanceName === NULL) {
			$instanceName = uniqid('jQueryWidget');
		}
		$widgetOptionsJson = json_encode($widgetOptions);
		$initScript = "jQuery(document).ready(function() { alert('test'); initializeJQueryWidget('" . $domElementId . "', " . $widgetOptionsJson . ", '" . $instanceName . "'); });";
		return $initScript;
	}

}
?>