# davidsword.ca

https://davidsword.ca/

## dsca-plugin

* Place mini plugins for auto load in `wp-content/plugins/dsca-plugins/inc/`
* To turn off, move to `wp-content/plugins/dsca-plugins/inc/_disabled/`

## dsca-theme

Dev:

```
$ brew install node
$ npm install -g grunt-cli
$ cd </this/project/dir/>
$ npm install
$ npm run watch
```

* `grunt less` compiles and minifies all `./dsca-theme/assets/src/css/*.less` into `./dsca-theme/assets/css/dist/style.css`
* `grunt uglify` compiles and minifies all `./dsca-theme/assets/src/js/*.js` into `./dsca-theme/assets/js/dist/index.js`
* `grunt watch` will watch for file changes in aforementioned files and do tasks automatically during dev

build:

```
$ npm run build
```

## Local Docker Setup

http://local.davidsword.ca/

- dev: `docker-compose up -d`
- database: `bash dsca-convert-db-to-localhost.sh <.sql from prod>`
- deploy: push to `github.com/davidsword/davidsword.ca#main`
