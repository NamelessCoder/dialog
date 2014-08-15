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
 * Test case for class Tx_Dialog_Domain_Model_Post.
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
class Tx_Dialog_Domain_Model_PostTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var Tx_Dialog_Domain_Model_Post
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Dialog_Domain_Model_Post();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getContentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setContentForStringSetsContent() { 
		$this->fixture->setContent('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getContent()
		);
	}
	
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
	public function getRepliesReturnsInitialValueForObjectStorageContainingTx_Dialog_Domain_Model_Post() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getReplies()
		);
	}

	/**
	 * @test
	 */
	public function setRepliesForObjectStorageContainingTx_Dialog_Domain_Model_PostSetsReplies() { 
		$reply = new Tx_Dialog_Domain_Model_Post();
		$objectStorageHoldingExactlyOneReplies = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneReplies->attach($reply);
		$this->fixture->setReplies($objectStorageHoldingExactlyOneReplies);

		$this->assertSame(
			$objectStorageHoldingExactlyOneReplies,
			$this->fixture->getReplies()
		);
	}
	
	/**
	 * @test
	 */
	public function addReplyToObjectStorageHoldingReplies() {
		$reply = new Tx_Dialog_Domain_Model_Post();
		$objectStorageHoldingExactlyOneReply = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneReply->attach($reply);
		$this->fixture->addReply($reply);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneReply,
			$this->fixture->getReplies()
		);
	}

	/**
	 * @test
	 */
	public function removeReplyFromObjectStorageHoldingReplies() {
		$reply = new Tx_Dialog_Domain_Model_Post();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$localObjectStorage->attach($reply);
		$localObjectStorage->detach($reply);
		$this->fixture->addReply($reply);
		$this->fixture->removeReply($reply);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getReplies()
		);
	}
	
}
?>