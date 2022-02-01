# DavidSword.ca

A clean and minimal website with focus on content.

## Contribution ##

Prereq

```
$ brew install node
$ npm install -g grunt-cli
$ cd </this/project/dir/>
$ npm install
```

* `grunt less` compiles and minifies all `/assets/src/css/*.less` into `/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `/assets/src/js/*.js` into `/assets/js/dist/index.js`
* `grunt readme` converts WordPress.org readme.txt to .md for Github
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev

## Notes ##

Used in conjunction with these plugins https://github.com/davidsword/davidsword.ca-custom-plugins
