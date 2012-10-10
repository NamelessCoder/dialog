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
 * Chat Widget
 *
 * @package Dialog
 * @subpackage ViewHelpers/Widget
 */
class Tx_Dialog_ViewHelpers_Widget_ChatViewHelper extends Tx_Dialog_ViewHelpers_Widget_AbstractJQueryWidgetViewHelper {

	/**
	 * @var Tx_Dialog_ViewHelpers_Widget_Controller_ChatController
	 */
	protected $controller;

	/**
	 * @param Tx_Dialog_ViewHelpers_Widget_Controller_ChatController $controller
	 */
	public function injectController(Tx_Dialog_ViewHelpers_Widget_Controller_ChatController $controller) {
		$this->controller = $controller;
	}

	/**
	 * Initialize
	 */
	public function initializeArguments() {
		$this->registerArgument('id', 'string', 'DOM ID and JS variable name of this Chat instance', FALSE, 'dialogChat');
		$this->registerArgument('chatIdentity', 'string', 'Optional chat identity (use this if you have multiple chats running, must be JS variable name compatible)', FALSE, 'dialogChat');
	}

	/**
	 * @return string
	 */
	public function render() {
		return $this->initiateSubRequest();
	}

}
?>