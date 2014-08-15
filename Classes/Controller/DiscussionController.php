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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package Dialog
 * @subpackage Controller
 * @route NoMatch('bypass')
 */
class Tx_Dialog_Controller_DiscussionController extends Tx_Dialog_MVC_Controller_ActionController {

	/**
	 * @return void
	 */
	public function initializeAction() {
		$key = 'tx_dialog_discussion_recency';
		$timestamp = time();
		$expiration = $timestamp + $this->settings['cookieLifetime'];
		$sessionId = session_id();
		if (empty($sessionId)) {
			session_start();
		}
		if (isset($_SESSION[$key]) === FALSE) {
			if (isset($_COOKIE[$key])) {
				$timestamp = $_COOKIE[$key];
			}
			$_SESSION[$key] = array(
				'timestamp' => $timestamp,
				'posts' => array()
			);
		}
		setcookie($key, $timestamp, $expiration);
	}

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
		$this->view->assign('uploadFolder', $GLOBALS['TCA']['tx_dialog_domain_model_post']['columns']['attachments']['config']['uploadfolder']);
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @return string
	 */
	public function editAction(Tx_Dialog_Domain_Model_Post $post = NULL, Tx_Dialog_Domain_Model_Discussion $discussion = NULL, Tx_Dialog_Domain_Model_Thread $thread = NULL) {
		$poster = $this->posterRepository->getOrCreatePoster(TRUE);
		if (!$post || !$poster || ($post && $post->getPoster() && $post->getPoster()->getUid() !== $poster->getUid())) {
			$this->view->assign('view', 'NoAccess');
			return $this->view->render();;
		}
		$this->view->assign('view', 'Write');
		$this->view->assign('discussion', $discussion);
		$this->view->assign('thread', $thread);
		$this->view->assign('post', $post);
		$this->view->assign('frontendUser', $GLOBALS['TSFE']->fe_user->user);
		$this->view->assign('poster', $poster);
		$this->view->assign('uploadFolder', $GLOBALS['TCA']['tx_dialog_domain_model_post']['columns']['attachments']['config']['uploadfolder']);
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
		if ($discussion) {
			$this->view->assign('threads', $this->threadRepository->findByDiscussion($discussion->getUid()));
		}
		$this->view->assign('view', $mode);
		$this->view->assign('discussion', $discussion);
		$this->view->assign('thread', $thread);
		$this->view->assign('frontendUser', $GLOBALS['TSFE']->fe_user->user);
		$this->view->assign('poster', $this->posterRepository->getOrCreatePoster(TRUE));
		$this->view->assign('uploadFolder', $GLOBALS['TCA']['tx_dialog_domain_model_post']['columns']['attachments']['config']['uploadfolder']);
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
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$paths = Tx_Flux_Utility_Path::translatePath($settings['view']);
		$url = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' . '://' . $_SERVER['SERVER_NAME'] . '/';
		$variables = array(
			'settings' => $this->settings,
			'section' => 'ReportInappropriate',
			'link' => $url . $this->uriBuilder->uriFor('show', array(

			))
		);
		$view = $this->objectManager->get('TYPO3\CMS\Fluid\View\TemplateView');
		$view->setControllerContext($this->controllerContext);
		$view->setLayoutRootPath($paths['layoutRootPath']);
		$view->setPartialRootPath($paths['partialRootPath']);
		$view->setTemplateRootPath($paths['templateRootPath'] . 'ViewHelpers/Widget/');
		$view->setTemplatePathAndFilename($paths['partialRootPath'] . 'Discussion/Emails.html');
		$view->assignMultiple($variables);
		$body = $view->render();

		$subject = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('subject', 'dialog');
		try {
			$this->emailService->mail($subject, $body, $this->settings['email']['fromEmail'], $this->settings['email']['fromName'], $this->settings['email']['fromEmail'], $this->settings['email']['fromName']);
		} catch (Exception $e) {
			GeneralUtility::sysLog('Failed to send email message: ' . $e->getMessage(), 'dialog');
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
	 * @param Tx_Dialog_Domain_Model_Poster $poster
	 * @param array $errors
	 * @return string
	 * @dontvalidate $discussion
	 * @dontvalidate $thread
	 * @dontvalidate $parent
	 * @dontvalidate $post
	 * @dontvalidate $poster
	 * @route off $post
	 */
	public function writeAction(
			Tx_Dialog_Domain_Model_Discussion $discussion=NULL,
			Tx_Dialog_Domain_Model_Thread $thread=NULL,
			Tx_Dialog_Domain_Model_Post $parent=NULL,
			Tx_Dialog_Domain_Model_Post $post=NULL,
			Tx_Dialog_Domain_Model_Poster $poster=NULL,
			array $errors = array()) {
		$poster = $this->posterRepository->getOrCreatePoster();
		if ($poster === NULL) {
			$poster = $this->objectManager->get('Tx_Dialog_Domain_Model_Poster');
		}
		if ($post === NULL) {
			$respondPrefix = $this->settings['responsePrefix'];
			$post = $this->objectManager->get('Tx_Dialog_Domain_Model_Post');
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
		$this->view->assign('uploadFolder', $GLOBALS['TCA']['tx_dialog_domain_model_post']['columns']['attachments']['config']['uploadfolder']);
	}

	/**
	 * Initializes the postAction
	 *
	 * @return void
	 */
	public function initializePostAction() {
		$this->arguments->getArgumentNames();
		$this->arguments->getArgument('post')->getPropertyMappingConfiguration()->allowCreationForSubProperty('poster');
		$this->arguments->getArgument('post')->getPropertyMappingConfiguration()->allowProperties('poster');
		$this->arguments->getArgument('thread')->setRequired(FALSE); // getPropertyMappingConfiguration()->;
	}

	/**
	 * Adds a new Post (or Thread created from Post if making new Thread) to the Repository
	 *
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @param Tx_Dialog_Domain_Model_Post $parent
	 * @param string $url Not an URL - a very simple honey pot. If filled, simulate a black hole. Field in form is CSS-hidden.
	 * @return string
	 */
	public function postAction(
			Tx_Dialog_Domain_Model_Post $post=NULL,
			Tx_Dialog_Domain_Model_Discussion $discussion=NULL,
			Tx_Dialog_Domain_Model_Thread $thread=NULL,
			Tx_Dialog_Domain_Model_Post $parent=NULL,
			$url=NULL) {
		if ($url) {
			sleep(99999999);
		}
		$requestAuthorizationEmail = FALSE;
		$arguments = $this->request->getArguments();
		$now = new DateTime();

		$poster = $post->getPoster();
			// validate Poster identity
		$currentIdentity = $this->posterRepository->getOrCreatePoster(TRUE);
		if ($currentIdentity) {
				// Poster recognised, check his identity against submitted personal info
			if ($poster->getEmail() != $currentIdentity->getEmail()) {
					// Poster is attempting to write a Post as another identity; reject.
				$this->view->assign('view', 'NoAccess');
				return $this->view->render('Show');
			} else {
					// is validated; replace unpersisted Poster on
				$post->setPoster($currentIdentity);
				$post->setPublished(1);
					// Poster attempting an update. Check for expiration of access (identity match is checked above)
				if ($post->getUid() > 0) {
					$editingIsExpired = $post->getCrdate()->getTimestamp() < (time() - $this->settings['editingExpiration']) && $this->settings['editingExpiration'] > 0;
					if ($editingIsExpired) {
						$this->view->assign('view', 'NoAccess');
						return $this->view->render('Show');
					}
					$arguments['thread'] = $thread ? $thread->getUid() : NULL;
					$arguments['discussion'] = $discussion ? $discussion->getUid() : NULL;
						// immediately update, bypassing any sending of authorization email requests
					$this->postRepository->update($post);
					$this->uriBuilder->setSection('p' . $post->getUid());
					$this->redirectToUri($this->uriBuilder->uriFor('show', $arguments));
				}
			}
		}
			// reload Poster, in case Poster was replaced above. Validate and exit with errors if invalid
		$poster = $post->getPoster();
		$posterErrors = array();
		if (trim($poster->getEmail()) == '') {
			$posterErrors['email'] = 1;
		}
		if (trim($poster->getName()) == '') {
			$posterErrors['name'] = 1;
		}
		if (count($posterErrors) > 0) {
			$arguments['errors'] = $posterErrors;
			$this->forward('write', NULL, NULL, $arguments);
		}
			// case matched if current identity exists and matches Poster details given in Post,
			// which means it is safe to publish the Post right away. Else, add the new Poster,
			// set published to "no" and request sending of an authorization email message.
		if ($currentIdentity) {
			$post->setPublished(1);
			$requestAuthorizationEmail = FALSE;
		} else {
			$existingPoster = $this->posterRepository->findOneByEmail($poster->getEmail());
			if ($existingPoster) {
				$poster = $existingPoster;
			} else {
				$this->posterRepository->add($poster);
			}
			$post->setPublished(0);
			$requestAuthorizationEmail = TRUE;
		}
		if ($requestAuthorizationEmail === TRUE) {
			if ($poster->getIdentifier() == '') {
				$poster->setIdentifier(md5(microtime(TRUE) * time()));
			}
			$this->sendAuthenticationEmail($poster);
			$this->flashMessageContainer->add(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('authorizationRequestSent', 'Dialog'));
		}
		$hash = NULL;
		$post->setPoster($poster);
		if ($discussion === NULL) {
			$discussion = $this->objectManager->get('Tx_Dialog_Domain_Model_Discussion');
			$discussion->setTitle($post->getSubject());
			$discussion->setDescription($post->getContent());
			$discussion->setPoster($poster);
			$discussion->setLastPost($post);
			$this->discussionRepository->add($discussion);
			$this->cacheService->clearPageCache(array($GLOBALS['TSFE']->id));
			$this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager')->persistAll();
			$this->redirect('show', NULL, NULL, array('discussion' => $discussion->getUid()));
		} elseif ($thread === NULL) {
			$hash = md5(microtime(TRUE) * time());
			$thread = $this->objectManager->get('Tx_Dialog_Domain_Model_Thread');
			$thread->setSubject($post->getSubject());
			$thread->setPoster($poster);
			$thread->addPost($post);
			$thread->setHash($hash);
			$thread->setLastPost($post);
			$this->threadRepository->add($thread);
		} else {
			$hash = $thread->getHash();
			$thread->setLastPost($post);
			$this->threadRepository->update($thread);
		}
		if ($parent) {
			$hash = $parent->getHash();
			$parent->addReply($post);
			$this->postRepository->update($parent);
		} else {
			$thread->addPost($post);
			$hash = $thread->getHash();
		}

		$discussion->addThread($thread);
		$discussion->setLastActivity($now);
		$thread->setLastActivity($now);
		$post->setCrdate($now);
		$post->setHash($hash);
		$uploadedFiles = $this->uploadFiles('attachments', 'files');
		$uploadedImages = $this->uploadFiles('images', 'images');
		if (count($uploadedFiles) > 0) {
			$post->setAttachments(implode(',', $uploadedFiles));
		}
		if (count($uploadedImages) > 0) {
			$post->setImages(implode(',', $uploadedImages));
		}
		$this->postRepository->add($post);
		$this->discussionRepository->update($discussion);
		$this->objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();
		$arguments['discussion'] = $discussion->getUid();
		$arguments['thread'] = $thread->getUid();
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
	 * @param Tx_Dialog_Domain_Model_Poster $poster
	 * @throws Exception
	 */
	protected function sendAuthenticationEmail(Tx_Dialog_Domain_Model_Poster $poster) {
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$paths = Tx_Flux_Utility_Path::translatePath($settings['view']);
		$url = $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' . '://' . $_SERVER['SERVER_NAME'] . '/';
		$variables = array(
			'settings' => $this->settings,
			'poster' => $poster,
			'section' => 'Authorization',
			'links' => array(
				$poster->getEmail(),
				$this->buildEmailLink('authorize', array('identifier' => $poster->getIdentifier(), 'cookie' => 1)),
				$this->buildEmailLink('authorize', array('identifier' => $poster->getIdentifier(), 'cookie' => 0)),
				$this->buildEmailLink('forget', array('identifier' => $poster->getIdentifier()))
			)
		);
		$view = $this->objectManager->get('TYPO3\CMS\Fluid\View\TemplateView');
		$view->setControllerContext($this->controllerContext);
		$view->setLayoutRootPath($paths['layoutRootPath']);
		$view->setPartialRootPath($paths['partialRootPath']);
		$view->setTemplateRootPath($paths['templateRootPath'] . 'ViewHelpers/Widget/');
		$view->setTemplatePathAndFilename($paths['partialRootPath'] . 'Discussion/Emails.html');
		$view->assignMultiple($variables);
		$body = $view->render();
		$body = html_entity_decode($body);

		$subject = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('email.authorization.subject', 'dialog');
		try {
			$recipient = array($poster->getEmail() => $poster->getName());
			$sender = array($this->settings['email']['fromEmail'] => $this->settings['email']['fromName']);
			$this->emailService->mail($subject, $body, $recipient, $sender);
		} catch (Exception $e) {
			GeneralUtility::sysLog('Failed to send email message: ' . $e->getMessage(), 'dialog');
			throw $e;
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

	/**
	 * @param string $fieldName
	 * @param string $settingName
	 * @return array
	 */
	protected function uploadFiles($fieldName, $settingName) {
		$allowedExtensions = GeneralUtility::trimExplode(',', $this->settings['attachments'][$settingName]['extensions']);
		$extensionMap = $this->settings['attachments']['renaming'];
		$files = array();
		if (isset($_FILES['tx_dialog_discussion'])) {
			foreach ($_FILES['tx_dialog_discussion']['tmp_name'][$fieldName] as $index => $name) {
				array_push($files, array(
					'name' => $_FILES['tx_dialog_discussion']['name'][$fieldName][$index],
					'tmp_name' => $_FILES['tx_dialog_discussion']['tmp_name'][$fieldName][$index],
					'type' => $_FILES['tx_dialog_discussion']['type'][$fieldName][$index],
					'size' => $_FILES['tx_dialog_discussion']['size'][$fieldName][$index],
					'error' => $_FILES['tx_dialog_discussion']['error'][$fieldName][$index]
				));
			}
		}
		$filenames = array();
		/** @var $fileHandler \TYPO3\CMS\Core\Utility\File\BasicFileUtility */
		$fileHandler = GeneralUtility::makeInstance('TYPO3\CMS\Core\Utility\File\BasicFileUtility');
		$targetDir = PATH_site . $GLOBALS['TCA']['tx_dialog_domain_model_post']['columns'][$fieldName]['config']['uploadfolder'] . '/';
		foreach ($files as $uploadedFile) {
			if (is_uploaded_file($uploadedFile['tmp_name']) === TRUE) {
				$filename = $uploadedFile['name'];
				$extension = pathinfo($filename, PATHINFO_EXTENSION);
				if (!in_array($extension, $allowedExtensions)) {
					continue;
				}
				$filename = $fileHandler->cleanFileName($filename);
				$i = 1;
				$targetFilename = $targetDir . $filename;
				while (file_exists($targetFilename)) {
					$filename = basename($fileHandler->getUniqueName($filename, $targetDir));
					$targetFilename = $targetDir . $filename;
				}
				if (isset($extensionMap[$extension])) {
					$targetFilename = substr($targetFilename, 0, 0 - strlen($extension)) . $extensionMap[$extension];
					$filename = substr($filename, 0, 0 - strlen($extension)) . $extensionMap[$extension];
				}
				move_uploaded_file($uploadedFile['tmp_name'], $targetFilename);
				array_push($filenames, $filename);
			}
		}
		return $filenames;
	}

}
