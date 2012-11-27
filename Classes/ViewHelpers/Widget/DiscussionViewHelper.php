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
 * @subpackage ViewHelpers/Widget
 */
class Tx_Dialog_ViewHelpers_Widget_DiscussionViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var string
	 */
	protected $ajaxWidget = FALSE;

	/**
	 * @var Tx_Dialog_ViewHelpers_Widget_Controller_DiscussionController
	 */
	protected $controller;

	/**
	 * @param Tx_Dialog_ViewHelpers_Widget_Controller_DiscussionController $controller
	 */
	public function injectController(Tx_Dialog_ViewHelpers_Widget_Controller_DiscussionController $controller) {
		$this->controller = $controller;
	}

	/**
	 * Initialize
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerArgument('mode', 'string', 'The mode of this instance - choose between "flat", "thread" and "chat" modes', FALSE, 'thread');
		$this->registerArgument('discussions', 'mixed', 'If specified, renders this collection of discussions');
		$this->registerArgument('discussion', 'Tx_Dialog_Domain_Model_Discussion', 'If specified, renders this discussion only');
		$this->registerArgument('hash', 'string', 'If specified, loads discussions with this hash value (use this for a manually initialized discussion with automatic setup');
	}

	/**
	 * Render
	 *
	 * @return string
	 */
	public function render() {
		if ($this->hasArgument('discussions') === FALSE && $this->hasArgument('discussion') === FALSE && $this->hasArgument('hash') === FALSE) {
			throw new Exception('You must specify at least one of "discussions", "discussion" or "hash" arguments', 1325714244);
		}
		return $this->initiateSubRequest();
	}

}

?>