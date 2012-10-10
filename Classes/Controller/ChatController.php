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
 * @package Dialog
 * @subpackage Controller
 */
class Tx_Dialog_Controller_ChatController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_Fed_Service_Json
	 */
	protected $jsonService;

	/**
	 * @param Tx_Fed_Service_Json $jsonService
	 */
	public function injectJsonService(Tx_Fed_Service_Json $jsonService) {
		$this->jsonService = $jsonService;
	}

	/**
	 * @return void
	 */
	public function initializeAction() {
		if (session_id() === '') {
			session_start();
		}
		if (isset($_SESSION['tx_dialog']['chat']) === FALSE) {
			$_SESSION['tx_dialog']['chat'] = array(
				'name' => 'Guest ' . rand(1, 4096)
			);
		}
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function setNameAction($name) {
		return $this->setName($name);
	}

	/**
	 * @return string
	 */
	public function indexAction() {
		$instanceIdentifier = 'dialogChat';
		$widgetType = 'dialogChat';
		$typeNum = 1326130203;
		$options = array(
			'urls' => array(
				'say' => $this->uriBuilder->setTargetPageType($typeNum)->setTargetPageUid()->uriFor('say'),
				'setName' => $this->uriBuilder->setTargetPageType($typeNum)->setTargetPageUid()->uriFor('setName'),
				'text' => '/typo3temp/tx_dialog_chat_' . $instanceIdentifier . '.txt'
			),
			'chatIdentity' => $instanceIdentifier,
			'name' => $this->getName()
		);
		$initScript = $this->initializeWidget($instanceIdentifier, $widgetType, $options, $instanceIdentifier);
		$this->view->assign('id', $instanceIdentifier);
		$this->view->assign('name', $this->getName());
		$this->view->assign('initScript', $initScript);
	}

	/**
	 * @param string $chatIdentity
	 * @param string $message
	 * @return integer
	 */
	public function sayAction($chatIdentity, $message) {
		$chatFile = PATH_site . 'typo3temp/tx_dialog_chat_' . $chatIdentity . '.txt';
		$timeCode = date('H:i');
		$message = utf8_decode($message);
		$message = strip_tags($message);
		if (trim($message) === '') {
			return file_exists($chatFile) ? file_get_contents($chatFile) : '';
		}
		$message = htmlentities($message);
		if (file_exists($chatFile) === FALSE) {
			$chat = array();
		} else {
			$fileContents = trim(file_get_contents($chatFile));
			$chat = (array) $this->jsonService->decode($fileContents);
			if (count($chat) > 200) {
				$chat = array_slice($chat, 200 - count($chat));
			}

		}
		array_push($chat, array(
			'time' => $timeCode,
			'name' => $this->getName(),
			'message' => $message
		));
		$contents = $this->jsonService->encode($chat);
		file_put_contents($chatFile, $contents);
		return $contents;
	}

	/**
	 * @param string $name
	 */
	protected function setName($name) {
		$name = strip_tags($name);
		$name = htmlentities($name);
		$chatNamesFile = PATH_site . 'typo3temp/tx_dialog_chatnames.txt';
		if (file_exists($chatNamesFile) === FALSE) {
			file_put_contents($chatNamesFile, $name);
		} else {
			$chatNames = explode(";", trim(file_get_contents($chatNamesFile)));
			if (in_array($name, $chatNames)) {
				return 'ERROR:NAME_TAKEN';
			} else {
				array_push($chatNames, $name);
				file_put_contents($chatNamesFile, implode(';', $chatNames));
			}
		}
		$_SESSION['tx_dialog']['chat']['tx_dialog_name'] = $name;
		return $name;
	}

	/**
	 * @param string $name
	 */
	protected function getName() {
		if (isset($_SESSION['tx_dialog']['chat']['tx_dialog_name']) === FALSE) {
			$_SESSION['tx_dialog']['chat']['tx_dialog_name'] = $this->setName('Guest ' . rand(1, 4096));
		}
		return $_SESSION['tx_dialog']['chat']['tx_dialog_name'];
	}

	/**
	 * Initializes a jQuery-based Widget using options and giving in an instance name in JS
	 *
	 * @param type $domElementId The DOM element ID which should contain the Widget (and possibly the template contents used by the Widget)
	 * @param type $widgetType The name of the function on jQuery.fn which is used to initialize the Widget (for example: "autocomplete" for jQuery('someelement').autocomplete() widget)
	 * @param type $widgetOptions An array of options used to initialize the jQuery Widget
	 * @param type $instanceName If you do not care about the instance variable name used in JS you can leave this out
	 */
	protected function initializeWidget($domElementId, $widgetType, $widgetOptions, $instanceName=NULL) {
		if (!is_array($widgetOptions) || count($widgetOptions) == 0) {
				// this ensures correct encoding of options
			$widgetOptions = array('defaults' => 'none');
		}
		if ($instanceName === NULL) {
			$instanceName = uniqid('jQueryWidget');
		}
		$widgetOptionsJson = json_encode($widgetOptions);
		$initScript = "jQuery(document).ready(function() { initializeJQueryWidget('" . $domElementId . "', '" . $widgetType . "', " . $widgetOptionsJson . ", '" . $instanceName . "'); });";
		return $initScript;
	}

}
?>