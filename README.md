# Sword Base ⚔️🏔
Another Wordpress starter theme

It's not as broad and robust as underscores, & it's not more intelligent or modern than Sage - however, it's a solid starter theme thats custom tailored for the type, style, and quality of custom themes I build.


## Description

This is a blank-canvas Wordpress starter theme (not a framework, not a parent - a starter theme) that focus's heavily on optimized code for marketing, includes third party protocols to meet todays interconnected-requirements. This theme is my starting point for my custom websites.

The goal and mission of this theme is to:

* Be ready out-of-the-gate, with a modern responsive vanilla layout that's easy to change
* Save time by having always-used features like responsive navigation and multi-media hero's pre-coded
* Include lots of resources that help create the theme without needing a lot of small third party plugins
* Code clean and efficient for high [Google Page Speed Insights](https://developers.google.com/speed/pagespeed/insights/) and [GTmetrix/YSlow](https://gtmetrix.com) scores
* Be prepared for Gutenberg and DIVI Page Builder
* Strong presence of third party protocols


## Features

**Standard**

* **Pre-Formatted HTML5 layout** and support, blank-canvas site with basic setup
* **Default Wordpress Theme Files** 404, search, page, index and more
* **Pure-CSS horizontal-to-Hamburger Navigation** prebuilt
* **Logo HiDPI support** in code, change images and resolutions

**Main**

* **LESSCSS** change main colours and width css variables to quickly refine
* **jQuery plugins** single line config includes
* **Feature Image** become Parallax hero images on pages
* **Hero Videos** can use Youtube URL's as the hero instead
* **Post Format > Gallery** allows Media > Image Galleries to run with Lightbox out of the box
* **PDF, WORD, EXCEL and NEW TAB links** with auto gain SVG icons beside themselves for better UX
* **Share buttons** at the bottom of every page, SVG icons, includes counter
* **Customizer Contact Info** entered via Customizer, auto added to header, footer, and more. tie into schema.org/LocalBusiness vCard with admin user input values, metas for geo, open graph, twitter cards
* **CALL NOW** and **DIRECTIONS** buttons appear anchored at bottom on mobile

**Nerdier Stuff**

* **CSS presets** for nearly all elements of a webpage
* **SVG base64 encoded image library** right in .less file `(@TODO reference)`
* **4x native responsive intervals** `(@TODO list and refine)`

**Wordpress Stuff**

* **Six Shortcodes**
    1. `[box]`for alert box, use
    1. `[space] [clear]` shortcode for more
    1. `[phone]`
    1. `[todo]`
    1. `[iframe]`
    1. `[email]` for admin or `[email]user@domain[/email]` for JS encrypted emails
*Modifications to wp-admin**
* default remove admin user bar from both ends
* *Page > Excerpt* repositioned in backend, and appears between title and content for better pages on both ends
* Remove advanced admin menu items for users that'd never use them `(ID != 1)`
* Admin edit screen cleaned up: opacity on "screen options"/"help", remove tinymce character count and html display.
* Tinymce remove unneeded buttons and H4-6 tags
* Blank stylesheet for TinyMCE ready


## RECOMMENDED PLUGINS

All are optional and won't cause an error, and the list is setup in first few lines of functions.php, however the theme insists on them for enhancing and helping make the site reach the standards and goals set out:

 * [Sword-Toolkit](https://github.com/davidsword/sword-toolkit)
    * Removes Wordpress emojis support, w.org preloading, JSON support
    * Toggle Wordpress Features Blog, Search, comments, on/off config
    * Remove single attachment and author pages default
    * Clean wp_head front-end
    * remove wordpress comments rss feed
    * remove jQuery migrate
    * other wp_head default junk
    * _..much more_
 * [Gravity Forms](www.gravityforms.com)
 	* CSS and PHP setup for GF footer form
 	* JS ready to replace `label`'s of inputs to `placeholder`'s
 	* PHP setup to auto anchor user to location of form after submission
 * [DIVI Builder](https://www.elegantthemes.com/plugins/divi-builder/)
 * [Yoast SEO](https://en-ca.wordpress.org/plugins/wordpress-seo/)
 * [Monster Insights](https://en-ca.wordpress.org/plugins/google-analytics-for-wordpress/)
 * [Block Bad Queries](https://en-ca.wordpress.org/plugins/block-bad-queries/)
 * [Login Lockdown](https://en-ca.wordpress.org/plugins/login-lockdown/)
 * [Imsanity](https://en-ca.wordpress.org/plugins/imsanity/)
 * [AMP](https://en-ca.wordpress.org/plugins/amp/)

## Reference

### Most Helper Functions

| MAKE | Function | Description |
|---|---|---|
| | `swrdbs_make_scripts()` | for enqueue'ing scripts |
| | `swrdbs_make_card()` | schema.org tags in header of code / displays under site's H1 heading for print styles |
| | `swrdbs_make_hero()` | use 'Featured Image' (or youtube URL) to create page hero |
| | `swrdbs_make_content()` | tap into `the_content` |
| | `swrdbs_make_map()` | use contact info entered into the Customizer to dynamically create a Google Map embed |
| | `swrdbs_make_social()` | create social icons with entered-into-Customizer values |
| | `swrdbs_make_share()` | create social share buttons |
| | `swrdbs_make_bodyclass()` | modify the bodies class |
| | `swrdbs_parser()` | build curl header |
| **RETURN** | **Function** | **Description**  |
| | `swrdbs_return_a_image()` | returns an image no matter what you're on (looks for featured image, inline images, attached-to-page images, or favicon, anything it can find) |
| | `swrdbs_return_list_pages()` | list all wordpress pages in a <select> |
| | `swrdbs_return_list_images()` | list all uploaded images in a <select> |
| | `swrdbs_return_first_line()` | get the first line of a blurb |
| | `swrdbs_return_chopstring()` | chop out the middle of a string to become a selected length |
| | `swrdbs_return_clean_phonenumber()` | remove visual garbage from phone numbers |
| | `swrdbs_return_twitteruser_from_url()` | get the handle of a user via a full url |
| | `swrdbs_return_youtube_video_from_url()` | as it says |
| | `swrdbs_return_filemtime()` | return the file modified time of a relative dir file |
| | `swrdbs_return_email()` | get an email and encrypt it |
| | `swrdbs_return_jshidden_email()` | encrypt email |
| | `swrdbs_return_social_count()` | return social counts of current page (@TODO temperamental) |
| | `swrdbs_return_current_URL()` | as it says |
| **OTHER** |  **Function** | **Description**  |
| | `swrdbs_has_hero()` | see if page has a banner or not |
| | `swrdbs_has_hero_video()` | see if page has a youtube-video-background banner or not, returns video url if true |
| | `swrdbs_isPageSpeed()` | detect if client is page speed |

### Custom Hooks

| Action | Description |
|---|---|
| `body_open` | fires right after `body` tag |

### CSS SVG ICON FUNCTIONS

* `.icon_phone()`
* `.icon_compass()`
* `.icon_hamburger()`
* `.icon_hamburger_white()`
* `.icon_arrow_left()`
* `.icon_arrow_right()`
* `.icon_close()`
* `.icon_facebook()`
* `.icon_instagram()`
* `.icon_excel()`
* `.icon_pdf()`
* `.icon_word()`
* `.icon_newtab()`
* `.icon_google()`
* `.icon_linkedin()`
* `.icon_pinterest()`
* `.icon_twitter()`
* `.icon_youtube()`
* `.icon_mail()`
* `.icon_down_arrow()`
* `.icon_down_arrow_black()`
* `.menudown_black()`
* `.menudown_white()`
* `.icon_search()`
* `.icon_search_white()`

### JS Class Names

* `.parallax` adds parallax effect to elements background image
* `.middleme` center content vertically with jQuery

### Responsive Class Names

* `.phone_only` as it says

### Custom Classes

* `.big`, `.excerpt`
* `.small`, `.meta`
* `(@TODO more)`

### Responsive Default Sizes

* `min-width: 1440px` bigger than 1440
* `max-width: 960px`
* `max-width: 750px`


## Included Third Party Plugins

| FILE | Version | author/repo | License |
| ---------------------------------|-------|-----------------------------------------------|-----------|
| `jquery.aos.(js/css)` | 2.1.1 |  [michalsnik/aos](https://github.com/michalsnik/aos/) | The MIT License |
| `jquery.less.css.js` | 1.7.4 | [less/less.js](https://github.com/less/less.js) | Apache License 2.0 |
| `jquery.lightbox.(js/css)` | 2.9.0 | [lokesh/lightbox2](https://github.com/lokesh/lightbox2/) | The MIT License |
| `jquery.waypoints.js` | 4.0.1 | [imakewebthings/waypoints](https://github.com/imakewebthings/waypoints/) | The MIT License |
| `jquery.youtubebackground.js` | 1.0.5  | [rochestb/jQuery.YoutubeBackground](https://github.com/rochestb/jQuery.YoutubeBackground) | The MIT License |

---

## Road Map

See [`.todo`](https://github.com/davidsword/sword-base/blob/master/.todo) for list, or [Issues](https://github.com/davidsword/sword-base/issues).

### Project Ideas:

* Better demo site
* Improve documentation, inline and README
* full dependency on Gutenberg, instead of this half-in for DIVI Builder

---

*Whatever you build with this theme, keep the documentation about it in the Wordpress-compatible `readme.txt`, leaving this `README.MD` for the starter theme documentation.*
