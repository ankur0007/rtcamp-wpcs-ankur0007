=== RTCamp Assignment ===
Contributors: the-ank
Donate link: https://profiles.wordpress.org/the-ank/
Tags: metabox, contributors, post meta, custom post type, REST API, AJAX
Requires at least: 5.0
Tested up to: 6.6.1
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

RTCamp Assignment is a WordPress plugin that provides a metabox called "Contributors" on the post editor screen. This plugin allows users to search for other users by their roles (Administrator, Editor, Author), select them as post contributors, and display them on the frontend below the post content.

== Description ==

RTCamp Assignment is designed to make it easy to manage and display contributors for posts. With a simple metabox in the post editor, users can search for other users by their roles (Administrator, Editor, Author) and add them as contributors to the post. The selected contributors are then displayed on the frontend below the post content.

### Key Features:
* Search for users by roles: Administrator, Editor, Author.
* Add and remove contributors directly from the post editor.
* Display selected contributors on the frontend below the post content using the `the_content` filter.
* AJAX-powered custom REST API endpoints for seamless user experience.

### How It Works:
1. **Search:** Use the "Contributors" metabox to search for users by their roles.
2. **Select:** Select users from the search results to add them as contributors.
3. **Display:** Contributors are saved in the post meta and displayed below the post content on the frontend.
4. **Manage:** Easily remove contributors by unchecking them in the metabox.

== Installation ==

1. Upload the `rtcamp-assignment` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. The "Contributors" metabox will appear on the post editor screen.

== Frequently Asked Questions ==

= Can I add contributors to any post type? =
Currently, the plugin is designed to work with the default 'post' post type.

= How are contributors displayed on the frontend? =
Contributors are displayed below the post content using the `the_content` filter. You can customize the display by modifying the template included in the plugin.

= How do I remove a contributor? =
Simply uncheck the contributor in the "Contributors" metabox and save the post.

== Screenshots ==

1. Metabox in the post editor showing search results and selected contributors.
2. Contributors displayed on the frontend below the post content.

== Changelog ==

= 1.0.0 =
* Initial release of RTCamp Assignment.

== Upgrade Notice ==

= 1.0.0 =
* First release, no upgrades available.

== License ==

This plugin is licensed under the GPLv2 or later. See the [LICENSE](http://www.gnu.org/licenses/gpl-2.0.html) file for more details.

