<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Discussion',
	'Dialog: Discussion/Comment'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Chat',
	'Dialog: Chat'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Dialog - Lightweight discussion module');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Styles', 'Dialog - Bootstrap CSS from NetDNA CDN');

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_addlist']['dialog_discussion'] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_addlist']['dialog_chat'] = 'pi_flexform';

Tx_Flux_Core::registerConfigurationProvider('Tx_Dialog_Provider_Configuration_DiscussionPluginConfigurationProvider');
Tx_Flux_Core::registerConfigurationProvider('Tx_Dialog_Provider_Configuration_ChatPluginConfigurationProvider');

t3lib_extMgm::addLLrefForTCAdescr('tx_dialog_domain_model_discussion', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_discussion.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_dialog_domain_model_discussion');
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Discussion.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_discussion.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_dialog_domain_model_thread', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_thread.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_dialog_domain_model_thread');
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Thread.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_thread.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_dialog_domain_model_post', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_post.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_dialog_domain_model_post');
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Post.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_post.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_dialog_domain_model_poster', 'EXT:dialog/Resources/Private/Language/locallang_csh_tx_dialog_domain_model_poster.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_dialog_domain_model_poster');
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Poster.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_dialog_domain_model_poster.gif'
	),
);
?>