TYPO3 Extension Dialog: Lightweight Discussion Components
=========================================================

## What is it?

`Dialog` is a collection of components whose only purpose is to facilitate discussions between users of your web site. There are
currently two types of plugins: a Chat and full Discussion (forum-style) plugin. And three Widget types: Chat, Discussion and
Comment - the first two of which are the Widget versions of the two main plugins and the last one, Comment, a specially
integrated version of the Discussion Widget which automatically creates Discussions and connects these to any type of content -
for example any record from your own extension or a content element.

`Dialog` integrates with `Notify` (see https://github.com/NamelessCoder/notify) to enable subscription to new records - new
Discussions, Threads or Posts. `Notify` includes a special Timeline View which is very useful as a "My watched threads" interface,
as well as the necessary logic to send digest-style emails based on Fluid templates.

`Dialog` features multiple formatting syntaxes for texts: the default "html" mode which uses lib.parseFuncHtml, "raw" which does
no escaping at all (of course only for trusted use!), "nl2br" which strips all HTML but turns line breaks into `<br>` or the more
advanced "markdown" mode - which uses the CLI utility [Markdown, a simple Perl script](http://daringfireball.net/projects/markdown/).

## What does it do?

`Dialog` provides plugins and Widgets which have extensive configuration options. Plugins are configured as content elements and
Widgets are provided as ViewHelper Widgets which can be used in any Fluid template. `Dialog` uses a very simple set of Models:
Discussion, Thread, Post and Poster. Each Discussion can have any number of Posts (for a flat structure like the Comment Widget)
or it can have any number of Threads attached to it. Threads are simple collections of either Threads or Posts and as such are a
lot like Discussions but are different and stored differently to clearly separate their purpose from that of Discussions. Posts
are of course the main "user contributed content"; the Model for each individual posted user comment but also used as sub-object
on Discussions and Threads to allow the Discussion/Thread creator to write a piece of text for that Discussion/Thread topic.
Lastly, the Poster is of course each person who has created a Post, Discussion or Thread - one Poster per identity. The Poster can
be automatically created based on a FrontendUser if one is logged in.

Discussion and Threads are simple containers used to represent and store the hierarchy. Posts are the individual objects used to
store text submitted by users either as replies to Discussions, Threads or other Posts - or as main topic text for Discussion and
Thread.

Discussions can be seen as master Threads; creation of Discussions can be prohibited but creation of Threads enabled, making it
possible for users to create new "subjects" (sub-topics of discussion under a main topic which is a Discussion) and for other
users to post individual replies to that sub-topic (the Thread). Finally it is possible to enable replies to each individual Post
to have a threaded forum structure.

The Comment Widget for example uses a main Discussion without topic text which is automatically created and attached to the
record/ID/whatever, then stores a flat list of Posts (without Threads, without option to reply to individual Posts) under that
Discussion.

And the Discussion plugin for example uses a main list of Discussions created by the site admin, then enables creation of Threds
under each Discussion, then enables a flat list of direct Post replies with the option to reply to each individual Post.

Any user-submitted text is processed the same regardless of the context in order to simplify usage and have a short learning curve.

## How does it do it?

`Dialog` is a fairly simple Extbase extension with just a few extended features, mainly the use of Flux to enable a highly
dynamic configuration for plugins using a FlexForm-style integration between Fluid and TYPO3. The Fluid templates are standardised
and follow the conventions - with one slightly off standard pragma: each component type stores almost all rendering related to
that component type in a Partial template. This is done in order to re-use this Partial template from both a TYPO3 content element
plugin and a Fluid Widget without splitting much of the structured template in two.

`Dialog` works in two ways: if a FrontendUser is not logged in but the page on which `Dialog` is inserted can be accessed, `Dialog`
works in "guest mode" which means public commenting is allowed - but requires authentication through an email that is sent by the
TYPO3 site when a guest submits a Post (or Thread, or Discussion). The authentication is stored in a session or a long term cookie.
If a FrontendUser is logged in then that user will be used as Poster identity.

## Examples

In general you will find every configuration option you need right in the plugin/Widget you are using. The components are designed
to be as flexible as possible, allowing you to enable or disable any option you desire in order to get just the behavior your want:
threaded/flat, comment-style, fixed topics and so on.

ViewHelpers are documented by their XSD schema which you can find at this URL: http://fedext.net/ns/dialog/ViewHelpers - use either
this URL as schemaLocation or download the XSD and create the necessary mapping in your IDE.

### Referencing the XSD schema

The full version relevant for templates that use a Layout and contain Sections.

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"
	  xmlns:dialog="http://fedext.net/ns/dialog/ViewHelpers">
<head>
	<title></title>
</head>
<body>

{namespace dialog=Tx_Dialog_ViewHelpers}

<!-- Fluid goes here -->

</body>
</html>
```

The short version better suited for Partials etc.

```xml
{namespace dialog=Tx_Dialog_ViewHelpers}
<div xmlns:dialog="http://fedext.net/ns/dialog/ViewHelpers">
<!-- Fluid goes here -->
</div>
```

### Comment Widget available only to desired FrontendUserGroup

```xml
<v:security.allow frontendUserGroup="{settings.myExtensionsAuthSettings.someGroupUid}">
    <dialog:widget.comment
        hash="Tx_MyExt_Domain_Model_MyObject:{object.uid}"
        presetSubject="Comment: {object.title}"
        customTitle="{f:translate(key: 'commentsFor', default: 'commentsFor')} {object.title}"
        placeholder="<i class='icon icon-comments'></i> {f:translate(key: 'commentsPlaceholder', default: 'commentsPlaceholder')} (%s)"
        />
</v:security.allow>
```

### Core settings

```
plugin.tx_dialog.settings {
	# format used for all dates
	dateFormat = Y-m-d H:i
	# a CSV list of HTML tags that are not removed from Post's text content
	allowedHtmlTags = pre,code,quote,blockquote,link,list,em,strong
	# hero unit: the jumbotron text box with topics' descriptions
	enableHeroUnit = 1
	# toolbar: a top navigation toolbar to move between sections
	enableToolbar = 1
	# direct commenting: place Post form inline in all appropriate views
	enableDirectCommenting = 1
	# if enabled, places a button that quickly sends a "user thinks content is inappropriate" email to sysadmin
	enableInappropriateContentReporting = 1
	# discussion creation: If enabled, allows users to create new Discussions (root-level object, should normally be controlled by site admin)
	enableDiscussionCreation = 0
	# prefix automatically added to Posts' subjects when Post is made as a reply as opposed to a new topic
	responsePrefix = Re:
	# the number of most recent Posts to display in the Discussion list
	numberOfLatestPosts = 5
	# maximum number of Posts to display per page - currently only applies to Post list
	itemsPerPage = 20
	# postTableClass: class name (Twitter Bootstrap table classes) of tables containing Posts.
	postTableClass = table-condensed table-striped
	# duration of the cookie that is sent when a guest user uses the "store in cookie" confirmation link from the confirmation email
	cookieLifetime = 8046000
	email {
		# The email address used to send emails
		fromEmail = sysop@mysite.com
		# The name used in emails sent by the system
		fromName = MySite Forums
	}
	markup {
        # options: default (html), markdown, raw, nl2br, template. Mode "markdown" requires CLI command "markdown" installed
        mode = default
        # if mode = template, a path to a Fluid (Partial) template which renders each Post text
        template =
    }
}
```

## Known problems and limitations

* The Post list under uses Fluid's Pagination Widget which means that the link to page is incorrect when standing on page one, on
  versions of TYPO3 below 6.0.
* `Dialog` overrides certain parts of a default Twitter Bootstrap theme - if you use a custom them, make sure you override these
  overrides, too.
* jQuery used but not force-included; may not work on older (below 1.6) versions of jQuery.

## Roadmap

* File uploads for Posts
* Editing of own Posts by authenticated users