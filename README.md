# 🦊 DavidSword.ca #
**Contributors:**      davidsword  
**Donate link:**       https://davidsword.ca/🍺/  
**Tags:**              clean, minimal, davidsword  
**Requires at least:** 5.0  
**Tested up to:**      5.1.1  
**Stable tag:**        3.0.9  
**Requires PHP:**      7.2  
**License:**           GPLv2 or later  
**License URI:**       https://www.gnu.org/licenses/gpl-2.0.html  

A clean and minimal website with focus on content.

## Description ##

![](screenshot.png)

## Installation ##

1. Upload to themes dir
2. Enable via Appearance » Themes

## Frequently Asked Questions ##


## Screenshots ##

### 1. Home Page ###
![Home Page](http://ps.w.org/🦊-davidsword.ca/assets/screenshot-1.png)


## Changelog ##

See [commit history](https://github.com/davidsword/davidsword.ca/commits/master)

## Contributors ##

* `grunt less` compiles and minifies all `/assets/src/css/*.less` into `/assets/css/dist/style.css`
* `grunt readme` converts WordPress.org readme.txt to .md for Github
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev

## Pluggables ##

Contents of `/pluggables/` extend the functionality of WordPress, they're each technically plugins that could be fully developed one day. Until then, they're standalone and portable from theme-to-theme.

## Pseudo Post Formats ##

This theme does not use `post_formats` in the traditional sense. I found the added step of changing post formats easy-to-forget while creating content, and that my post formats were less about that flag and more about what type of content is in the post. There two conditions in which a `post` can have that will rendered in a slightly different post format. When a post has:

- **No Title** it assumes a "Status" pseudo post format. This makes it so the `<h1>` does not render, and the `wp_title` and `the_title` are filtered with the date.
- **No Content and a Featured Image** assumes a "Image" pseudo Post Format, these posts also do not have a title display on the site (as to not take away from the image, but it still does appear in `wp_title()`), and no content will display.

This is done to reduce steps while generating content, to minimize `if` statements throughout the template files, and to streamline the logic of the `partials/` folder.

The following helper functions are available:
* `dsca_get_pseduo_post_format()`
* `dsca_is_pseduo_post_format_image()`
* `dsca_is_pseduo_post_format_status()`

See [`/pluggable/pseduo-post-format.php`](pluggable/pseduo-post-format.php) for more info.
