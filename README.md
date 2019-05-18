# Entrenador Dvorak
## Projecte Final de Cicle - ASIX
### Autor: Andreu Bió


### Install: add notes a Doc.md:

#### Agregar modul rewrite al apache de Docker
RUN a2enmod rewrite

#### Apache:
  ServerName dev.edv.net

#### /etc/hosts
127.0.0.1	localhost
127.0.0.1	dev.edv.net ca.dev.edv.net es.dev.edv.net en.dev.edv.net

#### PagesController
ariany@GLaDOS:~/PFC/edv$ php artisan make:controller PagesController
Controller created successfully.

#### Node.js (per compilar scss de Laravel)
curl -sL https://deb.nodesource.com/setup_12.x | bash -
apt-get install -y nodejs
```console
ariany@GLaDOS:~/PFC/edv$ npm install
```
després:
npm run dev     #per compilar
npm run watch   #per que s'autocompili quan fem modificacións

// webpack.mix.js -- Evitar error de mapeig de font després de: npm run dev / watch
```js
if (!mix.inProduction()) {
  mix.webpackConfig({
      devtool: 'source-map'
  })
  .sourceMaps()
}
```

#### LanguageMiddleware
```ShellSession
ariany@GLaDOS:~/PFC/edv$ php artisan make:middleware LangMiddleware
Middleware created successfully.
```
Agregar això al kernell
```php
  \App\Http\Middleware\LangMiddleware::class
```
y el contingut



ToDo - List
---
- [ ] Documentació a .md
  - [ ] Install notes
- [x] Docker - Producció
  - [x] edv-database
  - [x] edv-web
    - [x] extenció: mysqli

- [x] Git

- [x] Preparar base de dades
  - [x] Esquema E/R
    - [x] Esquema bàsic
    - [x] Atributs
  - [x] Normalització
  - [x] Taules SQL

- [ ] Sistema de Login
  - [ ] Login/Logout
  - [ ] Dashboard - Basic info
  - [ ] Modificar Model DB
  - [ ] Signin
  - [ ] Incloure Login al Navbar
  - [ ] Tunejar presentació

- [ ] Modul Skill 
  - [ ] Model DB
  - [ ] Pagina principal:
    - [ ] Test
    - [ ] Entrenament
      - [ ] Síl·labes
      - [ ] Paraules
      - [ ] Text
  - [ ] Obtenció dades config
  - [ ] Formulari config
  - [ ] Captació dades dels tests
  - [ ] Obtenció dades anònimes
  
- [ ]: Pendent (n:prioritat)
- [0]: Realitzat
- [x]: Realitzat i documentat
