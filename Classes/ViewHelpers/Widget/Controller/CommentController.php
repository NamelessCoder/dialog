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
class Tx_Dialog_ViewHelpers_Widget_Controller_CommentController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @var Tx_Dialog_Domain_Repository_DiscussionRepository
	 */
	protected $discussionRepository;

	/**
	 * @var Tx_Dialog_Domain_Repository_PostRepository
	 */
	protected $postRepository;

	/**
	 * @var Tx_Dialog_Domain_Repository_PosterRepository
	 */
	protected $posterRepository;

	/**
	 * @param Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository
	 * @return void
	 */
	public function injectDiscussionRepository(Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository) {
		$this->discussionRepository = $discussionRepository;
	}

	/**
	 * @param Tx_Dialog_Domain_Repository_PostRepository $postRepository
	 * @return void
	 */
	public function injectPostRepository(Tx_Dialog_Domain_Repository_PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * @param Tx_Dialog_Domain_Repository_PosterRepository $posterRepository
	 * @return void
	 */
	public function injectPosterRepository(Tx_Dialog_Domain_Repository_PosterRepository $posterRepository) {
		$this->posterRepository = $posterRepository;
	}

	/**
	 * @param string $hash
	 * @param boolean $ajax
	 * @return string
	 */
	public function indexAction($hash = NULL, $ajax = FALSE) {
		if ($hash === NULL) {
			$hash = $this->widgetConfiguration['hash'];
		}
		$discussion = $this->discussionRepository->getOrCreateByHash($hash, TRUE);
		$this->view->assignMultiple($this->widgetConfiguration);
		if ($this->request->hasArgument('ajax')) {
			$this->view->assign('placeholder', FALSE);
		}
		$this->view->assign('view', 'Discussion');
		$this->view->assign('discussion', $discussion);
		$this->view->assign('hash', $hash);
		$this->view->assign('ajax', $ajax);
		#return $discussion->getUid();
		return $this->view->render();
	}

	/**
	 * @param string $hash
	 * @param boolean $ajax
	 * @return string
	 */
	public function formAction($hash, $ajax = FALSE) {
		#return $hash;
		return $this->indexAction($hash, $ajax);
	}

	/**
	 * @param string $hash
	 * @param string $subject
	 * @param string $comment
	 * @return void
	 */
	public function writeAction($hash, $subject, $comment) {
		$discussion = $this->discussionRepository->getOrCreateByHash($hash, TRUE);
		/** @var $post Tx_Dialog_Domain_Model_Post */
		$post = $this->objectManager->create('Tx_Dialog_Domain_Model_Post');
		$poster = $this->posterRepository->getOrCreatePoster(TRUE);
		$post->setPoster($poster);
		$post->setSubject($subject);
		$post->setContent($comment);
		$discussion->addPost($post);
		$this->postRepository->add($post);
		if ($discussion->getUid()) {
			$this->discussionRepository->update($discussion);
		} else {
			$this->discussionRepository->add($discussion);
		}
		return;
	}

}
