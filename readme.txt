===  Restrict Comments  ===
Contributors: WPTrat, Luis Rock
Tags: comment, comments
Requires at least: 5.0
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: 1.0.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

** Restrict Comments** is the best way to let each user see only their own comments (and correspondent replies) on selected (or all) post types.

== Description ==
 Restrict Comments is the best way to let each user see only their own comments (and correspondent replies) on selected (or all) post types.

Main features:

* choose (multiselect) to make plugin work on post, pages, custom post types
* except users from restriction by role


== Installation ==
1. Upload plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Visit settings through "Comments" -> "Restrict Comments" side menu link.

== Frequently Asked Questions ==
= How does this plugin do its magic? =

Restrict Comments makes use of the 'comments_clause' filter, provided by WordPress, in order to modify the query to select comments in the database, excluding the ones that do not meet the criteria. 

= Does this plugin insert or delete anything from the database? =

Not at all. It only filters the comments select query, based on options defined by the owner on the plugin's settings page. Your data is secure!

= Does this plugin work with any theme? =

That\'s the goal, but we cannot be sure. There are so many themes! If you have any troubles, please use the support forum.

= Have feedback or a feature request? =

* We are open to your suggestions and feedback. Thank you for using or trying out one of our plugins! Just drop us an email with your suggestion.

== Screenshots ==
1. Admin side view

== Changelog ==
= 1.0.0 = 
* Initial Release.