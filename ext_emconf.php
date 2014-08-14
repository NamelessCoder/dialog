<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dialog".
 *
 * Auto generated 09-01-2013 01:27
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Dialog: Lightweight discussion module',
	'description' => 'Fluid Widget discussion components which can be used from any Fluid template or as a content elements. Features automatic setup. Configurable threaded or flat (comments style) displays.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '2.2.0',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_dialog',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Claus Due',
	'author_email' => 'claus@wildside.dk',
	'author_company' => 'Wildside A/S',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '6.1.0-6.3.99',
			'extbase' => '',
			'fluid' => '',
			'flux' => '7.0.0-',
			'notify' => '',
			'vhs' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>