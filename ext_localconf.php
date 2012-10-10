<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Discussion',
	array(
		'Discussion' => 'index,write,report,post,show,edit,delete,forget,authorize',

	),
	array(
		'Discussion' => 'index,write,report,post,show,edit,delete,forget,authorize',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Chat',
	array(
		'Chat' => 'index,say,setName',

	),
	array(
		'Chat' => 'say,setName',
	)
);

t3lib_extMgm::addTypoScript($_EXTKEY, 'setup', "
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
			userFunc = tx_extbase_core_bootstrap->run
			extensionName = Dialog
			pluginName = Chat
		}
	}
");

?>