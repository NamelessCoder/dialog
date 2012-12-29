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
 * Checks if A equals B
 *
 * @package Dialog
 * @subpackage ViewHelpers
 */
class Tx_Dialog_ViewHelpers_ShouldDisplayRepliesViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractConditionViewHelper {

	/**
	 * @param array $replies
	 * @param integer $offset
	 * @param integer $maximumOffset
	 * @param integer $minimumOffset
	 * @param boolean $hideChildren
	 * @return string
	 */
	public function render($replies, $offset, $maximumOffset = NULL, $minimumOffset = NULL, $hideChildren = FALSE) {
		if (!$replies) {
			$numReplies = 0;
		} else {
			$numReplies = $replies instanceof Countable || is_array($replies) ? count($replies) : $replies->count();
		}
		if ($numReplies < 1) {
			return $this->renderElseChild();
		}
		if ($hideChildren > 0) {
			return $this->renderElseChild();
		}
		if ($maximumOffset !== NULL) {
			if ($offset < $maximumOffset) {
				return $this->renderThenChild();
			}
		}
		if ($minimumOffset !== NULL) {
			if ($offset >= $minimumOffset) {
				return $this->renderThenChild();
			}
		}
		return $this->renderElseChild();
	}

}
