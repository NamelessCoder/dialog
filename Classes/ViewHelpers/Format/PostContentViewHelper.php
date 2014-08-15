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
 * Formats a Post's content
 *
 * @package Dialog
 * @subpackage ViewHelpers/Format
 */
class Tx_Dialog_ViewHelpers_Format_PostContentViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Renders the content
	 */
	public function render() {
		$content = $this->renderChildren();
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'dialog', 'Discussion');
		$content = trim($content);
		$content = htmlentities($content, ENT_COMPAT, 'UTF-8', FALSE);
				// restore allowed tags and perform tag closing check. Self-closed tags are not treated/allowed
		$tags = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $settings['allowedHtmlTags']);
		foreach ($tags as $tag) {
			$closingTags = $openingTags = 0;
			$content = str_replace('&lt;' . $tag . '&gt;', '<dialog:render tagName="' . $tag . '">' , $content, $openingTags);
			$content = str_replace('&lt;/' . $tag . '&gt;', '</dialog:render>' , $content, $closingTags);
			if ($openingTags > $closingTags) {
				$content .= str_repeat('</dialog:render>' , $openingTags - $closingTags);
			} elseif ($closingTags > $openingTags) {
				$content = str_repeat('<dialog:render tagName="' . $tag . '">' , $closingTags - $openingTags) . $content;
			}
		}
		if ($settings['posting']['cleaning']['maximumConsequetiveLineBreaksAllowed'] > 0) {
			$maximumConsequetiveLineBreaksAllowed = $settings['posting']['cleaning']['maximumConsequetiveLineBreaksAllowed'];
		} else {
			$maximumConsequetiveLineBreaksAllowed = 3;
		}
		$content = preg_replace('/(\\r{0,}\\n){' . strval($maximumConsequetiveLineBreaksAllowed) . ',}/', str_repeat("\r\n", $maximumConsequetiveLineBreaksAllowed), $content);
		$content = preg_replace('/(\\r{0,}\\n){' . strval($maximumConsequetiveLineBreaksAllowed) . ',}\</', "\r\n" . '<', $content);
		$content = str_replace('}', '&#125;', $content);
		$content = str_replace('{', '&#123;', $content);
		$content = $this->renderAsFluidTemplate($content);
		$content = nl2br($content);
		return $content;
	}

	/**
	 * @param $content
	 */
	protected function renderAsFluidTemplate($content) {
		$content = '{namespace dialog=Tx_Dialog_ViewHelpers}' . LF . $content;
		$template = $this->objectManager->get('TYPO3\CMS\Fluid\View\StandaloneView');
		$template->setTemplateSource($content);
		return $template->render();
	}

}
