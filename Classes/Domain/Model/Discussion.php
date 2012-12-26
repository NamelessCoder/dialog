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
class Tx_Dialog_Domain_Model_Discussion extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var DateTime
	 */
	protected $crdate;

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * Mode
	 *
	 * @var integer
	 */
	protected $mode;

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
	 * Hash identifier
	 *
	 * @var string
	 */
	protected $hash;

	/**
	 * Threads
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Thread>
	 * @lazy
	 */
	protected $threads;

	/**
	 * Posts
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Post>
	 * @lazy
	 */
	protected $posts;

	/**
	 * @var Tx_Dialog_Domain_Model_Poster
	 */
	protected $poster;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->threads = new Tx_Extbase_Persistence_ObjectStorage();
		$this->posts = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = ucfirst($title);
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return preg_replace('/[\s]{2,}/i', "\n", $this->description);
		#return str_replace("\n\n", "\n", $this->description);
	}

	/**
	 * @param $description
	 */
	public function setDescription($description) {
		$this->description = trim($description);
	}

	/**
	 * Returns the mode
	 *
	 * @return integer $mode
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * Sets the mode
	 *
	 * @param integer $mode
	 * @return void
	 */
	public function setMode($mode) {
		$this->mode = $mode;
	}

	/**
	 * Returns the lastActivity
	 *
	 * @return DateTime $lastActivity
	 */
	public function getLastActivity() {
		return $this->lastActivity;
	}

	/**
	 * Sets the lastActivity
	 *
	 * @param DateTime $lastActivity
	 * @return void
	 */
	public function setLastActivity($lastActivity) {
		$this->lastActivity = $lastActivity;
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
	 * Adds a Thread
	 *
	 * @param Tx_Dialog_Domain_Model_Thread $thread
	 * @return void
	 */
	public function addThread(Tx_Dialog_Domain_Model_Thread $thread) {
		$this->threads->attach($thread);
	}

	/**
	 * Removes a Thread
	 *
	 * @param Tx_Dialog_Domain_Model_Thread $threadToRemove The Thread to be removed
	 * @return void
	 */
	public function removeThread(Tx_Dialog_Domain_Model_Thread $threadToRemove) {
		$this->threads->detach($threadToRemove);
	}

	/**
	 * Returns the threads
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Thread> $threads
	 */
	public function getThreads() {
		return $this->threads;
	}

	/**
	 * Sets the threads
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Thread> $threads
	 * @return void
	 */
	public function setThreads(Tx_Extbase_Persistence_ObjectStorage $threads) {
		$this->threads = $threads;
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
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Post> $posts
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Sets the posts
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Dialog_Domain_Model_Post> $posts
	 * @return void
	 */
	public function setPosts(Tx_Extbase_Persistence_ObjectStorage $posts) {
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

}
?>