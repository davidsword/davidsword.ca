# davidsword.ca

Decoupled, but legacy theme still in repo in case I bail on Frontity.

## Front End

http://localhost:3000

* bootstrapped with [Frontity](https://frontity.org/)
* dev: `npx frontity dev` 👉 http://localhost:3000
* build:  `npx frontity build` (see `/build` after)
* deploy: `npx frontity serve` or serverless upload `/static` & `server.js` to Vercel or Netlify ([how to deploy](https://docs.frontity.org/deployment))
* more Frontity help: 
    - **[Learn Frontity](https://frontity.org/learn/)**
    - **[Community forum](https://community.frontity.org/)**

## Backend

http://local.davidsword.ca/

- dev: `docker-compose up -d`
- database: `bash dsca-convert-db-to-localhost.sh <.sql from prod>`
- deploy: push to `github.com/davidsword/davidsword.ca#main`

---

## Legacy theme (deprecated)

If using PHP dsca-theme instead of Fronity:

dev:

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