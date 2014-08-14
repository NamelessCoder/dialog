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
 * @subpackage Controller
 */
abstract class Tx_Dialog_MVC_Controller_ActionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var Tx_Dialog_Domain_Repository_DiscussionRepository
	 */
	protected $discussionRepository;

	/**
	 * @var Tx_Dialog_Domain_Repository_PostRepository
	 */
	protected $postRepository;

	/**
	 * @var Tx_Dialog_Domain_Repository_ThreadRepository
	 */
	protected $threadRepository;

	/**
	 * @var Tx_Dialog_Domain_Repository_PosterRepository
	 */
	protected $posterRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Mvc\View\ViewInterface
	 */
	protected $view;

	/**
	 * @var Tx_Notify_Service_EmailService
	 */
	protected $emailService;

	/**
	 * @param Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository
	 * @return void
	 */
	public function injectDiscussionRepository(Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository) {
		$this->discussionRepository = $discussionRepository;
	}

	/**
	 * @param Tx_Dialog_Domain_Repository_PostRepository $postRepository
	 */
	public function injectPostRepository(Tx_Dialog_Domain_Repository_PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * @param Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository
	 */
	public function injectThreadRepository(Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository) {
		$this->threadRepository = $threadRepository;
	}

	/**
	 * @param Tx_Dialog_Domain_Repository_PosterRepository $posterRepository
	 */
	public function injectPosterRepository(Tx_Dialog_Domain_Repository_PosterRepository $posterRepository) {
		$this->posterRepository = $posterRepository;
	}

	/**
	 * @param Tx_Notify_Service_EmailService $emailService
	 */
	public function injectEmailService(Tx_Notify_Service_EmailService $emailService) {
		$this->emailService = $emailService;
	}

	/**
	 * Initialize action
	 */
	public function initializeAction() {
		session_start();
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view
	 * @return void
	 */
	public function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view) {
		session_start();
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$paths = Tx_Flux_Utility_Path::translatePath($settings['view']);
		$view = $this->objectManager->get('TYPO3\CMS\Fluid\View\TemplateView');
		$view->setControllerContext($this->controllerContext);
		$view->setLayoutRootPath($paths['layoutRootPath']);
		$view->setPartialRootPath($paths['partialRootPath']);
		$view->setTemplateRootPath($paths['templateRootPath'] . 'ViewHelpers/Widget/');
		$view->assign('settings', $this->settings);
		$view->assign('poster', $this->posterRepository->getOrCreatePoster());
		$this->view = $view;
	}

	/**
	 * @return void
	 */
	protected function assignDiscussionTemplateVariables() {
		if ($this->settings['discussions']) {
			$discussionUids = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['discussions']);
			$discussions = $this->discussionRepository->findByUids($discussionUids);
		} else {
			$discussions = $this->discussionRepository->findAll();
		}
		$this->view->assign('discussions', $discussions);
	}

}
?>