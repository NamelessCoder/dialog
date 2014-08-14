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
 * Test case for class Tx_Dialog_Domain_Model_Discussion.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Dialog - Lightweight discussion module
 *
 * @author Claus Due <claus@wildside.dk>
 */
class Tx_Dialog_Domain_Model_DiscussionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var Tx_Dialog_Domain_Model_Discussion
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Dialog_Domain_Model_Discussion();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getModeReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getMode()
		);
	}

	/**
	 * @test
	 */
	public function setModeForIntegerSetsMode() { 
		$this->fixture->setMode(12);

		$this->assertSame(
			12,
			$this->fixture->getMode()
		);
	}
	
	/**
	 * @test
	 */
	public function getLastActivityReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setLastActivityForDateTimeSetsLastActivity() { }
	
	/**
	 * @test
	 */
	public function getHashReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setHashForStringSetsHash() { 
		$this->fixture->setHash('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getHash()
		);
	}
	
	/**
	 * @test
	 */
	public function getThreadsReturnsInitialValueForObjectStorageContainingTx_Dialog_Domain_Model_Thread() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getThreads()
		);
	}

	/**
	 * @test
	 */
	public function setThreadsForObjectStorageContainingTx_Dialog_Domain_Model_ThreadSetsThreads() { 
		$thread = new Tx_Dialog_Domain_Model_Thread();
		$objectStorageHoldingExactlyOneThreads = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneThreads->attach($thread);
		$this->fixture->setThreads($objectStorageHoldingExactlyOneThreads);

		$this->assertSame(
			$objectStorageHoldingExactlyOneThreads,
			$this->fixture->getThreads()
		);
	}
	
	/**
	 * @test
	 */
	public function addThreadToObjectStorageHoldingThreads() {
		$thread = new Tx_Dialog_Domain_Model_Thread();
		$objectStorageHoldingExactlyOneThread = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneThread->attach($thread);
		$this->fixture->addThread($thread);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneThread,
			$this->fixture->getThreads()
		);
	}

	/**
	 * @test
	 */
	public function removeThreadFromObjectStorageHoldingThreads() {
		$thread = new Tx_Dialog_Domain_Model_Thread();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($thread);
		$localObjectStorage->detach($thread);
		$this->fixture->addThread($thread);
		$this->fixture->removeThread($thread);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getThreads()
		);
	}
	
	/**
	 * @test
	 */
	public function getPostsReturnsInitialValueForObjectStorageContainingTx_Dialog_Domain_Model_Post() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPosts()
		);
	}

	/**
	 * @test
	 */
	public function setPostsForObjectStorageContainingTx_Dialog_Domain_Model_PostSetsPosts() { 
		$post = new Tx_Dialog_Domain_Model_Post();
		$objectStorageHoldingExactlyOnePosts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePosts->attach($post);
		$this->fixture->setPosts($objectStorageHoldingExactlyOnePosts);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePosts,
			$this->fixture->getPosts()
		);
	}
	
	/**
	 * @test
	 */
	public function addPostToObjectStorageHoldingPosts() {
		$post = new Tx_Dialog_Domain_Model_Post();
		$objectStorageHoldingExactlyOnePost = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePost->attach($post);
		$this->fixture->addPost($post);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePost,
			$this->fixture->getPosts()
		);
	}

	/**
	 * @test
	 */
	public function removePostFromObjectStorageHoldingPosts() {
		$post = new Tx_Dialog_Domain_Model_Post();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($post);
		$localObjectStorage->detach($post);
		$this->fixture->addPost($post);
		$this->fixture->removePost($post);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPosts()
		);
	}
	
}
?>