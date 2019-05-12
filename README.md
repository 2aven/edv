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

#### Node.js (per compilar scss de Laravel)
curl -sL https://deb.nodesource.com/setup_12.x | bash -
apt-get install -y nodejs
```console
ariany@GLaDOS:~/PFC/edv$ npm install
```
després:
npm run dev     #per compilar
npm run watch   #per que s'autocompili quan fem modificacións

#### LanguageMiddleware
```ShellSession
ariany@GLaDOS:~/PFC/edv$ php artisan make:middleware LangMiddleware
Middleware created successfully.
```
+ Content

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

- [ ] Web - estructura
  - [ ] HTML / CSS
    - [ ] Disseny principal
      - [ ] index
        - [ ] Header amb login
        - [ ] llistar skills
      - [ ] formularis Sessió:
        - [ ] sign-in
        - [ ] login/logout
      - [ ] pàgina usuari
    - [ ] Mòdul EDV
  - [ ] Laravel:  
    - [ ] Model - base de dades
    - [ ] Sessió
      - [ ] login / logout
      - [ ] creació usuari
      - [ ] configuració dades
    - [ ] Skills
      - [ ] obtenció dades
      - [ ] configuració
      - [ ] introducció dades
      
- [ ] Modul skill eDv
  - [ ] HTML / CSS - Entorn Skill
  - [ ] JS - Comportament Skill
    - [ ] Entrenador
      - [ ] Síl·labes
      - [ ] Paraules
      - [ ] Text
    - [ ] Examinador
      - [ ] TEST
      - [ ] Generar dades

- [n]: Pendent (n:prioritat)
- [-]: Realitzat
- [x]: Realitzat i documentat
