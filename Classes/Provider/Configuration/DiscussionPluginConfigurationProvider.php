<?php

/* * *************************************************************
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
 * ************************************************************* */

/**
 * @package Dialog
 * @subpackage Provider/Configuration
 */
class Tx_Dialog_Provider_Configuration_DiscussionPluginConfigurationProvider
	extends Tx_Flux_Provider_AbstractPluginConfigurationProvider
	implements Tx_Flux_Provider_PluginConfigurationProviderInterface {

	/**
	 * NOTE: Still must be an empty string due to bug in TYPO3 core's hook call
	 * @var string
	 */
	protected $fieldName = 'pi_flexform';

	/**
	 * @var string
	 */
	protected $extensionKey = 'dialog';

	/**
	 * @var string
	 */
	protected $listType = 'dialog_discussion';

	/**
	 * @var string
	 */
	protected $configurationSectionName = 'Configuration';

	/**
	 * @var integer
	 */
	protected $priority = 0;

	/**
	 * @var array
	 */
	protected $templateVariables = array(
		'tableName' => 'tx_dialog_domain_model_discussion'
	);

	/**
	 * @var array
	 */
	protected $templatePaths = array(
		'layoutRootPath' => 'EXT:dialog/Resources/Private/Layouts/',
		'templateRootPath' => 'EXT:dialog/Resources/Private/Templates/ViewHelpers/Widget/',
		'partialRootPath' => 'EXT:dialog/Resources/Private/Partials/',
	);

	/**
	 * @var string
	 */
	protected $templatePathAndFilename = 'EXT:dialog/Resources/Private/Templates/ViewHelpers/Widget/Discussion/Index.html';

}

?>