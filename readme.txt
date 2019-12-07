=== 🦊 DavidSword.ca ===
Contributors:      davidsword
Donate link:       https://davidsword.ca/🍺/
Tags:              clean, minimal, davidsword
Requires at least: 5.0
Tested up to:      5.1.1
Stable tag:        3.1.4
Requires PHP:      7.2
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A clean and minimal website with focus on content.

== Description ==

![](screenshot.png)

== Installation ==

1. Upload to themes dir
2. Enable via Appearance » Themes

== Frequently Asked Questions ==


== Screenshots ==

1. Home Page

== Changelog ==

See [commit history](https://github.com/davidsword/davidsword.ca/commits/master)

== Contributors ==

* `grunt less` compiles and minifies all `/assets/src/css/*.less` into `/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `/assets/src/js/*.js` into `/assets/js/dist/index.js`
* `grunt readme` converts WordPress.org readme.txt to .md for Github
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev

== Pluggables ==

Contents of `/pluggables/` extend the functionality of WordPress, they're each technically plugins that could be fully developed one day. Until then, they're standalone and portable from theme-to-theme.

=== Pseudo Post Formats ===

Instead of assigning a post format, this theme looks at the content and determins the post format:

| Post Format | Condition |
| --- | --- |
| IMAGE | title and featured image, no content |
| STATUS | no title |
| (Default Post) | title, feature image, content, optional excerpt |

When no title is present, this theme will create a title of YYYYMMDD.

See [`/pluggable/auto-post-format.php`](pluggable/auto-post-format.php) for more info.
