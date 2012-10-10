<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
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
 * Subtracts $a from $b
 *
 * @package Dialog
 * @subpackage ViewHelpers/Widget
 */
class Tx_Dialog_ViewHelpers_RelatedViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var Tx_Dialog_Domain_Reposityr_PostRepository
	 */
	protected $postRepository;

	/**
	 * @param Tx_Dialog_Domain_Reposityr_PostRepository $postRepository
	 */
	public function injectPostRepository(Tx_Dialog_Domain_Repository_PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * @param string $hash
	 * @param Tx_Dialog_Domain_Model_Discussion
	 * @return Tx_Extbase_Persistence_QueryResult
	 */
	public function render($hash=NULL, Tx_Dialog_Domain_Model_Discussion $discussion=NULL) {
		if ($hash !== NULL) {
			return $this->postRepository->findByHash($hash);
		} else if ($discussion) {
			$threadHashes = array();
			foreach ($discussion->getThreads() as $thread) {
				array_push($threadHashes, $thread->getHash());
			}
			$query = $this->postRepository->createQuery();
			$query->matching($query->in('hash', $threadHashes));
			return $query->execute();
		}

	}

}
?>
