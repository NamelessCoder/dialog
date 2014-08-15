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
 *
 *
 * @package dialog
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Dialog_Domain_Model_Post extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $subject;

	/**
	 * Content
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $content;

	/**
	 * @var DateTime
	 */
	protected $crdate;

	/**
	 * Hash identifier
	 *
	 * @var string
	 */
	protected $hash;

	/**
	 * Replies
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post>
	 * @lazy
	 */
	protected $replies;

	/**
	 * @var Tx_Dialog_Domain_Model_Poster
	 */
	protected $poster;

	/**
	 * @var Tx_Dialog_Domain_Model_Thread
	 */
	protected $thread;

	/**
	 * @var Tx_Dialog_Domain_Model_Post
	 */
	protected $post;

	/**
	 * @var string
	 */
	protected $attachments;

	/**
	 * @var string
	 */
	protected $images;

	/**
	 * @var boolean
	 */
	protected $published;

	/**
	 * @var string
	 */
	protected $cachedMarkdown;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->replies = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param $subject
	 */
	public function setSubject($subject) {
		$this->subject = ucfirst($subject);
	}

	/**
	 * Returns the content
	 *
	 * @return string $content
	 */
	public function getContent() {
		return str_replace("\n\n", '<br />', $this->content);
	}

	/**
	 * Sets the content
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		/** @var $markdownViewHelper Tx_Vhs_ViewHelpers_Format_MarkdownViewHelper */
		$markdownViewHelper = $this->objectManager->get('Tx_Vhs_ViewHelpers_Format_MarkdownViewHelper');
		$this->content = trim($content);
		try {
			$cachedMarkdown = $markdownViewHelper->render($content, TRUE);
			$cachedMarkdown = str_replace('<pre>', '<pre class="prettyprint linenums:1">', $cachedMarkdown);
			$this->setCachedMarkdown($cachedMarkdown);
		} catch (Exception $error) {
			unset($error);
		}
	}

	/**
	 * @param DateTime $crdate
	 */
	public function setCrdate(DateTime $crdate=NULL) {
		$this->crdate = $crdate;
	}

	/**
	 * @return DateTime
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 * Returns the hash
	 *
	 * @return string $hash
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Sets the hash
	 *
	 * @param string $hash
	 * @return void
	 */
	public function setHash($hash) {
		$this->hash = $hash;
	}

	/**
	 * Adds a Post
	 *
	 * @param Tx_Dialog_Domain_Model_Post $reply
	 * @return void
	 */
	public function addReply(Tx_Dialog_Domain_Model_Post $reply) {
		$this->replies->attach($reply);
	}

	/**
	 * Removes a Post
	 *
	 * @param Tx_Dialog_Domain_Model_Post $replyToRemove The Post to be removed
	 * @return void
	 */
	public function removeReply(Tx_Dialog_Domain_Model_Post $replyToRemove) {
		$this->replies->detach($replyToRemove);
	}

	/**
	 * Returns the replies
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post> $replies
	 */
	public function getReplies() {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		foreach ($this->replies as $reply) {
			if ($reply->getPublished()) {
				$storage->attach($reply);
			}
		}
		return $this->replies;
	}

	/**
	 * Sets the replies
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post> $replies
	 * @return void
	 */
	public function setReplies(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $replies) {
		$this->replies = $replies;
	}

	/**
	 * @return Tx_Dialog_Domain_Model_Poster
	 */
	public function getPoster() {
		return $this->poster;
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Poster $poster
	 */
	public function setPoster(Tx_Dialog_Domain_Model_Poster $poster) {
		$this->poster = $poster;
	}

	/**
	 * @return Tx_Dialog_Domain_Model_Thread
	 */
	public function getThread() {
		return $this->thread;
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 */
	public function setThread(Tx_Dialog_Domain_Model_Thread $thread=NULL) {
		$this->thread = $thread;
	}

	/**
	 * @return Tx_Dialog_Domain_Model_Post
	 */
	public function getPost() {
		return $this->post;
	}

	/**
	 * @param null|Tx_Dialog_Domain_Model_Post $post
	 */
	public function setPost(Tx_Dialog_Domain_Model_Post $post=NULL) {
		$this->post = $post;
	}

	/**
	 * @param string $attachments
	 */
	public function setAttachments($attachments) {
		$this->attachments = trim($attachments, ', ');
	}

	/**
	 * @return string
	 */
	public function getAttachments() {
		return trim($this->attachments, ', ');
	}

	/**
	 * @param string $images
	 */
	public function setImages($images) {
		$this->images = trim($images, ', ');
	}

	/**
	 * @return string
	 */
	public function getImages() {
		return trim($this->images, ', ');
	}

	/**
	 * @return boolean
	 */
	public function getPublished() {
		return $this->published;
	}

	/**
	 * @param boolean $published
	 */
	public function setPublished($published) {
		$this->published = $published;
	}

	/**
	 * @param string $cachedMarkdown
	 */
	public function setCachedMarkdown($cachedMarkdown) {
		$this->cachedMarkdown = trim($cachedMarkdown);
	}

	/**
	 * @return string
	 */
	public function getCachedMarkdown() {
		return $this->cachedMarkdown;
	}

}
