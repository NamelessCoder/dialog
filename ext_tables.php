<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Discussion',
	'Dialog: Discussion/Comment'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Chat',
	'Dialog: Chat'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Dialog - Lightweight discussion module');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Styles', 'Dialog - Bootstrap CSS from NetDNA CDN');

$TCA['tt_content']['types']['list']['subtypes_addlist']['dialog_discussion'] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_addlist']['dialog_chat'] = 'pi_flexform';

\FluidTYPO3\Flux\Core::registerConfigurationProvider('Tx_Dialog_Provider_Configuration_DiscussionPluginConfigurationProvider');
\FluidTYPO3\Flux\Core::registerConfigurationProvider('Tx_Dialog_Provider_Configuration_ChatPluginConfigurationProvider');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dialog_domain_model_discussion', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_discussion.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dialog_domain_model_discussion');
$TCA['tx_dialog_domain_model_discussion'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion',
		'label' => 'title',
		'label_alt' => 'description',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Discussion.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_discussion.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dialog_domain_model_thread', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_thread.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dialog_domain_model_thread');
$TCA['tx_dialog_domain_model_thread'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_thread',
		'label' => 'subject',
		'label_alt' => 'content',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Thread.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_thread.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dialog_domain_model_post', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_post.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dialog_domain_model_post');
$TCA['tx_dialog_domain_model_post'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_post',
		'label' => 'subject',
		'label_alt' => 'content',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Post.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_post.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dialog_domain_model_poster', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_poster.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dialog_domain_model_poster');
$TCA['tx_dialog_domain_model_poster'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_poster',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Poster.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_poster.gif'
	),
);
?>