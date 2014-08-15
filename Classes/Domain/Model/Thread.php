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
class Tx_Dialog_Domain_Model_Thread extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $subject;

	/**
	 * Hash identifier
	 *
	 * @var string
	 */
	protected $hash;

	/**
	 * Posts
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post>
	 * @lazy
	 */
	protected $posts;

	/**
	 * @var Tx_Dialog_Domain_Model_Poster
	 */
	protected $poster;

	/**
	 * @var DateTime
	 */
	protected $crdate;

	/**
	 * Last activity
	 *
	 * @var DateTime
	 */
	protected $lastActivity;

	/**
	 * @var Tx_Dialog_Domain_Model_Post
	 */
	protected $lastPost;

	/**
	 * @var Tx_Dialog_Domain_Model_Discussion
	 */
	protected $discussion;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->posts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @param Tx_Dialog_Domain_Model_Post $post
	 * @return void
	 */
	public function addPost(Tx_Dialog_Domain_Model_Post $post) {
		$this->posts->attach($post);
	}

	/**
	 * Removes a Post
	 *
	 * @param Tx_Dialog_Domain_Model_Post $postToRemove The Post to be removed
	 * @return void
	 */
	public function removePost(Tx_Dialog_Domain_Model_Post $postToRemove) {
		$this->posts->detach($postToRemove);
	}

	/**
	 * Returns the posts
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post> $posts
	 */
	public function getPosts() {
		$storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		foreach ($this->posts as $post) {
			if ($post->getPublished()) {
				$storage->attach($post);
			}
		}
		return $storage;
	}

	/**
	 * Sets the posts
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Dialog_Domain_Model_Post> $posts
	 * @return void
	 */
	public function setPosts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $posts) {
		$this->posts = $posts;
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
	 * @param DateTime $lastActivity
	 */
	public function setLastActivity($lastActivity) {
		$this->lastActivity = $lastActivity;
	}

	/**
	 * @return DateTime
	 */
	public function getLastActivity() {
		return $this->lastActivity;
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Post $lastPost
	 */
	public function setLastPost($lastPost) {
		$this->lastPost = $lastPost;
	}

	/**
	 * @return Tx_Dialog_Domain_Model_Post
	 */
	public function getLastPost() {
		return $this->lastPost;
	}

	/**
	 * @return Tx_Dialog_Domain_Model_Discussion
	 */
	public function getDiscussion() {
		return $this->discussion;
	}

	/**
	 * @param null|Tx_Dialog_Domain_Model_Discussion $discussion
	 */
	public function setDiscussion(Tx_Dialog_Domain_Model_Discussion $discussion=NULL) {
		$this->discussion = $discussion;
	}

}
?>