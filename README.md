# davidsword.ca

My custom WordPress theme and plugin for https://davidsword.ca/

```
$ brew install node
$ npm install -g grunt-cli
$ cd </this/project/dir/>
$ npm install
```

* `grunt less` compiles and minifies all `./dsca-theme/assets/src/css/*.less` into `./dsca-theme/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `./dsca-theme/assets/src/js/*.js` into `./dsca-theme/assets/js/dist/index.js`
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev
