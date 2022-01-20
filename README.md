# DavidSword.ca #
**Contributors:**      davidsword
**Donate link:**       https://davidsword.ca/🍺/
**Tags:**              theselfproclaimedbestthemeintheworld
**Requires at least:** 5.0
**Tested up to:**      5.8.2
**Stable tag:**        20220120
**Requires PHP:**      7.4
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
![Home Page](http://ps.w.org/davidsword.ca/assets/screenshot-1.png)


## Changelog ##

See [commit history](https://github.com/davidsword/davidsword.ca/commits/master)

## Usage ##

Prereq

```
$ brew install node
$ npm install -g grunt-cli
$ cd </this/project/dir/>
$ npm install
```

Dev

* `grunt less` compiles and minifies all `/assets/src/css/*.less` into `/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `/assets/src/js/*.js` into `/assets/js/dist/index.js`
* `grunt readme` converts WordPress.org readme.txt to .md for Github
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev
