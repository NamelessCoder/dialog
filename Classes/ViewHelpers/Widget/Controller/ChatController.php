<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Claus Due <claus@wildside.dk>, Wildside A/S
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * @package Dialog
 * @subpackage Widget/Chat/Controller
 */
class Tx_Dialog_ViewHelpers_Widget_Controller_ChatController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @return void
	 */
	public function initializeAction() {
		if (session_id() === '') {
			session_start();
		}
		if (isset($_SESSION['tx_dialog']['chat']) === FALSE) {
			$_SESSION['tx_dialog']['chat'] = array();
		}
	}

	/**
	 * @return string
	 */
	public function indexAction() {
		$instanceIdentifier = $this->widgetConfiguration['id'];
		$widgetType = 'dialogChat';
		$typeNum = 1326130203;
		$options = array(
			'urls' => array(
				'say' => $this->uriBuilder->setTargetPageType($typeNum)->setTargetPageUid()->uriFor('say'),
				'setName' => $this->uriBuilder->setTargetPageType($typeNum)->setTargetPageUid()->uriFor('setName'),
				'text' => '/typo3temp/tx_dialog_chat_' . $instanceIdentifier . '.txt'
			),
			'chatIdentity' => $instanceIdentifier,
			'name' => $this->getName()
		);
		$this->view->assign('name', $this->getName());
		$this->view->assign('id', $instanceIdentifier);
		$this->view->assign('initScript', $this->initializeWidget($instanceIdentifier, $widgetType, $options, $instanceIdentifier));
	}

	/**
	 * @param string $name
	 */
	protected function getName() {
		if (isset($_SESSION['tx_dialog']['chat']['tx_dialog_name']) === FALSE) {
			$_SESSION['tx_dialog']['chat']['tx_dialog_name'] = $this->setName('Guest ' . rand(1, 4096));
		}
		return $_SESSION['tx_dialog']['chat']['tx_dialog_name'];
	}

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
		$initScript = "jQuery(document).ready(function() { initializeJQueryWidget('" . $domElementId . "', '" . $widgetType . "', " . $widgetOptionsJson . ", '" . $instanceName . "'); });";
		return $initScript;
	}



}
?>