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
 * @route NoMatch('bypass')
 */
class Tx_Dialog_Controller_DiscussionController extends Tx_Dialog_MVC_Controller_ActionController {

	/**
	 * Renders the initial view for Discussions
	 *
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @param integer $page
	 * @return string
	 * @route NoMatch('bypass') $discussion
	 * @route NoMatch('bypass') $thread
	 * @route NoMatch('bypass') $page
	 */
	public function indexAction(Tx_Dialog_Domain_Model_Discussion $discussion = NULL, Tx_Dialog_Domain_Model_Thread $thread = NULL, $page = 1) {
		$this->assignDiscussionTemplateVariables();
		$this->view->assign('view', 'Discussions');
		$this->view->assign('latest', $this->postRepository->findLatest($this->settings['numberOfLatestPosts']));
		$this->view->assign('frontendUser', $GLOBALS['TSFE']->fe_user->user);
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @param integer $page
	 * @return string
	 */
	public function showAction(Tx_Dialog_Domain_Model_Discussion $discussion = NULL, Tx_Dialog_Domain_Model_Thread $thread = NULL, $page = 1) {
		$this->assignDiscussionTemplateVariables();
		if ($discussion && $thread) {
			$mode = 'DiscussionThread';
		} elseif ($thread) {
			$mode = 'Thread';
		} elseif ($discussion) {
			$mode = 'Discussion';
		} else {
			$this->forward('index');
		}
		$this->view->assign('view', $mode);
		$this->view->assign('discussion', $discussion);
		$this->view->assign('thread', $thread);
		$this->view->assign('frontendUser', $GLOBALS['TSFE']->fe_user->user);
	}

	/**
	 * Report inapppropriate content
	 *
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param boolean $confirmed
	 * @return string
	 */
	public function reportAction(Tx_Dialog_Domain_Model_Post $post, $confirmed=FALSE) {
		$this->view->assign('view', 'Report');
		$this->view->assign('post', $post);
		$thread = NULL;
		while (!$thread && $post) {
			$thread = $post->getThread();
			$post = $post->getPost();
		}
		$this->view->assign('thread', $thread);
		$this->view->assign('discussion', $thread->getDiscussion());
		$this->view->assign('confirmed', $confirmed);
		if ((bool) $confirmed === FALSE) {
			return $this->view->render();
		}
		$settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$paths = Tx_Fed_Utility_Path::translatePath($settings['view']);
		$url = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' . '://' . $_SERVER['SERVER_NAME'] . '/';
		$variables = array(
			'settings' => $this->settings,
			'section' => 'ReportInappropriate',
			'link' => $url . $this->uriBuilder->uriFor('show', array(

			))
		);
		$view = $this->objectManager->get('Tx_Fluid_View_TemplateView');
		$view->setControllerContext($this->controllerContext);
		$view->setLayoutRootPath($paths['layoutRootPath']);
		$view->setPartialRootPath($paths['partialRootPath']);
		$view->setTemplateRootPath($paths['templateRootPath'] . 'ViewHelpers/Widget/');
		$view->setTemplatePathAndFilename($paths['partialRootPath'] . 'Discussion/Emails.html');
		$view->assignMultiple($variables);
		$body = $view->render();

		$subject = Tx_Extbase_Utility_Localization::translate('subject', 'dialog');
		try {
			$this->emailService->mail($subject, $body, $this->settings['email']['fromEmail'], $this->settings['email']['fromName'], $this->settings['email']['fromEmail'], $this->settings['email']['fromName']);
		} catch (Exception $e) {
			t3lib_div::sysLog('Failed to send email message: ' . $e->getMessage(), 'dialog');
		}
	}

	/**
	 * Initializes the writeAction
	 *
	 * @return void
	 */
	public function initializeWriteAction() {
		$this->arguments->getArgumentNames();
		$this->arguments->getArgument('post')->getPropertyMappingConfiguration()->allowCreationForSubProperty('poster');
		$this->arguments->getArgument('thread')->setRequired(FALSE); // getPropertyMappingConfiguration()->;
	}

	/**
	 * Renders the "add new" form (url params describe what to add and where)
	 *
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @param Tx_Dialog_Domain_Model_Post $parent
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param array $errors
	 * @return string
	 * @dontvalidate $discussion
	 * @dontvalidate $thread
	 * @dontvalidate $parent
	 * @dontvalidate $post
	 * @route off $post
	 * @route off $errors
	 */
	public function writeAction(
			Tx_Dialog_Domain_Model_Discussion $discussion=NULL,
			Tx_Dialog_Domain_Model_Thread $thread=NULL,
			Tx_Dialog_Domain_Model_Post $parent=NULL,
			Tx_Dialog_Domain_Model_Post $post=NULL,
			$errors=array()) {
		$poster = $this->posterRepository->getOrCreatePoster();
		if ($poster === NULL) {
			$poster = $this->objectManager->create('Tx_Dialog_Domain_Model_Poster');
		}
		if ($post === NULL) {
			$respondPrefix = $this->settings['responsePrefix'];
			$post = $this->objectManager->create('Tx_Dialog_Domain_Model_Post');
			$post->setPoster($poster);
			if ($parent) {
				$subject = $parent->getSubject();
				$post->setSubject((strpos($subject, $respondPrefix) !== 0 ? $respondPrefix . ' ' : '') . $subject);
			}
		}

		$this->assignDiscussionTemplateVariables();
		$this->view->assign('frontendUser', $GLOBALS['TSFE']->fe_user->user);
		$this->view->assign('view', 'Write');
		$this->view->assign('post', $post);
		$this->view->assign('discussion', $discussion);
		$this->view->assign('thread', $thread);
		$this->view->assign('parent', $parent);
		$this->view->assign('poster', $poster);
		$this->view->assign('errors', $errors);
	}

	/**
	 * Initializes the postAction
	 *
	 * @return void
	 */
	public function initializePostAction() {
		$this->arguments->getArgumentNames();
		$this->arguments->getArgument('post')->getPropertyMappingConfiguration()->allowCreationForSubProperty('poster');
		$this->arguments->getArgument('thread')->setRequired(FALSE); // getPropertyMappingConfiguration()->;
	}

	/**
	 * Adds a new Post (or Thread created from Post if making new Thread) to the Repository
	 *
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @param Tx_Dialog_Domain_Model_Post $parent
	 * @return string
	 */
	public function postAction(
			Tx_Dialog_Domain_Model_Post $post=NULL,
			Tx_Dialog_Domain_Model_Discussion $discussion=NULL,
			Tx_Dialog_Domain_Model_Thread $thread=NULL,
			Tx_Dialog_Domain_Model_Post $parent=NULL) {
		$arguments = array();
		$now = new DateTime();

		$requestAuthorizationEmail = FALSE;
		$poster = $this->$this->posterRepository->getOrCreatePoster();
		if (!$poster && $this->posterRepository->findByEmail($post->getPoster()->getEmail())->count() > 0) {
			$poster = $this->posterRepository->findOneByEmail($post->getPoster()->getEmail());
			$post->setPublished(0);
			$requestAuthorizationEmail = TRUE;
		} else {
			$poster = $this->posterRepository->getOrCreatePoster();
			if ($poster) {
				$post->setPublished(1);
			} else {
				$poster = $post->getPoster();
				$requestAuthorizationEmail = TRUE;
				$this->posterRepository->add($poster);
			}
		}

		if ($poster->getEmail() == '') {
			$this->posterErrors['email'] = 'ERR';
		}
		if ($poster->getName() == '') {
			$this->posterErrors['name'] = 'ERR';
		}
		if (count($this->posterErrors) > 0) {
			$requestArguments = $this->request->getArguments();
			$requestArguments['errors'] = $this->posterErrors;
			$this->forward('write', NULL, NULL, $requestArguments);
		}
		if ($requestAuthorizationEmail === TRUE) {
			if ($poster->getIdentifier() == '') {
				$poster->setIdentifier(md5(microtime(TRUE) * time()));
			}
			$this->sendAuthenticationEmail($poster);
		}

		$hash = NULL;
		$post->setPoster($poster);
		if ($discussion === NULL) {
			$discussion = $this->objectManager->create('Tx_Dialog_Domain_Model_Discussion');
			$discussion->setTitle($post->getSubject());
			$discussion->setDescription($post->getContent());
			$discussion->setPoster($poster);
			$this->discussionRepository->add($discussion);
			$this->cacheService->clearPageCache(array($GLOBALS['TSFE']->id));
			$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
			$this->redirect('show', NULL, NULL, array('discussion' => $discussion->getUid()));
		} elseif ($thread === NULL) {
			$hash = md5(microtime(TRUE) * time());
			$thread = $this->objectManager->create('Tx_Dialog_Domain_Model_Thread');
			$thread->setSubject($post->getSubject());
			$thread->setPoster($poster);
			$thread->setCrdate($now);
			$thread->addPost($post);
			$thread->setHash($hash);
			$this->threadRepository->add($thread);
		} else {
			$hash = $thread->getHash();
			$thread->setCrdate($now);
			$this->threadRepository->update($thread);
			$arguments['thread'] = $thread->getUid();
		}
		if ($discussion !== NULL) {
			$arguments['discussion'] = $discussion->getUid();
			$discussion->addThread($thread);
			$discussion->setCrdate($now);
			$this->discussionRepository->update($discussion);
		}
		if ($parent) {
			$hash = $parent->getHash();
			$parent->addReply($post);
			$this->postRepository->update($parent);
		} else {
			$thread->addPost($post);
		}
		if ($hash) {
			$post->setHash($hash);
		}
		$post->getCrdate($now);
		$this->postRepository->add($post);
		$this->flashMessageContainer->add('Your post was added');
		if (FALSE) {
				// TODO: re-work scoring
			$this->calculatePopularityOfThread($post, $thread);
			$this->calculatePopularityOfDiscussion($discussion);
		}
		$this->cacheService->clearPageCache(array($GLOBALS['TSFE']->id));
		$this->objectManager->get('Tx_Extbase_Persistence_ManagerInterface')->persistAll();
		$this->uriBuilder->setSection('p' . $post->getUid());
		$this->redirectToUri($this->uriBuilder->uriFor('show', $arguments));
	}

	/**
	 * Forgets the user (cookie, session) identified by this $identifier
	 *
	 * @param string $identifier
	 * @param boolean $remove
	 * @return string
	 */
	public function forgetAction($identifier, $remove=FALSE) {
		$poster = $this->posterRepository->findOneByIdentifier($identifier);
		if ((bool) $remove === TRUE) {
			$poster->setIdentifier('');
			$this->posterRepository->update($poster);
		}
		setcookie('dialog_poster_identifier', '', time() - 1);
		unset($_SESSION['dialog_poster_identity']);
		$this->redirect('index');
	}

	/**
	 * @param string $identifier
	 * @param boolean $cookie
	 */
	public function authorizeAction($identifier, $cookie=FALSE) {
		$poster = $this->posterRepository->findOneByIdentifier($identifier);
		if (!$poster) {
			$this->redirect('index');
		}
		$posts = $this->postRepository->findByPosterAndUnpublished($poster);
		foreach ($posts as $post) {
			$post->setPublished(1);
			$this->postRepository->update($post);
		}
		if ((bool) $cookie === TRUE) {
			setcookie('dialog_poster_identifier', $identifier, time() + $this->settings['cookieLifetime']);
		} else {
			$_SESSION['dialog_poster_identifier'] = $identifier;
		}
		$this->redirect('index');
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @return void
	 */
	protected function calculatePopularityOfThread(Tx_Dialog_Domain_Model_Post $post, Tx_Dialog_Domain_Model_Thread &$thread) {
		$hash = $post->getHash();
		$now = time();
		$halflife = intval($this->settings['popularityHalflife']);
		$posts = $this->postRepository->findByHash($hash);
		$popularity = 0.0;
		foreach ($posts as $relatedPost) {
			$dateTime = $relatedPost->getCrdate();
			if ($dateTime) {
				$timestamp = $dateTime->format('U');
				$popularity += exp(($timestamp - $now) * log(2) / $halflife);
			}
		}
		$popularity = ceil($popularity);
		$thread->setPopularity($popularity);
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @return void
	 */
	protected function calculatePopularityOfDiscussion(Tx_Dialog_Domain_Model_Discussion $discussion) {

	}

	/**
	 * @param Tx_Dialog_Domain_Model_Poster $poster
	 */
	protected function sendAuthenticationEmail(Tx_Dialog_Domain_Model_Poster $poster) {
		$settings = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$paths = Tx_Fed_Utility_Path::translatePath($settings['view']);
		$url = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' . '://' . $_SERVER['SERVER_NAME'] . '/';
		$variables = array(
			'settings' => $this->settings,
			'poster' => $poster,
			'section' => 'Authorization',
			'links' => array(
				$poster->getEmail(),
				$url . $this->buildEmailLink('authorize', array('identifier' => $poster->getIdentifier(), 'cookie' => 1)),
				$url . $this->buildEmailLink('authorize', array('identifier' => $poster->getIdentifier(), 'cookie' => 0)),
				$url . $this->buildEmailLink('forget', array('identifier' => $poster->getIdentifier()))
			)
		);
		$view = $this->objectManager->get('Tx_Fluid_View_TemplateView');
		$view->setControllerContext($this->controllerContext);
		$view->setLayoutRootPath($paths['layoutRootPath']);
		$view->setPartialRootPath($paths['partialRootPath']);
		$view->setTemplateRootPath($paths['templateRootPath'] . 'ViewHelpers/Widget/');
		$view->setTemplatePathAndFilename($paths['partialRootPath'] . 'Discussion/Emails.html');
		$view->assignMultiple($variables);
		$body = $view->render();
		#$body = str_replace('&amp;', '&', $body);
		$body = html_entity_decode($body);

		$subject = Tx_Extbase_Utility_Localization::translate('email.authorization.subject', 'dialog');
		try {
			$this->emailService->mail($subject, $body, $poster->getEmail(), $poster->getName(), $this->settings['email']['fromEmail'], $this->settings['email']['fromName']);
		} catch (Exception $e) {
			t3lib_div::sysLog('Failed to send email message: ' . $e->getMessage(), 'dialog');
		}

	}

	/**
	 * @param string $action
	 * @param array $arguments
	 * @return string
	 */
	protected function buildEmailLink($action, $arguments=array()) {
		$link = $this->uriBuilder->uriFor($action,$arguments);
		return $link;
	}

}
?>
