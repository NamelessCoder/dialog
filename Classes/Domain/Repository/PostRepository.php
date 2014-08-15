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
class Tx_Dialog_Domain_Repository_PostRepository extends Tx_Dialog_Persistence_Repository {

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findAll() {
		$query = $this->createQuery();
		$query->matching($query->equals('published', 1));
		return $query->execute();
	}

	/**
	 * @param integer $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findLatest($limit) {
		$limit = intval($limit);
		if ($limit < 1) {
			$limit = 99999;
		}
		$query = $this->createQuery();
		$query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
		$query->setLimit($limit);
		$query->matching($query->equals('published', 1));
		return $query->execute();
	}

	/**
	 * @param Tx_Dialog_Domain_Model_Poster $poster
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByPosterAndUnpublished(Tx_Dialog_Domain_Model_Poster $poster) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				array(
					$query->equals('poster', $poster->getUid()),
					$query->equals('published', 0)
				)
			)
		);
		return $query->execute();
	}

}
?>