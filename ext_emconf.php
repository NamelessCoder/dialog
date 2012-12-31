<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "dialog".
 *
 * Auto generated 31-12-2012 02:40
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
	'version' => '2.0.0',
	'dependencies' => 'cms,extbase,fluid,flux,notify,vhs',
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
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
			'flux' => '',
			'notify' => '',
			'vhs' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:94:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"d783";s:14:"ext_tables.php";s:4:"f464";s:14:"ext_tables.sql";s:4:"35d0";s:9:"README.md";s:4:"c7eb";s:37:"Classes/Controller/ChatController.php";s:4:"fb29";s:43:"Classes/Controller/DiscussionController.php";s:4:"78f0";s:35:"Classes/Domain/Model/Discussion.php";s:4:"e2c0";s:29:"Classes/Domain/Model/Post.php";s:4:"50ad";s:31:"Classes/Domain/Model/Poster.php";s:4:"2342";s:31:"Classes/Domain/Model/Thread.php";s:4:"81c2";s:50:"Classes/Domain/Repository/DiscussionRepository.php";s:4:"390d";s:46:"Classes/Domain/Repository/PosterRepository.php";s:4:"d16f";s:44:"Classes/Domain/Repository/PostRepository.php";s:4:"04fb";s:46:"Classes/Domain/Repository/ThreadRepository.php";s:4:"06bf";s:40:"Classes/Extraction/AbstractExtractor.php";s:4:"76cf";s:42:"Classes/Extraction/DiscussionExtractor.php";s:4:"6139";s:36:"Classes/Extraction/PostExtractor.php";s:4:"4201";s:38:"Classes/Extraction/ThreadExtractor.php";s:4:"9059";s:43:"Classes/MVC/Controller/ActionController.php";s:4:"81c2";s:34:"Classes/Persistence/Repository.php";s:4:"6cdd";s:66:"Classes/Provider/Configuration/ChatPluginConfigurationProvider.php";s:4:"c1e9";s:72:"Classes/Provider/Configuration/DiscussionPluginConfigurationProvider.php";s:4:"5b4d";s:42:"Classes/ViewHelpers/EditableViewHelper.php";s:4:"244a";s:40:"Classes/ViewHelpers/EqualsViewHelper.php";s:4:"7a83";s:43:"Classes/ViewHelpers/IncrementViewHelper.php";s:4:"1168";s:39:"Classes/ViewHelpers/IsNewViewHelper.php";s:4:"11e3";s:41:"Classes/ViewHelpers/RelatedViewHelper.php";s:4:"c744";s:40:"Classes/ViewHelpers/RenderViewHelper.php";s:4:"2add";s:54:"Classes/ViewHelpers/ShouldDisplayRepliesViewHelper.php";s:4:"d210";s:42:"Classes/ViewHelpers/SubtractViewHelper.php";s:4:"63fa";s:48:"Classes/ViewHelpers/ThreadPostLinkViewHelper.php";s:4:"7ae4";s:52:"Classes/ViewHelpers/Format/PostContentViewHelper.php";s:4:"1782";s:61:"Classes/ViewHelpers/Widget/AbstractJQueryWidgetViewHelper.php";s:4:"ceb4";s:45:"Classes/ViewHelpers/Widget/ChatViewHelper.php";s:4:"5330";s:48:"Classes/ViewHelpers/Widget/CommentViewHelper.php";s:4:"5840";s:51:"Classes/ViewHelpers/Widget/DiscussionViewHelper.php";s:4:"baa7";s:56:"Classes/ViewHelpers/Widget/Controller/ChatController.php";s:4:"1e5b";s:59:"Classes/ViewHelpers/Widget/Controller/CommentController.php";s:4:"eb3d";s:62:"Classes/ViewHelpers/Widget/Controller/DiscussionController.php";s:4:"5c9c";s:32:"Configuration/TCA/Discussion.php";s:4:"078d";s:26:"Configuration/TCA/Post.php";s:4:"37d9";s:28:"Configuration/TCA/Poster.php";s:4:"2562";s:28:"Configuration/TCA/Thread.php";s:4:"6187";s:38:"Configuration/TypoScript/constants.txt";s:4:"d8cc";s:34:"Configuration/TypoScript/setup.txt";s:4:"2d7b";s:40:"Resources/Private/Language/locallang.xml";s:4:"2879";s:78:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_discussion.xml";s:4:"5a7d";s:72:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_post.xml";s:4:"c1a2";s:74:"Resources/Private/Language/locallang_csh_tx_dialog_domain_model_thread.xml";s:4:"fadb";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"385a";s:35:"Resources/Private/Layouts/Chat.html";s:4:"5601";s:38:"Resources/Private/Layouts/Comment.html";s:4:"02e5";s:38:"Resources/Private/Layouts/Default.html";s:4:"4f26";s:41:"Resources/Private/Layouts/Discussion.html";s:4:"8654";s:36:"Resources/Private/Layouts/Email.html";s:4:"1299";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"f5bc";s:47:"Resources/Private/Partials/Chat/Components.html";s:4:"2136";s:50:"Resources/Private/Partials/Comment/Components.html";s:4:"32c7";s:53:"Resources/Private/Partials/Discussion/Components.html";s:4:"34fa";s:49:"Resources/Private/Partials/Discussion/Emails.html";s:4:"b8a7";s:43:"Resources/Private/Templates/Chat/Index.html";s:4:"35ad";s:62:"Resources/Private/Templates/ViewHelpers/Widget/Chat/Index.html";s:4:"7554";s:64:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Form.html";s:4:"0b82";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Index.html";s:4:"135a";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Comment/Write.html";s:4:"0b82";s:67:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Edit.html";s:4:"5b99";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Index.html";s:4:"36fd";s:69:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Report.html";s:4:"f3b8";s:67:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Show.html";s:4:"f3b8";s:70:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Threads.html";s:4:"03bf";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Discussion/Write.html";s:4:"5ab6";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Paginate/Index.html";s:4:"b203";s:53:"Resources/Public/Icons/glyphicons-halflings-white.png";s:4:"1111";s:47:"Resources/Public/Icons/glyphicons-halflings.png";s:4:"531d";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:60:"Resources/Public/Icons/tx_dialog_domain_model_discussion.gif";s:4:"905a";s:54:"Resources/Public/Icons/tx_dialog_domain_model_post.gif";s:4:"1103";s:56:"Resources/Public/Icons/tx_dialog_domain_model_thread.gif";s:4:"1103";s:60:"Resources/Public/Javascripts/Plugins/bootstrap-fileupload.js";s:4:"9568";s:64:"Resources/Public/Javascripts/Plugins/bootstrap-fileupload.min.js";s:4:"09c8";s:44:"Resources/Public/Javascripts/Plugins/Chat.js";s:4:"f71b";s:47:"Resources/Public/Javascripts/Plugins/Comment.js";s:4:"490a";s:44:"Resources/Public/Javascripts/Plugins/Init.js";s:4:"c2f5";s:48:"Resources/Public/Javascripts/Plugins/Prettify.js";s:4:"ed7b";s:57:"Resources/Public/Stylesheets/bootstrap-fileupload.min.css";s:4:"8e11";s:37:"Resources/Public/Stylesheets/Chat.css";s:4:"20c3";s:40:"Resources/Public/Stylesheets/Comment.css";s:4:"6167";s:39:"Resources/Public/Stylesheets/Common.css";s:4:"3e04";s:46:"Resources/Public/Stylesheets/PrettifyTheme.css";s:4:"f784";s:50:"Tests/Unit/Controller/DiscussionControllerTest.php";s:4:"b8c7";s:42:"Tests/Unit/Domain/Model/DiscussionTest.php";s:4:"0eca";s:36:"Tests/Unit/Domain/Model/PostTest.php";s:4:"cd9d";s:38:"Tests/Unit/Domain/Model/ThreadTest.php";s:4:"8289";}',
	'suggests' => array(
	),
);

?>