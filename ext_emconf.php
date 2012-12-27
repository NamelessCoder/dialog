<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dialog".
 *
 * Auto generated 18-11-2012 19:14
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Dialog - Lightweight discussion module',
	'description' => 'Fluid AJAX Widget discussion component which can be used from any Fluid template or as a content element. Features automatic setup. Configurable threaded, flat or chat mode.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.2.0',
	'dependencies' => 'cms,extbase,fluid,flux,vhs',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
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
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
			'flux' => '',
			'vhs' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'notify' => '',
		),
	),
	'_md5_values_when_last_written' => 'a:89:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"e0b6";s:14:"ext_tables.php";s:4:"b919";s:14:"ext_tables.sql";s:4:"6549";s:21:"ExtensionBuilder.json";s:4:"5c0c";s:9:"README.md";s:4:"c541";s:37:"Classes/Controller/ChatController.php";s:4:"c5b0";s:43:"Classes/Controller/DiscussionController.php";s:4:"8491";s:35:"Classes/Domain/Model/Discussion.php";s:4:"6006";s:29:"Classes/Domain/Model/Post.php";s:4:"fde7";s:31:"Classes/Domain/Model/Poster.php";s:4:"4d0d";s:31:"Classes/Domain/Model/Thread.php";s:4:"06e2";s:50:"Classes/Domain/Repository/DiscussionRepository.php";s:4:"390d";s:46:"Classes/Domain/Repository/PosterRepository.php";s:4:"d16f";s:44:"Classes/Domain/Repository/PostRepository.php";s:4:"04fb";s:46:"Classes/Domain/Repository/ThreadRepository.php";s:4:"768a";s:43:"Classes/MVC/Controller/ActionController.php";s:4:"cb0e";s:34:"Classes/Persistence/Repository.php";s:4:"6cdd";s:66:"Classes/Provider/Configuration/ChatPluginConfigurationProvider.php";s:4:"c1e9";s:72:"Classes/Provider/Configuration/DiscussionPluginConfigurationProvider.php";s:4:"5b4d";s:40:"Classes/ViewHelpers/EqualsViewHelper.php";s:4:"7a83";s:43:"Classes/ViewHelpers/IncrementViewHelper.php";s:4:"0fc3";s:41:"Classes/ViewHelpers/RelatedViewHelper.php";s:4:"c744";s:40:"Classes/ViewHelpers/RenderViewHelper.php";s:4:"2add";s:42:"Classes/ViewHelpers/SubtractViewHelper.php";s:4:"63fa";s:48:"Classes/ViewHelpers/ThreadPostLinkViewHelper.php";s:4:"7ae4";s:52:"Classes/ViewHelpers/Format/PostContentViewHelper.php";s:4:"1782";s:61:"Classes/ViewHelpers/Widget/AbstractJQueryWidgetViewHelper.php";s:4:"ceb4";s:45:"Classes/ViewHelpers/Widget/ChatViewHelper.php";s:4:"5330";s:48:"Classes/ViewHelpers/Widget/CommentViewHelper.php";s:4:"5840";s:51:"Classes/ViewHelpers/Widget/DiscussionViewHelper.php";s:4:"efa7";s:56:"Classes/ViewHelpers/Widget/Controller/ChatController.php";s:4:"1e5b";s:59:"Classes/ViewHelpers/Widget/Controller/CommentController.php";s:4:"eb3d";s:62:"Classes/ViewHelpers/Widget/Controller/DiscussionController.php";s:4:"e95f";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"c605";s:32:"Configuration/TCA/Discussion.php";s:4:"9f27";s:26:"Configuration/TCA/Post.php";s:4:"4e40";s:28:"Configuration/TCA/Poster.php";s:4:"2562";s:28:"Configuration/TCA/Thread.php";s:4:"a80b";s:38:"Configuration/TypoScript/constants.txt";s:4:"d8cc";s:34:"Configuration/TypoScript/setup.txt";s:4:"4c12";s:40:"Resources/Private/Language/locallang.xml";s:4:"1a60";s:78:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_discussion.xml";s:4:"5a7d";s:72:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_post.xml";s:4:"c1a2";s:74:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_thread.xml";s:4:"fadb";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"d878";s:35:"Resources/Private/Layouts/Chat.html";s:4:"54b6";s:38:"Resources/Private/Layouts/Comment.html";s:4:"95cb";s:38:"Resources/Private/Layouts/Default.html";s:4:"4f26";s:41:"Resources/Private/Layouts/Discussion.html";s:4:"03e1";s:36:"Resources/Private/Layouts/Email.html";s:4:"1299";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"f5bc";s:41:"Resources/Private/Partials/Resources.html";s:4:"dfd8";s:47:"Resources/Private/Partials/Chat/Components.html";s:4:"ce25";s:50:"Resources/Private/Partials/Comment/Components.html";s:4:"03ca";s:53:"Resources/Private/Partials/Discussion/Components.html";s:4:"747d";s:49:"Resources/Private/Partials/Discussion/Emails.html";s:4:"dfc7";s:43:"Resources/Private/Templates/Chat/Index.html";s:4:"081a";s:62:"Resources/Private/Templates/ViewHelpers/Widget/Chat/Index.html";s:4:"7186";s:64:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Form.html";s:4:"0b82";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Index.html";s:4:"111d";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Write.html";s:4:"0b82";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Index.html";s:4:"d4a3";s:69:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Report.html";s:4:"96f3";s:67:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Show.html";s:4:"96f3";s:70:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Threads.html";s:4:"03bf";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Write.html";s:4:"5f59";s:53:"Resources/Public/Icons/glyphicons-halflings-white.png";s:4:"1111";s:47:"Resources/Public/Icons/glyphicons-halflings.png";s:4:"531d";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:60:"Resources/Public/Icons/tx_dialog_domain_model_discussion.gif";s:4:"905a";s:54:"Resources/Public/Icons/tx_dialog_domain_model_post.gif";s:4:"1103";s:56:"Resources/Public/Icons/tx_dialog_domain_model_thread.gif";s:4:"1103";s:45:"Resources/Public/Javascripts/Bootstrap.min.js";s:4:"9d36";s:57:"Resources/Public/Javascripts/Plugins/bootstrap-popover.js";s:4:"c79d";s:57:"Resources/Public/Javascripts/Plugins/bootstrap-tooltip.js";s:4:"4110";s:44:"Resources/Public/Javascripts/Plugins/Chat.js";s:4:"f71b";s:47:"Resources/Public/Javascripts/Plugins/Comment.js";s:4:"490a";s:44:"Resources/Public/Javascripts/Plugins/Init.js";s:4:"06a6";s:42:"Resources/Public/Stylesheets/Bootstrap.css";s:4:"60fd";s:52:"Resources/Public/Stylesheets/BootstrapResponsive.css";s:4:"2f90";s:37:"Resources/Public/Stylesheets/Chat.css";s:4:"20c3";s:40:"Resources/Public/Stylesheets/Comment.css";s:4:"6167";s:39:"Resources/Public/Stylesheets/Common.css";s:4:"bd89";s:50:"Tests/Unit/Controller/DiscussionControllerTest.php";s:4:"b8c7";s:42:"Tests/Unit/Domain/Model/DiscussionTest.php";s:4:"0eca";s:36:"Tests/Unit/Domain/Model/PostTest.php";s:4:"cd9d";s:38:"Tests/Unit/Domain/Model/ThreadTest.php";s:4:"8289";s:14:"doc/manual.sxw";s:4:"8823";}',
	'suggests' => array(
	),
);

?>