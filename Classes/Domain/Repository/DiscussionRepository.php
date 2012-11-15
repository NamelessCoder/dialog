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
class Tx_Dialog_Domain_Repository_DiscussionRepository extends Tx_Dialog_Persistence_Repository {


	/**
	 * @param string $hash
	 * @param boolean $autoAddIfMissing
	 * @return Tx_Dialog_Domain_Model_Discussion|NULL
	 */
	public function getOrCreateByHash($hash, $autoAddIfMissing) {
		/** @var $discussion Tx_Dialog_Domain_Model_Discussion */
		$discussion = $this->findOneByHash($hash);
		if (!$discussion) {
			$discussion = $this->objectManager->create('Tx_Dialog_Domain_Model_Discussion');
			$discussion->setHash($hash);
			if ($autoAddIfMissing) {
				$this->add($discussion);
			}
		}
		return $discussion;
	}

}