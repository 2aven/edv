# Entrenador Dvorak
## Projecte Final de Cicle - ASIX
### Autor: Andreu Bió


### Install: add notes a Doc.md:
```console
docker-compose up -d
Creating network "pfc_edv-net" with the default driver
Pulling edv-database (mariadb:latest)...
latest: Pulling from library/mariadb
6abc03819f3e: Pull complete
05731e63f211: Pull complete
0bd67c50d6be: Pull complete
ab62701212b1: Pull complete
b1f6f41348ef: Pull complete
3bdaf925d088: Pull complete
10ba8f10417b: Pull complete
3806bed5c691: Pull complete
24aae6d0fc18: Pull complete
9104943e23ec: Pull complete
ae510462589d: Pull complete
ec23646ae61e: Pull complete
3c301b916a4e: Pull complete
Digest: sha256:db6e7bda67ea88efb00ba4ad82cb72dfee8938935914ae0948f6af523d398ca2
Status: Downloaded newer image for mariadb:latest
Building edv-web
Step 1/2 : FROM php:apache
apache: Pulling from library/php
743f2d6c1f65: Pull complete
6307e89982cc: Pull complete
807218e72ce2: Downloading [==========================================>        ]  57.33MB/67.45MB
5108df1d03f8: Download complete
901e0b6a7fe5: Download complete
5ffe11e7ab2c: Waiting
da5f7a507956: Waiting
d1c77e0395e3: Waiting
178dc4dca86f: Waiting
0abb62fba325: Waiting
3d298b1f0f75: Waiting
693315514366: Waiting
91950b08acf3: Waiting
```
```console
Creating pfc_edv-database_1 ... done
Creating pfc_edv-web_1      ... done
```
```console
docker ps -a
CONTAINER ID        IMAGE               COMMAND                  CREATED              STATUS              PORTS                NAMES
6112434701ed        pfc_edv-web         "docker-php-entrypoi…"   About a minute ago   Up About a minute   0.0.0.0:80->80/tcp   pfc_edv-web_1
e34a5c43a202        mariadb:latest      "docker-entrypoint.s…"   About a minute ago   Up About a minute   3306/tcp             pfc_edv-database_1
```
#### DOCKER_STUFF
###### Incloure moduls mysql
RUN	docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
###### Agregar modul rewrite al apache de Docker
(ja ve activat per defecte) RUN a2enmod rewrite

###### Envfile
Al docker compose, substituir *enviroment* per:
```yml
    env_file:
      - edv.env
```
i crear un arxiu amb les variables d'entorn
```console
MYSQL_ROOT_PASSWORD=contrasenya_admin
MYSQL_DATABASE=nom_base_de_dades
MYSQL_USER=nom_usuari
MYSQL_PASSWORD=contrasenya_usuari
```

Comprovar que s'ha creat la DB:
```console
ariany@GLaDOS:~/PFC$ docker exec -it pfc_edv-database_1 mysql -u edv_web -p
Enter password: 
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 10
Server version: 10.3.15-MariaDB-1:10.3.15+maria~bionic mariadb.org binary distribution

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> show databases;
+--------------------+
| Database           |
+--------------------+
| edv                |
| information_schema |
+--------------------+
2 rows in set (0.001 sec)
```
###### Host del database desde la xarxa interna
establir nom del host al compose
```yml
    networks:
      edv-net:
        aliases:
          - edv-db
```
Això s'ha d'inclorue al .env del projecte a Laravel :
```env
...
  DB_CONNECTION=mysql
  DB_HOST=**edv-db**
  DB_PORT=3306
...
```

#### Apache:
  ServerName dev.edv.net

#### /etc/hosts
127.0.0.1	localhost
127.0.0.1	dev.edv.net ca.dev.edv.net es.dev.edv.net en.dev.edv.net

#### PagesController
ariany@GLaDOS:~/PFC/edv$ php artisan make:controller PagesController
Controller created successfully.

#### Node.js (per compilar scss de Laravel)
curl -sL https://deb.nodesource.com/setup_12.x | console -
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
 include ::  el contingut
