<?php
/**
 * Created by JetBrains PhpStorm.
 * User: claus
 * Date: 3/17/12
 * Time: 6:46 PM
 * To change this template use File | Settings | File Templates.
 */
class Tx_Dialog_ViewHelpers_RenderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'div';

	/**
	 * @var array
	 */
	protected $trimTagNames = array('code', 'pre', 'quote', 'blockqoute', 'link', 'list');

	/**
	 * @param string $tagName
	 */
	public function render($tagName) {
		$content = $this->renderChildren();
		if (in_array($tagName, $this->trimTagNames)) {
			$content = trim($content);
		}
		switch ($tagName) {
			case 'pre':
				$content = nl2br($content);
				$content = str_replace("\n", '', $content);
				$content = str_replace("\r", '', $content);
				$content = preg_replace('/(<br>){1,}/', "\r\n", $content);
				break;
			case 'list':
				$tagName = 'ul';
				$content = '<li>' . str_replace("\n", '</li><li>', $content) . '</li>';
				break;
			case 'link':
				$this->tag->addAttribute('href', $content);
				$content = array_pop(explode('//', $content));
				$tagName = 'a';
				break;
			default:
		}
		$this->tag->setTagName($tagName);
		$this->tag->setContent($content);
		return $this->tag->render();
	}
	

}
