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
 * Comment Widget
 *
 * If contents are placed in the Widget tag in the template,
 * that content is used as a placeholder which must be clicked
 * before the comment form loads through AJAX.
 *
 * If no tag content is given, AJAX is used to load the form
 * immediately.
 *
 * @package Dialog
 * @subpackage ViewHelpers/Widget
 */
class Tx_Dialog_ViewHelpers_Widget_CommentViewHelper extends Tx_Dialog_ViewHelpers_Widget_AbstractJQueryWidgetViewHelper {

	/**
	 * @var boolean
	 */
	protected $ajaxWidget = TRUE;

	/**
	 * @var Tx_Dialog_ViewHelpers_Widget_Controller_CommentController
	 */
	protected $controller;

	/**
	 * @param Tx_Dialog_ViewHelpers_Widget_Controller_CommentController $controller
	 */
	public function injectController(Tx_Dialog_ViewHelpers_Widget_Controller_CommentController $controller) {
		$this->controller = $controller;
	}

	/**
	 * Initialize
	 */
	public function initializeArguments() {
		$this->registerArgument('hash', 'string', 'Required hash value to identify this particular discussion. Useful values are for example Tx_MyExt_Domain_Model_MyObject:123 to bind comments only to that particular object. The hash is reusable, so any other instance will use the same binding hash', TRUE);
		$this->registerArgument('presetSubject', 'string', 'Optional prefilled subject for comment form');
		$this->registerArgument('customTitle', 'string', 'Optional custom title for fieldset, defaults to TCA label for the Post table');
		$this->registerArgument('placeholder', 'string', 'Optional placeholder - if used, form is not loaded until the placeholder is clicked. The placeholder can be anything you like.');
		$this->registerArgument('width', 'array', 'Array of column widths, example: {poster: 3, postContent: 9} - uses bootstrap 12-column grid so total must be at maximum 12 but less is allowed', FALSE, array('poster' => 3, 'postContent' => 9));
	}

	/**
	 * @return string
	 */
	public function render() {
		$GLOBALS['TSFE']->additionalHeaderData['dialog-comment'] = $this->getScriptBlock();
		return $this->initiateSubRequest();
	}

	/**
	 * @return string
	 */
	protected function getScriptBlock() {
		$scriptUrl = t3lib_extMgm::siteRelPath('dialog') . 'Resources/Public/Javascripts/Plugins/Comment.js';
		$block = <<< EOD
<script type="text/javascript" src="$scriptUrl"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.tx-dialog-comment').dialogComments();
});
</script>
EOD;
		return $block;
	}

}
