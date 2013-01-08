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
 * Renders the THEN-child if Post date lies after last visit
 * date, stores checked Posts so that the next time the VH
 * is used, it will always render the ELSE-child (because
 * Post is no longer new in the eyes of the VH).
 *
 * @package Dialog
 * @subpackage ViewHelpers
 */
class Tx_Dialog_ViewHelpers_IsNewViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper {

	/**
	 * Checks a Post, Thread or Discussion for recency - which that
	 * priority order if multiple objects are given.
	 *
	 * @param Tx_Dialog_Domain_Model_Post $post Optional Post to check against
	 * @param Tx_Dialog_Domain_Model_Thread $thread Optional Thread to check against
	 * @param Tx_Dialog_Domain_Model_Discussion $discussion Optional Discussion to check against
	 * @return string
	 */
	public function render(Tx_Dialog_Domain_Model_Post $post = NULL, Tx_Dialog_Domain_Model_Thread $thread = NULL, Tx_Dialog_Domain_Model_Discussion $discussion = NULL) {
		if (!$post && !$thread && !$discussion) {
			throw new Exception('The "isNew" ViewHelper requires at least one of post, thread or discussion arguments present. None were found.', 1356715073);
		}
		$key = 'tx_dialog_discussion_recency';
		$storage = isset($_SESSION[$key]) ? $_SESSION[$key] : array('timestamp' => time(), 'posts' => array());
		$isContainedInStorage = FALSE;
		$dateTime = NULL;
		if ($post) {
			$dateTime = $post->getCrdate();
			$postUid = $post->getUid();
			$isContainedInStorage = in_array($postUid, $storage['posts']);
			if (!$isContainedInStorage) {
				if (!isset($_SESSION[$key]['posts'])) {
					$_SESSION[$key]['posts'] = array();
				}
				array_push($_SESSION[$key]['posts'], $postUid);
			}
		} elseif ($thread) {
			$dateTime = $thread->getLastActivity();
		} elseif ($discussion) {
			$dateTime = $discussion->getLastActivity();
		}
		if ($dateTime) {
			$timestamp = $dateTime->getTimestamp();
		} else {
				// note: this case causes no Post, Thread or Discusssion to be marked as "new"
				// because it was impossible to retrieve a proper DateTime indicating last change.
			$timestamp = 0;
		}
		$isMoreRecentThanLastVisit = ($timestamp > $storage['timestamp']);
		if (!$isContainedInStorage && $isMoreRecentThanLastVisit) {
			return $this->renderThenChild();
		}
		return $this->renderElseChild();
	}

}
