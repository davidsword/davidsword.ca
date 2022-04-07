# davidsword.ca

* Custom Theme
* Custom plugin

## Contributors ##

Prereq

```
$ brew install node
$ npm install -g grunt-cli
$ cd </this/project/dir/>
$ npm install
```

* `grunt less` compiles and minifies all `./dsca-theme/assets/src/css/*.less` into `./dsca-theme/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `./dsca-theme/assets/src/js/*.js` into `./dsca-theme/assets/js/dist/index.js`
* `grunt readme` converts WordPress.org readme.txt to .md for Github
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev
