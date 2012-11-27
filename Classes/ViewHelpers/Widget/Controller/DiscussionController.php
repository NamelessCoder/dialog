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
 * @subpackage ViewHelpers/Widget/Controller
 */
class Tx_Dialog_ViewHelpers_Widget_Controller_DiscussionController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @var Tx_Dialog_Domain_Repository_ThreadRepository
	 */
	protected $threadRepository;

	/**
	 * @param Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository
	 * @return void
	 */
	public function injectThreadRepository(Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository) {
		$this->threadRepository = $threadRepository;
	}

	/**
	 * @return string
	 */
	public function indexAction() {
		$this->view->assignMultiple($this->widgetConfiguration);
		if (TRUE === isset($this->widgetConfiguration['discussion'])) {
			$this->view->assign('threads', $this->threadRepository->findByDiscussion($this->widgetConfiguration['discussion']->getUid()));
		}
	}

}