```php
public function handle($request, Closure $next){
  // Obtain lang subdomain
  $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));
  $subdomain = $url_array[0];

  $languages = \Config::get('app.locales');
  if (array_key_exists($subdomain,\Config::get('app.locales')))
    \App::setLocale($subdomain);

  return $next($request);
}
```

 #### Skills Controller-Model
 ```console
ariany@GLaDOS:~/PFC/edv$ php artisan make:controller SkillsController --resource
Controller created successfully.
ariany@GLaDOS:~/PFC/edv$ php artisan make:model Skill -m
Model created successfully.
Created Migration: 2019_05_19_103625_create_skills_table
```
En lloc d'usar SQL, usam el migrador amb aquesta info a database/migrations/*timestamp*_create_skills_table
```php
  public function up()
  {
    Schema::create('skills', function (Blueprint $table) {
      $table->bigIncrements('skillId');
      $table->tinytext('nomsk');
      $table->tinytext('ruta');
      $table->tinytext('imatge');
      $table->timestamps();
    });
  }
```
EDIT: 
El nom, com és subseptible a traducció, anirà a la pàgina junt amb el resta de la informació; elements direccionals com *ruta* o *imatge* només necessiten un **slug**, i la construcció del mòdul ha de respectar els noms dels arxius amb aquest format.
```PHP
//      $table->string('name', 191);  // The index key prefix length limit is 767 bytes for InnoDB tables that use the REDUNDANT or COMPACT row format. Assuming a utf8mb4 character set and the maximum of 4 bytes for each character: 191 * 4 = 764 (works).
      $table->string('slug', 24)->unique();   // Used as a construction parameter for 'route' and 'image'
```
https://stackoverflow.com/questions/43832166/laravel-5-4-specified-key-was-too-long-why-the-number-191 


#### Migrate:: 
(REPETIBLE QUAN HI HAGI TOTES LES DB MONTADES)

```console
ariany@GLaDOS:~/PFC/edv$ php artisan migrate
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
Migrating: 2019_05_19_103625_create_skills_table
Migrated:  2019_05_19_103625_create_skills_table
```

```console
Comprovació:

MariaDB [(none)]> use edv
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
MariaDB [edv]> show tables;
+-----------------+
| Tables_in_edv   |
+-----------------+
| migrations      |
| password_resets |
| skills          |
| users           |
+-----------------+
4 rows in set (0.000 sec)

MariaDB [edv]> show columns from skills;
+------------+---------------------+------+-----+---------+----------------+
| Field      | Type                | Null | Key | Default | Extra          |
+------------+---------------------+------+-----+---------+----------------+
| skillId    | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name       | varchar(144)        | NO   |     | NULL    |                |
| slug       | varchar(24)         | NO   |     | NULL    |                |
| created_at | timestamp           | YES  |     | NULL    |                |
| updated_at | timestamp           | YES  |     | NULL    |                |
+------------+---------------------+------+-----+---------+----------------+
5 rows in set (0.001 sec)
```
#### Artisan-tinker
```console
ariany@GLaDOS:~/PFC/edv$ docker exec -it pfc_edv-web_1 console 
root@76b63666f7c5:/var/www/html# php artisan tinker
Psy Shell v0.9.9 (PHP 7.3.5 — cli) by Justin Hileman
>>> $skill = new App\Skill();
=> App\Skill {#2937}
>>> $skill->name='Entrenador Dvorak';
=> "Entrenador Dvorak"
>>> $skill->slug='edv';
=> "edv"
>>> $skill->save();
=> true
>>> 
```

#### Storage
El contingut es guarda a /storage/app/public, però necessita un enllaç simbòlic a /public. Això es pot crear amb l'ordre:
```console
$ php artisan storage:link
The [public/storage] directory has been linked.
```

#### USER

```console
php artisan make:auth

 The [layouts/app.blade.php] view already exists. Do you want to replace it? (yes/no) [no]:
 > yes

Authentication scaffolding generated successfully.
```
migrations:
```php 
            // ::: Privacy policy ? :::
            // $table->string('email')->unique();
```

#### Fonts paraules, explicació sigmas


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
  - [x] Login/Logout
    - [ ] Navbar: 'Toogle navigation' lang tag ?
  - [x] Signin
    - [x] Modificar Model DB - incloure username
    - [ ] Verificar unique username
  - [ ] Dashboard - Basic info
  - [x] Incloure Login al Navbar
  - [ ] Tunejar presentació

- [x] Skills
  - [x] Controlador
  - [x] Model DB
  - [x] Incorporar traducció

- [ ] Config :: Model-Controlador
  - [x] Model DB
  - [ ] Controlador: S'ha de filtrar per usuari (sessió)
  - [x] Obtenció dades config
  - [ ] Carregar Config a la sessió (Anonim té els valors per defecte a la DB)
  - [ ] Formulari config -> Modifica les dades a la sessió i, si té usuari, les guarda a la DB

- [ ] Skill EDV
  - [ ] Pagina principal edv:
    - [ ] Test
    - [ ] Entrenament
      - [ ] Síl·labes
      - [ ] Paraules
        - [ ] Obtenir llistat de paraules amb probabilitat ponderada
          - [x] en https://en.wiktionary.org/wiki/Wiktionary:Frequency_lists/PG/2006/04/1-10000
          - [x] es
          - [x] ca https://en.wiktionary.org/wiki/Wiktionary:Frequency_lists/Catalan
      - [ ] Text
  - [ ] Captació dades dels tests
  - [ ] Obtenció dades anònimes
  
- [ ]: Pendent (n:prioritat)
- [0]: Realitzat
- [x]: Realitzat i documentat
