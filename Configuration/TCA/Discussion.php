<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_dialog_domain_model_discussion'] = array(
	'ctrl' => $TCA['tx_dialog_domain_model_discussion']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, poster, title, description, mode, last_activity, last_post, hash, threads, posts, crdate',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, poster, title, description, mode, last_activity, last_post, hash, threads, posts, crdate,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_dialog_domain_model_discussion',
				'foreign_table_where' => 'AND tx_dialog_domain_model_discussion.pid=###CURRENT_PID### AND tx_dialog_domain_model_discussion.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'crdate' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim,required'
			),
		),
		'mode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.mode',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'last_activity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.last_activity',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'last_post' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.last_post',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dialog_domain_model_post',
				'size' => 1
			),
		),
		'hash' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.hash',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'threads' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.threads',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dialog_domain_model_thread',
				'foreign_field' => 'discussion',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'posts' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.posts',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_dialog_domain_model_post',
				'foreign_field' => 'discussion',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'poster' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:dialog/Resources/Private/Language/locallang_db.xml:tx_dialog_domain_model_discussion.poster',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_dialog_domain_model_poster',
				'size' => 1
			),
		),
	),
);
?>