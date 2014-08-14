<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Discussion',
	array(
		'Discussion' => 'index,write,report,post,show,edit,delete,forget,authorize,edit',

	),
	array(
		'Discussion' => 'index,write,report,post,show,edit,delete,forget,authorize,edit',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Chat',
	array(
		'Chat' => 'index,say,setName',

	),
	array(
		'Chat' => 'say,setName',
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY, 'setup', "
	[GLOBAL]
	DialogChat = PAGE
	DialogChat {
		typeNum = 1326130203
		config {
			no_cache = 1
			disableAllHeaderCode = 1
		}
		headerData >
		1326130203 = USER_INT
		1326130203 {
			userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
			extensionName = Dialog
			pluginName = Chat
		}
	}
");

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Tx_Notify_Extraction']['tx_dialog_domain_model_thread'] = 'Tx_Dialog_Extraction_ThreadExtractor';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Tx_Notify_Extraction']['tx_dialog_domain_model_discussion'] = 'Tx_Dialog_Extraction_DiscussionExtractor';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Tx_Notify_Extraction']['tx_dialog_domain_model_post'] = 'Tx_Dialog_Extraction_PostExtractor';

?>