

Entrenador Dvorak
===

## Projecte Final de Cicle - ASIX

### Andreu Bió Llabrés
---


# Introducció

## Idea principal:

Aplicació web plantejada per a l’aprenentatge o pràctica d’habilitats mentals i perceptives abordant diferents tècniques o metodologies, amb la finalitat d’obtenir dels usuaris una mostra estadísticament rellevant per poder realitzar un anàlisi fundat sobre quins mètodes (o combinació d’aquests) són més efectius, ràpids o eficients.

## Plantejament

La idea inicial és la d’una pàgina de mecanografia que proposi diferents mètodes d’aprenentatge:

* posició de lletres individuals
* dígrafs o grups sil·làbics
* paraules usuals
* text

L’objectiu final de la pàgina és poder analitzar la relació entre ús de mètodes i l’eficàcia de l'aprenentatge; per això es comunicarà els resultats dels usuaris amb una base de dades dissenyada per emmagatzemar detalls de les sessions com el temps dedicat, puntuacions de velocitat (polzades per minut), errors, nivells de dificultat (introducció de nombres, accents, caràcters especials...).

Aquesta informació es pot mostrar individualment a l’usuari per que conegui els seus avanços, però també contribueixen com banc de dades anònimes per extrapolar conclusions amb base empírica; per exemple, un resultat hipotètic podria ser: l’aprenentatge és més efectiu si es manté la pràctica de dígrafs i síl·labes durant les primeres tres setmanes.

El projecte es planteja de manera que pugui ser ampliable implementant mòduls addicionals per entrenar altres habilitats mentals o perceptives de les que se’n puguin medir, recollir y analitzar dades rellevants referents al procés d’aprenentatge humà, amb la finalitat d’obtenir dades empíriques que recolzin la millor metodología d’aprenentatge. 

Exemples poden ser càlcul aritmètic, memòria, educació musical (entonació, tonalitats,...), percepció numèrica (recompte aproximat de grans quantitats d’elements), percepció geomètrica, velocitat de reflexos, llenguatge o idiomes, etc…

# Preparació de l’entorn de desenvolupament

Es farà ús de dues tecnologies bàsiques durant el desenvolupament de l’aplicació, el sistema de control de versions, i l’encapsulament de serveis en contenidors: 

## Git

El sistema de control de versions, que permet administrar l’historial de diferents moments clau durant la producció del codi font de l’aplicació. Per iniciar el projecte es defineix la informació d’autor i s’executa el inicializador de GIT:

```shell
:$ git config --global user.name "Andreu Bió"
:$ git config --global user.email "abio@iesfbmoll.org"
:$ git init
Initialized empty Git repository in ~/PFC/.git/
```

Quan es fan canvis, aquests es van incorporant a l’arbre històric:

```shell
:$ git add docker-compose.yml
:$ git commit -m “missatge”
```

Per incorporar-ho al repositori de Github, es defineix la ruta d’origen, es fa una primera crida per obtenir els arxius del repositori creat a Github (README.md) amb l’opció que permet mesclar històrics no relacionats, i a partir d’aquí ja podem pujar cada estat de canvis:

```shell
$ git remote add origin https://github.com/2aven/edv.git
$ git remote -v
origin    https://github.com/2aven/edv.git (fetch)
origin    https://github.com/2aven/edv.git (push)

$ git pull origin master --allow-unrelated-histories
$ git push origin master
From https://github.com/2aven/edv
 * branch            master     -> FETCH_HEAD
Merge made by the 'recursive' strategy.
 README.md | 2 ++
 1 file changed, 2 insertions(+)
 create mode 100644 README.md

$ git push origin master
Username for 'https://github.com': 2aven
Password for 'https://2aven@github.com':
Counting objects: 5, done.
Delta compression using up to 4 threads.
Compressing objects: 100% (4/4), done.
Writing objects: 100% (5/5), 805 bytes | 0 bytes/s, done.
Total 5 (delta 0), reused 0 (delta 0)
To https://github.com/2aven/edv.git
   c1d2e2a..0a7e860  master -> master
```

## Docker: entorn de treball

Aquest projecte permet organitzar els diferents serveis implicats usant contenidors que virtualitzen els paquets de software a una capa d’aplicació del sistema, que permet l’aïllament de recursos però evitant la sobrecàrrega que suposa l’ús de màquines virtuals per cada un d’ells.


En un principi, es pretén arrancar almenys dos contenidors Docker: un d’ells amb la imatge de la darrera versió del servei d'aplicacions PHP amb el servei HTML d’**Apache**. Per això s’expliquen les passes per obtenir la configuració:

* Passa prèvia: utilizar el grup d’usuari docker
* Obtenció de la configuració inicial d’ **Apache**
* Separació d’arxius LOG
* Docker Compose
* Contenidors addicionals
* Avaluació

### Passa prèvia: utilizar el grup d’usuari docker

Docker necessita executar-se amb permisos d’administrador, pel que cada vegada que volem executar alguna ordre, s’ha de fer amb permisos sudo. Per evitar haver d’escriure sudo cada vegada, una opció és crear el grup de sistema docker i incloure l’usuari al grup:

```shell
:$ sudo groupadd docker
:$ sudo usermod -aG docker $USER
```

Després de reiniciar la sessió per refrescar la taula de permisos del sistema, es poden executar les ordres docker amb normalitat.

### Obtenció de la configuració inicial d’ Apache

El paquet que s’està utilitzant és el principal del repositori oficial https://hub.docker.com/_/php (**php:apache**), que inclou el servei http al mateix contenidor. Una pràctica habitual és la de vincular la carpeta de configuració del servei com a volum virtual que podem administrar des del nostre host amfitrió. Per aconseguir-ho, es defineix aquest volum a l'arrencada del contenidor amb el paràmetre de run [...] -v ./ruta/local:/etc/apache2, però si hem definit un directori que encara és buit, el contenidor arrancara amb un /etc/apache2 buit i no funcionarà. Per això, si volem obtenir primer la configuració inicial, abans de vincular el volum, feim una còpia de la carpeta original:
```shell
:$ docker run --name <containerId> -d php:apache
:$ docker cp <containerId>:/file/path/within/container /host/path/target 
```
En el nostre cas:
```shell
:$ docker cp <containerId>:/etc/apache2 ./apache2_files
```

### Configurar Apache amb SSL
Es pot accedir al terminal de qualsevol contenidor executant:

```shell
:$ docker exec -it Nom/ID_Contenidor bash
```
En general, `docker exec` exec permet executar qualsevol commande que pugui acceptar; les opcions `-it` permeten crear l’entorn de Terminal Interactiu, i executant `bash` estarem entrant en mode consola. Per identificar el contenidor tant es pot usar el nom, com pot ser *serv-php-apache*, com l’ID del contenidor; en cas d’usar l’identificador, no és necessari introduir tot el Hash que composa la ID, basta amb els primers dígits que el diferencien dels altres: per exemple, si aquest contenidor té la ID: *cba594c7bce8*, ens basta escriure:

```shell
:$ docker exec -it cba bash.
```

Primer s’ha aconseguit un par de claus pública i privada amb l’eina OpenSSL executant des del terminal del contenidor **php:apache** la següent ordre:

```shell
root@bae23350d9e2:/etc/apache2/ssl# openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/ssl-cert-snakeoil.key -out /etc/apache2/ssl/ssl-cert-snakeoil.pem -subj "/C=ES/ST=Spain/L=Palma/O=eDv/OU=Development/CN=edv.net"
Generating a RSA private key
.........................................................+++++
..........................+++++
writing new private key to '/etc/apache2/ssl/ssl-cert-snakeoil.key'
-----
```

Després, s’escriu un arxiu de configuració a **/etc/apache2/sites-available/edv-ssl.conf**:

```shell
<IfModule mod_ssl.c>
  <VirtualHost *:443>
    ServerAdmin infoabio@gmail.com
    DocumentRoot /var/www/html

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    SSLEngine on
    SSLCertificateFile  /etc/apache2/ssl/ssl-cert-snakeoil.pem
    SSLCertificateKeyFile /etc/apache2/ssl/ssl-cert-snakeoil.key
    <FilesMatch "\.(cgi|shtml|phtml|php)$">
        SSLOptions +StdEnvVars
    </FilesMatch>
    <Directory /usr/lib/cgi-bin>
        SSLOptions +StdEnvVars
    </Directory>
  </VirtualHost>
</IfModule>
```

**Apache** obté la configuració, a més de l’arxiu principal que es reserva per modificacions globals, de cada arxiu que es troba al directori **sites-enabled**. Una bona pràctica és escriure un arxiu de configuració per cada domini que ha de tractar el servei dins el directori **sites-available**, i al **sites-enabled** incloure un enllaç simbòlic que apunta a l’arxiu.

```shell
root@bae23350d9e2:/etc/apache2/sites-enabled# ln ../sites-available/edv-ssl.conf -s
root@bae23350d9e2:/etc/apache2/sites-enabled# ls -l
total 8
lrwxrwxrwx 1 root root   35 Apr 14 17:21 000-default.conf -> ../sites-available/000-default.conf
lrwxrwxrwx 1 root root   31 Jun 13 14:20 edv-ssl.conf -> ../sites-available/edv-ssl.conf
```

També serà necessari tenir activat els mòduls *SSL* i *Rewrite* d’**Apache** i incloure l’arxiu **.htaccess** al directori arrel de l’aplicació **Laravel**:

```shell
<IfModule mod_rewrite.c>
   Options +FollowSymLinks
  
   RewriteEngine on
   RewriteCond %{REQUEST_URI} !^public
   RewriteRule ^(.*)$ public/$1 [L]

   RewriteRule ^ index.php [L]
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteCond %{REQUEST_FILENAME} !-f
</IfModule>
```

Finalment, per tenir un entorn de desenvolupament pròxim al resultat final, s’inclou la direcció de la web a la llista de hosts per fer la redirecció local mentre es treballa amb la pàgina. Donat que està previst que l’aplicació web usarà un codi d’idioma com subdomini per permetre la funcionalitat multillenguatge, s’han inclòs cada un dels subdominis a la redirecció.

```shell
/etc/hosts
127.0.0.1 localhost
127.0.0.1 dev.edv.net ca.dev.edv.net es.dev.edv.net en.dev.edv.net
```

### Separació d’arxius LOG

A l'arxiu que correspon a /etc/apache2/envvars, que en el nostre exemple es pot accedir de ./apache2_files/envvars, podem definir el directori on es guarden els logs. Es defineix, típicament en la línia 28 d'aquest arxiu, la variable APACHE_LOG_DIR, a la qual anem a inserir la següent adreça personalitzada:

```bash
{APACHE_LOG_DIR:=${APACHE_CONFDIR}/logs/${HOSTNAME}$SUFFIX}
```

Amb això, els logs apareixen dins el directori de configuració d'**Apache**, en una carpeta dins el directori logs que té per nom el definit en HOSTNAME. Per generar més quantitat d'informació, a l'arxiu de configuració general apache2.conf, normalment en la línia 143, modifiquem el paràmetre: loglevel debug
Docker Compose

Aquesta eina està pensada per definir l'execució de múltiples contenidors, fent més àgil la interacció entre ells. Es basa en un arxiu de format YML, que es pressuposa amb el nom predeterminat docker-compose.yml. Tingues en compte que en aquest format és important mantenir una adequada identació (com passa per exemple amb el llenguatge Python).

En aquest es defineixen els contenidors que executarem, un amb el servei de base de dades que utilitza el repositori oficial de **mariadb:latest**. S’utilitzen les variables d’entorn per definir les principals dades de configuració a la base de dades, que es poden definir o bé llistades amb format CLAU:valor al apartat environment, o bé utilitzar un arxiu .env amb aquestes variables definides a un fitxer amb format CLAU=valor i referenciar-ho amb l’apartat env_file:

```bash
MYSQL_ROOT_PASSWORD=contrasenya_admin
MYSQL_DATABASE=nom_base_de_dades
MYSQL_USER=nom_usuari
MYSQL_PASSWORD=contrasenya_usuari
```

Al contenidor del servei s’ha especificat la relació d'equivalència entre port del host i port del contenidor (*localhost*:80 -> *env-web*:80), els volums virtualitzats, i la comunicació amb el servei de base de dades dins de la xarxa interna de **Docker**.

Els dos serveis inclouen també la política restart: always de manera que mentre els contenidors no s’aturin per l’ordre docker container stop `<containerID>`, aquest es reincorporarà, i això inclou si la màquina amfitrió es reinicia.

S’ha declarat una xarxa interna edv-net que comparteixen els contenidors que és a través de la qual es produeix la seva comunicació a nivell intern de Docker, sense int. En aquest cas no s'han declarat els volums com camp arrel perquè a cada servei es defineixen de manera especifica; en altres casos s’haurien d'incloure.

L’imatge d’on finalment s’obté el servidor d’aplicació PHP s’obté usant un arxiu **Dockerfile** que obté el contenidor executa l’instal·lació i activació del mòdul *mysqli* (MySQL-improved) que s’han utilitzat per la connexió amb el servei de base de dades.

#### Arxiu docker-compose.yml

```yml
version: '3.3'

networks:
 edv-net:

services:
 edv-database:
   image: mariadb:latest
   volumes:
     - ./db_data:/var/lib/mysql
   restart: always
   networks:
     edv-net:
       aliases:
         - edv-db

   env_file:
     - edv.env

 edv-web:
   build: ./php-apache
   depends_on:
     - "edv-database"
   networks:
     - edv-net
   ports:
     - "80:80"
     - "443:443"
   links:
     - edv-database
   restart: always
   volumes:
     - ./html:/var/www/html
     - ./apache2_files:/etc/apache2
```

#### Arxiu Dockerfile

```dockerfile
FROM  php:apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql bcmath
RUN a2enmod rewrite
```

Finalment, només cal arrancar els contenidors amb l’ordre:

```shell
:$ docker-compose up
```

El primer cop que s’executa, es pot veure com descarrega la imatge del repositòri.

```shell
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

Creating pfc_edv-database_1 ... done
Creating pfc_edv-web_1      ... done

:$ docker ps -a
CONTAINER ID        IMAGE               COMMAND                  CREATED              STATUS              PORTS                NAMES
6112434701ed        pfc_edv-web         "docker-php-entrypoi…"   About a minute ago   Up About a minute   0.0.0.0:80->80/tcp   pfc_edv-web_1
e34a5c43a202        mariadb:latest      "docker-entrypoint.s…"   About a minute ago   Up About a minute   3306/tcp             pfc_edv-database_1
```

També es comprova que s’han creat els directoris html i db_data; i si executem un terminal al contenidor de la base de dades, podem entrar (amb la contrasenya que hem definit al docker-compose.yml) al servei i comprovar que es crea la base de dades que hem indicat. 

```shell
:$ docker exec -it pfc_edv-database_1 mysql -u edv_web -p
Enter password:
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 10
Server version: 10.3.15-MariaDB-1:10.3.15+maria~bionic mariadb.org binary distribution

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
```
```sql
MariaDB [(none)]> show databases;
+--------------------+
| Database           |
+--------------------+
| edv                |
| information_schema |
+--------------------+
2 rows in set (0.001 sec)
```
I així està preparat l’entorn de producció; al final del projecte, s’explicarà com compactar l’aplicació en forma de contenidor per tal de facilitar la instal·lació del paquet.

## Laravel
**Laravel** és un framework de codi obert per PHP que utilitza el patró de disseny **M**odel-**V**ista-**C**ontrolador. He decidit utilitzar-ho per les següents raons: 

* Raó principal: per aprofitar l’oportunitat d’aprendre-ho
* Dotar al projecte de robustesa en quant a pràctiques de seguretat en el tractament de sessions i maneig de base de dades.
* Permet tractar la traducció, tant de la pàgina com dels seus mòduls d’entrenament, de manera dinàmica i simple, tant entre les llengües que s’utilitzaran a aquesta presentació inicial, com l’incorporació de futurs idiomes si el projecte creix.

Per instal·lar **Laravel**, es pot descarregar el **Composer**, un administrador de dependències de PHP, amb les ordres:

Després s’ha inclòs a la llista d’arxius que git pot ignorar, ja que no forma part del projecte.

I finalment es crea el projecte i se’n instal·len les dependències...

El projecte forma una estructura de directoris i és necessari que el servidor web apunti com a ruta arrel al directori /public; en aquest cas, essent que l’**Apache** pren la ruta del contenidor docker, serà: DocumentRoot /var/www/html/public. A més, com s’ha creat el projecte a un directori /edv, s’ha modificat el volum del servei edv-web del docker-compose.yml:

```yml
   volumes:
     - ./edv:/var/www/html
```

# Base de dades

## Model Entitat/Relació

El plantejament de la base de dades pretén mantenir una estructura molt simplificada. Inicialment, el model E/R resultava bastant redundant degut a la idea de la modularitat del projecte que implica que cada mòdul d’aprenentatge tindrà taules de dades diferents, adequades al estudi del que s’està treballant. Però lo cert és que aquesta estructura modular no l’ha d’assumir necessàriament per complet el model de la base de dades; si en lloc de plantejar-ho de manera purament SQL tenim en compte que es pot combinar l’ús d’aquest amb el format JSON1, podem combinar el model SQL per administrar l’enmagatzament de dades, i utilitzar aquestes dades de manera No-SQL per donar major llibertat de disseny a la posterior creació de mòduls. 

![Entitat-Relació Model][ER-mod]

Així, el plantejament del model de la base de dades pot simplificar-se bastant, essent que els elements referents a les Dades i la configuració del Skill, el que guarda son vectors de dades a un sol atribut en format JSON que dependen de la naturalesa de l’habilitat:

![Entitat-Relació Model-Atributs][ER-mod-atrib]

## Model Relacional

La traducció del Model E/R al Model Relacional s’obté convertint les diferents entitats i relacions en taules marcades per una clau principal i referències a claus foranes:

|Entitats:| |
|---|---|
|usuari|(**userID**, nomusr, nom, alies, email, passwd)|
|skill |(**skillID**, nomsk, ruta, imatge)|
|sessió|(**sessioID**, t_inici)|
|dades |(**dadesID**, dades)|

|Relacions:| | |
|---|---|---|
|configura|N:M|(*userID*, *skillID*, v_config)|
|practica|1:N|*userID* → clau forana de sessió|
|utilitza|N:1|*skillID* → clau forana de sessió|
|genera|1:1|*dadesID* →clau forana de sessió|

## Normalització

Es pot observar l’esquema de dependències resultant, per comprovar el compliment de les condicions de normalització:

![Entitat-Relació Normalització][ER-mod-norm]

**1FN**: Les taules representen un isomorfisme de les relacions del model, tenen clau primària i no hi ha repetició de dades ni necessitat d’ordre entre files o columnes. Cap atribut pot contenir valors no atòmics: cal dir que l’ús del atributs *v_dades* i *v_conf* es poden considerar un valor atòmic encara que aquest sigui un vector de diverses dades: la atomicitat es manté perquè només s’hi introdueix un vector de dades (quines siguin).

**2FN**: Els atributs no-clau tenen dependència funcional de la totalitat de la clau primària. En aquest cas, cada atribut depèn només d’una clau primària, excepte el cas de *v_conf* que depèn de **userID** i **skillID**: depèn de la totalitat de la clau primària, no només d’un dels dos components. Per tant, no es donen dependències parcials de la clau primària.

**3FN**: Es pot veure que amb aquesta estructura existeix una dependencia transitiva entre les claus primàries **userID**, **skillID** i **dadesID** que formen una dependència sobre **sessioID**, i d’aquesta depèn l’atribut *t_inici*, per tant, *t_inici* mostra dependencia transitiva amb la clau formada pel conjunt dels tres primers. Això ens indica que la clau **sessioID** és redundant, ja que amb la combinació de les tres primeres es pot identificar qualsevol sessió en particular.

| Normalització: | | |
|---|---|---|
|(2 FN)| sessió | (**sessioID**, *userID*, *skillID*, *dadesID*, t_inici) |
||| *userID*, *skillID*, *dadesID* → **sessioID**  → t_inici |
|(3 FN)| sessió | (**userID**, **skillID**, **dadesID**, t_inici) |
||| **userID**, **skillID**, **dadesID** → t_inici |

**FNBC**: La forma normal de Boyce-Codd també es compleix ja que no existeixen dependències funcionals no trivials que no siguin un conjunt de la clau primària.

**4FN**: No es troben dependencies multivaluades. L’única taula que pot posar-ho en dubte és la de sessió, que té tres claus primàries d’on poden aparèixer repeticions de tuples entre **userID** i **skillID**, però l’identificador de dades serà sempre únic i no pot formar una dependencia multivaluada.

**5FN**: Degut a que no hi ha dependencies multivaluades, no es poden formar dependències de reunió que contradiguin la forma normal de projecció-unió.

El model relacional finalment resulta de la següent manera:

usuari        (**userID**, nomusr, nom, alies, email, passwd)
skill        (**skillID**, nomsk, ruta, imatge)
dades        (**dadesID**, dades)
sessió        (**userID**, **skillID**, **dadesID**, t_inici)
configura    (**userID**, **skillID**, v_config)

## SQL:
```sql
create or replace table usuari (
 userID  bigint unsigned not null auto_increment primary key,
 nomusr  tinytext not null,
 nom     tinytext,
 alies   tinytext,
 email   tinytext,
 passwd  tinytext 
);
create or replace table skill (
 skillID int unsigned not null auto_increment primary key,
 nomsk   tinytext not null,
 ruta     tinytext not null,
 imatge  tinytext not null
);
create or replace table dades (
 dadesID bigint unsigned not null auto_increment primary key,
 v_dades longtext not null
);
create or replace table configura (
 userID  bigint unsigned not null,
 skillID int unsigned not null,
 v_conf  longtext,
 primary key (userID,skillID),
 foreign key (userID)  references usuari(userID),
 foreign key (skillID) references skill(skillID)
);
create or replace table sessio (
 userID    bigint unsigned not null,
 skillID   int unsigned not null,
 dadesID   bigint unsigned not null,
 t_inici   timestamp,
 primary key (userID,skillID,dadesID),
 foreign key (userID)  references usuari(userID),
 foreign key (skillID) references skill(skillID),
 foreign key (dadesID) references dades(dadesID)
);
```

# Disseny de la web

En aquest apartat s’explica primer les passes inicials prèvies a la composició de la web, que són: l’instal·lació de Node.js, preparar variables d’entorn, habilitar la possibilitat multillenguatge, i migrar els models relacionals a la base de dades.

Després s’expliquen les línies de codi més importants de la construcció de la web, eliminant comentaris o blocs que no precisen major atenció.

Com s’ha explicat a l’introducció, la idèa és preveure una estructura modular, de manera que la major part dels models respecte les anomenades Skills i la seva configuració poden pareixer un tant redundants essent que actualment només n’hi ha una, però és necessari que sigui així si es pretén que l’aplicació pugui ser extensible aplicant més mòduls de noves Skills en un futur.

S’inclou al final les explicacions importants a nivell conceptual i a nivell de còdi implicats amb la primera Skill, homònima de l’aplicació.

## Passes inicials

### Instal·lació Node.js

Es necessita instalar Node.js per poder compilar les fulles d’estil scss de **Laravel**. Això es pot fer en local o des del contenidor segons les necessitats del dissenyador; en aquest cas s’ha incorporat desde la màquina local per la comoditat de manejar-ho des del terminal:

```shell
:$ curl -sL https://deb.nodesource.com/setup_12.x | bash -
:$ apt-get install -y nodejs
:$ npm install
```

Un cop instal·lat, podem optar per compilar la fulla d’estil, o mantenir-ho en mode autocompilació per tal de que les modificacions s’apliquin al vol.

```shell
npm run dev     #per compilar
npm run watch   #per que s'autocompili quan fem modificacións
```

També ha estat necessari incloure les següents línies a l’arxiu **webpack.mix.js** per evitar un error de mapeig de font després de correr alguna de les ordres anterions.

```js
if (!mix.inProduction()) {
 mix.webpackConfig({
     devtool: 'source-map'
 })
 .sourceMaps()
}
```

### Variables d’entorn

L’arxiu **.env** conté variables d’entorn que permeten una configuració ràpida de la situació de l’aplicació. Aquí es poden identificar dades referent a l’identitat de la web, la connexió amb la base de dades, el servidor de mail si n’hi ha, etc.

```bash
APP_NAME=eDⓋ
APP_ENV=local
APP_KEY=base64:vWN0uNrBeGRe4x9C2mQez36GVPferuxCJ2g8MmaB/ok=
APP_DEBUG=true
APP_URL=http://dev.edv.net

LOG_CHANNEL=stack
DB_CONNECTION=mysql
DB_HOST=edv-db
DB_PORT=3306
DB_DATABASE=edv
DB_USERNAME=edv_web
DB_PASSWORD=webadmedv

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
```

### Idiomes

La capacitat multilengüatge de la pàgina funciona mitjançant la distinció de subdominis, de la mateixa manera que la coneguda Wikipedia.org, per veure la pàgina en un idioma, basta incloure el subdomini **ca.** , **es.** o **en.** davant de la URL de l’aplicació web.

Per habilitar l’ús de la pàgina en diferents idiomes, primer es crea amb artisan un middleware per administrar-ho:

```shell
:$ php artisan make:middleware LangMiddleware
Middleware created successfully.
```

També cal inclourer-ho al Kernel: ```App\Http\Kernel.php```

```php
class Kernel extends HttpKernel {
  protected $middleware = [
    …
    \App\Http\Middleware\LangMiddleware::class
  ];
```

I a la definició d’aquesta classe s’inclou el següent codi que permet obtenir si la pàgina es visita des d'algun dels subdominis que reconeix la llista definida a la configuració d’idiomes, per aplicar-ho amb `setLocale($subdomain)`:

```php
namespace App\Http\Middleware;
use Closure;
class LangMiddleware {
   public function handle($request, Closure $next) {
       // Obtain lang subdomain
       $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));
       $subdomain = $url_array[0];
  
       $languages = \Config::get('app.locales');
       if (array_key_exists($subdomain,\Config::get('app.locales')))
         \App::setLocale($subdomain);
  
       return $next($request);
   }
}
```

A l’arxiu de configuració general **config/app.php**, cal definir de quins idiomes disposa la web, és on el *LangMiddleware* realitzarà la cerca:

```php
   'locale' => 'ca',
   'locales' => [
       'en'    =>  'English',
       'es'    =>  'Español',
       'ca'    =>  'Català'
   ],
   'fallback_locale' => 'ca',
```

Al directori **resources/lang/{ca,es,en,...}** es troben els arxius on s’inclou el text que ha d'aparèixer a la web, en lloc d'escriure el contingut dirèctament sobre la pàgina. A la pàgina només cal escriure la ruta amb l’etiqueta de la frase, i depenent de la configuració d’idioma activa, aquesta s’obtindrà del subdirectori corresponent. Per mostrar l’exemple senzill, a la pàgina, en lloc d’escriure text, s’escriu la ruta ```{{ __('messages.skills') }}```, on s’identifica l’arxiu i la clau.

```php
 <div class="jumbotron text-center">
   <h1> {{ __('messages.title') }} </h1>
   <p> {{ __('messages.slogan') }} </p>
   <p><a class="btn btn-primary btn-lg" href="/login" role="button">{{ __('messages.login') }}</a>
     <a class="btn btn-success btn-lg" href="/register" role="button">{{ __('messages.register') }}</a></p>
   <br>
   <div class="links">
     <a href="/skills"> {{ __('messages.skills') }} </a>
   </div>
 </div>
 <div class="links">
   <a href="/about"> {{ __('messages.about') }} </a>
 </div>
```

A l’arxiu de configuració general config/app.php, cal definir de quins idiomes disposa la web, és on el LangMiddleware realitzarà la cerca:

```php
   'locale' => 'ca',
   'locales' => [
       'en'    =>  'English',
       'es'    =>  'Español',
       'ca'    =>  'Català'
   ],
   'fallback_locale' => 'ca',
```

Al directori **resources/lang/{ca,es,en,...}** es troben els arxius on s’inclou el text que ha d'aparèixer a la web, en lloc d'escriure el contingut dirèctament sobre la pàgina. A la pàgina només cal escriure la ruta amb l’etiqueta de la frase, i depenent de la configuració d’idioma activa, aquesta s’obtindrà del subdirectori corresponent. Per mostrar l’exemple senzill, a la pàgina, en lloc d’escriure text, s’escriu la ruta `{{ __('messages.skills') }}`, on s’identifica l’arxiu i la clau.

```php
 <div class="jumbotron text-center">
   <h1> {{ __('messages.title') }} </h1>
   <p> {{ __('messages.slogan') }} </p>
   <p><a class="btn btn-primary btn-lg" href="/login" role="button">{{ __('messages.login') }}</a><a class="btn btn-success btn-lg" href="/register" role="button">{{ __('messages.register') }}</a></p>
   <br>
   <div class="links">
     <a href="/skills"> {{ __('messages.skills') }} </a>
   </div>
 </div>
 <div class="links">
   <a href="/about"> {{ __('messages.about') }} </a>
 </div>
```

Mentre que de l’arxiu **resources/lang/ca/messages.php** s’obtenen les cadenes de text a partir d’una matriu associativa:

```php
 return [
   "title"   => "Entrenador Dvorak",
   "slogan"  => "Si així no n'aprens, és que no tens remei",

   "skills"  => "Skills",
   "about"   => "Sobre eDⓋ",
   "login"   => "Inicia sessió",
   "register" => "Registra't",

   // Home Dashboard
   "logged_in" => "Estàs connectat!",
   "dashboard" => "Panell"
 ];
```
### Creació de Models i Controladors
Es poden crear els arxius inicials que s’utilitzaran per definir els Models i Controladors amb **Artisan**. Per donar un primer exemple amb l’element *Skill*, es crea el controlador amb la funció:

```shell
:$ php artisan make:controller SkillsController --resource
Controller created successfully.
```

Principalment es genera l’arxiu **app/Http/Controllers/SkillsController.php**. 
L’opció `--resource` incorpora la col·lecció de rutes al control de Vista, incloent la línia `Route::resource('skills','SkillsController');` a l’arxiu de control de rutes -que es mostra més endavant- i que dona accés a un conjunt predefinit de funcions del controlador: index, create, show, store, edit, update i destroy.

Amb la següent commanda es genera l’arxiu **app/Skill**.php que defineix el model (classe) Skill:

```shell
:$ php artisan make:model Skill -m
Model created successfully.
Created Migration: 2019_05_19_103625_create_skills_table
```

Inicialment l’arxiu que es genera del model conté l’espai de noms i l'extensió de la classe Model:

```php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Skill extends Model {  //
}
```

L’opció `-m` genera un arxiu de migració del model a la base de dades, al directori **database/migrations** que veurem a continuació.

### Base de dades

#### Disseny
Cada element del model relacional que suposa una taula, amb l’esquema Model-Vista-Controlador significa crear un Model per cada un d’ells (encara que no necessiti mètodes específics). Aquests models tenen per extensió tota una sèrie de mètodes per manipular-los a la base de dades, depenent de si aquesta es basa en MariaDB/MySQL, PostgreSQL, MongoDB,...

Ha hagut diverses modificacions respecte a l’esquema original per fer-ho més ágil i pràctic a l’ús de **Laravel**:

* Les propietats de descripció del Skill, han convergit a un sol element **slug**; a partir d’aquest es pot obtenir les dades traduïdes respectant l’estructura multillenguatge de l’aplicació. 
* En lloc de crear una taula de Sessió per vincular-ho a una taula de Dades recopilades, s’ha trobat més adient fusionar aquestes dues en una sola taula: **Coffrets**. El nom és degut a que el valor principal d’aquesta aplicació és la captació de dades d’aprenentatge, i és el seu tresor.

Per preparar la migració, al directori **database/migrations** hi ha definits una sèrie d’arxius que defineixen les classes encarregades de crear l’esquema de taules a la base de dades:

```php
class CreateSkillsTable extends Migration {
 public function up() {
   Schema::create('skills', function (Blueprint $table) {
     $table->bigIncrements('skillId');
     $table->string('slug', 24)->unique();
     $table->timestamps();
   });
 }
 public function down() {
   Schema::dropIfExists('skills');
 }
}

class CreateSkillConfsTable extends Migration {
   public function up() {
       Schema::create('skill_confs', function (Blueprint $table) {
           $table->bigInteger('userId')->unsigned();
           $table->bigInteger('skillId')->unsigned();
           $table->json('vconf');
           $table->timestamps();
           $table->primary(['userId', 'skillId']);
           $table->foreign('userId')->references('id')->on('users');
           $table->foreign('skillId')->references('skillId')->on('skills');
       });
   }
   public function down() {
       Schema::dropIfExists('skill_conf');
   }
}

class CreateCoffretsTable extends Migration {
 public function up() {
   Schema::create('coffrets', function (Blueprint $table) {
     $table->bigIncrements('id')->unsigned();
     $table->bigInteger('userId')->unsigned();
     $table->bigInteger('skillId')->unsigned();
     $table->json('vdata');
     $table->foreign('userId')->references('id')->on('users');
     $table->foreign('skillId')->references('skillId')->on('skills');
     $table->timestamps();
     });
 }
 public function down() {
   Schema::dropIfExists('coffrets');
 }
}
```

#### Migració
Un cop definits els modelatges, es pot utilitzar **Artisan** per fer la migració a la base de dades

```shell
:$ docker exec -it pfc_edv-web_1 bash
root@76b63666f7c5:/var/www/html# php artisan migrate -v
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
Migrating: 2019_05_19_103625_create_skills_table
Migrated:  2019_05_19_103625_create_skills_table
Migrating: 2019_05_19_192712_create_skill_conf_table
Migrated:  2019_05_19_192712_create_skill_conf_table
Migrating: 2019_06_09_082855_create_coffrets_table
Migrated:  2019_06_09_082855_create_coffrets_table
```

Un cop creada la base de dades i la seva taula, podem comprovar que la creació ha estat exitosa des del contenidor de **MariaDB**:

```shell
:$ docker exec -it pfc_edv-database_1 mysql -u nom_usuari --password=contrasenya_usuari nom_base_de_dades
```

```sql
MariaDB [(none)]> use edv

Database changed
MariaDB [edv]> show tables;
+-----------------+
| Tables_in_edv   |
+-----------------+
| coffrets        |
| migrations      |
| password_resets |
| skill_confs     |
| skills          |
| users           |
+-----------------+
6 rows in set (0.000 sec)

MariaDB [edv]> show columns from skills;
+------------+---------------------+------+-----+---------+----------------+
| Field      | Type                | Null | Key | Default | Extra          |
+------------+---------------------+------+-----+---------+----------------+
| skillId    | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| slug       | varchar(24)         | NO   | UNI | NULL    |                |
| created_at | timestamp           | YES  |     | NULL    |                |
| updated_at | timestamp           | YES  |     | NULL    |                |
+------------+---------------------+------+-----+---------+----------------+
4 rows in set (0.001 sec)

MariaDB [edv]> show columns from skill_confs;
+------------+---------------------+------+-----+---------+-------+
| Field      | Type                | Null | Key | Default | Extra |
+------------+---------------------+------+-----+---------+-------+
| userId     | bigint(20) unsigned | NO   | PRI | NULL    |       |
| skillId    | bigint(20) unsigned | NO   | PRI | NULL    |       |
| vconf      | longtext            | NO   |     | NULL    |       |
| created_at | timestamp           | YES  |     | NULL    |       |
| updated_at | timestamp           | YES  |     | NULL    |       |
+------------+---------------------+------+-----+---------+-------+
5 rows in set (0.001 sec)

MariaDB [edv]> show columns from coffrets;
+------------+---------------------+------+-----+---------+----------------+
| Field      | Type                | Null | Key | Default | Extra          |
+------------+---------------------+------+-----+---------+----------------+
| id         | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| userId     | bigint(20) unsigned | NO   | MUL | NULL    |                |
| skillId    | bigint(20) unsigned | NO   | MUL | NULL    |                |
| vdata      | longtext            | NO   |     | NULL    |                |
| created_at | timestamp           | YES  |     | NULL    |                |
| updated_at | timestamp           | YES  |     | NULL    |                |
+------------+---------------------+------+-----+---------+----------------+
6 rows in set (0.001 sec)

MariaDB [edv]> show columns from users;
+-------------------+---------------------+------+-----+---------+----------------+
| Field             | Type                | Null | Key | Default | Extra          |
+-------------------+---------------------+------+-----+---------+----------------+
| id                | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| user              | varchar(255)        | NO   | UNI | NULL    |                |
| email             | varchar(255)        | NO   | UNI | NULL    |                |
| name              | varchar(255)        | NO   |     | NULL    |                |
| email_verified_at | timestamp           | YES  |     | NULL    |                |
| password          | varchar(255)        | NO   |     | NULL    |                |
| remember_token    | varchar(100)        | YES  |     | NULL    |                |
| created_at        | timestamp           | YES  |     | NULL    |                |
| updated_at        | timestamp           | YES  |     | NULL    |                |
+-------------------+---------------------+------+-----+---------+----------------+
9 rows in set (0.001 sec)
```

Per crear la primera entrada a la taula de Skills i Configuració, amb **Artisan-tinker** es pot crear l’objecte corresponent i guardar-ho. En el següent exemple s’introdueix la definició de l’skill edv i la configuració per defecte corresponent a aquesta assignada a l’usuari 1 (Guest).

```shell
:$ docker exec -it pfc_edv-web_1 bash
root@76b63666f7c5:/var/www/html# php artisan tinker
```
```php
Psy Shell v0.9.9 (PHP 7.3.5 — cli) by Justin Hileman
>>> $skill = new App\Skill();
=> App\Skill {#2965}
>>> $skill->slug='edv';
=> "edv"
>>> $skill->save();
=> true
>>> $sc = new App\SkillConf();
=> App\SkillConf {#2965}
>>> $sc->userId=1;
=> 1
>>> $sc->skillId=1;
=> 1
>>> $sc->vconf='{"method":"word","lang":"es","keymap":"dv"}';
=> "{"method":"word","lang":"es","keymap":"dv"}"
>>> $sc->save();
=> true
```

### Paquets addicionals

Hi ha dos paquets de recursos que s’han inclòs a l’instal·lació de **Laravel** a través de **Composer**.
* **Laravelcollective/html**: Creació de formularis aplicats amb les plantilles Blade.
* **khill/lavacharts**: Renderitza gràfiques a partir de vectors de dades.

Per incloure’ls, s’adjunten a la secció “require” de l’arxiu **Composer.json**:

```json
"require": {
 "php": "^7.1.3",
 "fideloper/proxy": "^4.0",
 "laravel/framework": "5.8.*",
 "laravel/tinker": "^1.0",
 "laravelcollective/html": "^5.4.0",
 "khill/lavacharts" : "3.1.*"
```

L’instal·lació es realitza obtenint el paquet des dels repositoris:

```shell
:$ php composer.phar update
 ...
 - Installing khill/lavacharts (3.1.11): Downloading (100%)
```

Cal modificar també l’arxiu **config/app.php** per incloure les classes al grup de proveïdors i d’alies: 

```php
"providers" => [
 ...
 Collective\Html\HtmlServiceProvider::class,
 Khill\Lavacharts\Laravel\LavachartsServiceProvider::class
],
"aliases" => [
 ...
 'Form' => Collective\Html\FormFacade::class,
 'Html' => Collective\Html\HtmlFacade::class,
 'Lava' => Khill\Lavacharts\Laravel\LavachartsFacade::class
]
```

## Rutes
A **routes/web.php** es troba la llista de rutes que controlen la vista de la pàgina. A través d’aquests mètodes es defineix quin controlador actúa per cada direcció; en lloc de organitzar-se per un sistema de directòris, la vista identifica la URL, el mètode de consulta HTML (GET, POST, PUT, HEAD, DEL, …) i els paràmetres que es puguin incloure per enviar-la al Controlador adient. 

Com es pot veure a continuació, hi ha definits dos mètodes GET per la pàgina principal i l’about, tres mètodes de recursos, que engloben tota una sèrie de possibilitats (indexar, mostrar, editar, …) que s’administren amb el controlador del model; i els mètodes del sistema d’autenticació seguit del lloc /home on es trobaria el panell d’usuari:

```php
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::resource('skills','SkillsController');
Route::resource('skillsconf','SkillConfController');
Route::resource('coffret','CoffretController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
```

Es pot obtenir la llista completa de rutes definides amb el commande d’Artisan:

```shell
$ php artisan route:list
```

## Auth

**Laravel** incorpora un sistema propi d’autenticació d’usuaris molt robust; per activar-ho basta executar: 

```shell
$ php artisan make:auth
```

Amb aquesta ordre es genera el model, controlador, i el sistema de ruta necessari per un sistema d’autenticació funcional amb clau encriptada i ús de tokens per control de sessió. A l’arxiu **conf/auth.php** es poden modificar opcions de configuració, però no ha estat necessari. 

És modificable, com l’incorporació de nom d’usuari i la seva validació al formulari de registre; per això s’ha inclòs al model **app/User.php** la propietat ‘user’ dins l’array `$fillable`, i al controlador de registre **app/Http/Controllers/Auth/RegisterController.php** la fila que defineix el seu format.

Model:

```php
class User extends Authenticatable {
   use Notifiable;
   protected $fillable = ['name', 'user', 'email', 'password' ];
   protected $hidden = ['password', 'remember_token' ];
   protected $casts = ['email_verified_at' => 'datetime' ];
}
```
RegisterController:
```php
 protected function validator(array $data) {
   return Validator::make($data, [
     'name'    =>  ['required', 'string', 'max:255'],
     'user'    =>  ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
     'email'   =>  ['required', 'string', 'max:255', 'email', 'unique:users'],
     'password'=>  ['required', 'string', 'min:8', 'confirmed'],
   ]);
 }

 protected function create(array $data) {
   return User::create([
     'name' => $data['name'],
     'user' => $data['user'],
     'email' => $data['email'],
     'password' => Hash::make($data['password']),
   ]);
```

## Models

Com s’ha vist abans, els models creats amb Artisan generen un arxiu **app/model.php** que tenen en comú l’espai de noms i l’ús de la classe Model:

```php
namespace App;
use Illuminate\Database\Eloquent\Model;
```

Com són extensions de la classe Model, ja hereda els mètodes necessaris per manejar-los a la base de dades; per tant només cal incloure particularitats o funcions addicionals si les necessita. Per exemple, el model **Coffrets** no necessita incloure res, però als models **Skill** i **SkillConf** sí que hi ha algunes definicions.

### Skill
Per defecte, els models de **Laravel** apliquen un camp *id* amb autoincrement com clau primària; en el cas del model **Skill**, cal indicar que la clau primària és *skillId*.

```php
class Skill extends Model {
   protected $primaryKey = 'skillId';
}
```

### SkillConf
En aquest cas s’ha definit una funció adicional que permet l’ús de clau composta. Aquest podria ser un punt feble per part de **Laravel**: no contempla que un model / taula tingui com clau principal a una composta per dos (o més) camps: està ideat per generar igualment un *id*, encara que sigui redundant, per cada una de les combinacions de parelles possibles de claus que formen la clau composta.

Per això s’ha inclòs la funció `setKeysForSaveQuery(Builder $query)` que arregla aquesta situació[2]:

```php
use Illuminate\Database\Eloquent\Builder; // :: setKeysForSaveQuery ::

class SkillConf extends Model {
 public $incrementing = false;
 protected function setKeysForSaveQuery(Builder $query) {
   $query
     ->where('userId', '=', $this->getAttribute('userId'))
     ->where('skillId', '=', $this->getAttribute('skillId'));
   return $query;
 }
}
```

## Controladors

Els controladors son les classes encarregades de gestionar la informació dels models per retornar la informació a la vista de l’usuari. Els dos models genèrics **Skill** i **SkillConf** manegen l’identificació i configuració d’un mòdul en base al paràmetre slug i l’autenticació de l’usuari; en cas de que l’usuari no tengui cap compta, es considera l’usuari *‘Guest’* amb *id*=1. Com s’ha vist, els controladors que hem creat amb **Artisan** comparteixen l’espai de noms i l’ús del recurs Request, que obté els paràmetres de consulta. Després, addicionalment s’inclouran a cada controlador els recursos o models necessaris per completar la seva funció.

```php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
```

### Skill

Aquest controlador s’utilitza per dues funcions:

* `index()`: Llistar a la pàgina de mòduls disponibles cada element registrat a la base de dades. La taula *skills* manté la relació entre identificador i nom clau d’aquest.
* `show($slug)`: Un cop l’usuari fa la petició per accedir a un mòdul, demana al controlador **SkillConf** la configuració que s’ha d’aplicar i la incorpora a la vista de l’**Skill**.

```php
use App\Skill;
use App\Http\Controllers\SkillConfController;

class SkillsController extends Controller{
 public function index() {
   $skills = Skill::all();
   return view('pages.skills')->with('skills',$skills);
 }
 public function show($slug) {
   $vconf  = json_decode((new SkillConfController)->getSkillConf($slug),true);
   return view("skills.$slug.$slug")->with('vconf',$vconf);
 }
}
```

### SkillConf

Aquest és el controlador més complet, s’encarrega de manejar la configuració que s’aplica a l’usuari per cada mòdul d’aprenentatge depenent de les opcions que hagi guardat. L’usuari *Guest* és el que es reserva per guardar la configuració predeterminada.

Actualment, la configuració s’obté a partir d’un formulari i les dades es guarden en una cadena amb format JSON. Això és degut a que es vol mantenir una independència del model respecta del Skill: si un mòdul d’aprenentatge, per exemple d’idioma o càlcul mental, necessita utilitzar altres paràmetres de configuració o mesura, no podría coincidir amb un model (taula) que té les propietats del mòdul de mecanografía. Depenen del futur d’aquesta aplicació, es pot plantejar si cal crear un model diferent per cada mòdul que s’activa a l’aplicació.

Les funcions d’aquest controlador són:
* `getSkillConf($slug)`: Obté la configuració assignada a l’usuari des de la base de dades. Si no en té, obté la configuració prestablerta; o en cas de ser anònim, s’utilitza la sessió per guardar (de manera temporal) els canvis que pugui fer. Aquesta funció s’ha definit pública perquè ha de ser accesible des del controlador **Skill**.
* `index()`: Llista les configuracions guardades; aquesta funció encara no es troba en ús perquè no s’ha completat el disseny del panell d’usuari.
* `store(Request $request)`: Guarda a la base de dades -o a la sessió en cas de ser usuari anònim- la configuració definida al formulari
* `show($skill)`: Obté les dades de configuració actual per que es mostrin com valors actuals del formulari.

```php
use App\SkillConf;
use App\Skill;

class SkillConfController extends Controller {
 public function getSkillConf($slug) {
   // GUEST case: use session config if defined.
   if(!(auth()->check()) && session()->exists("$slug"))
     return session()->get("$slug");

   $userId = auth()->check() ? auth()->user()->id : 1;
   $skillId = Skill::select()->where('slug',$slug)->first()->skillId;
  
   $skillConf  =   SkillConf::select()
     ->where('userId',$userId)
     ->where('skillId',$skillId)
     ->first();

   // case: user has no config defined yet, gets from Guest 'default'
   if (!$skillConf)
     $skillConf  =   SkillConf::select()
       ->where('userId',1)
       ->where('skillId',$skillId)
       ->first();
    
   return $skillConf->vconf;
 }

 public function index() {
   $skillsConf = [];
   $skills = Skill::all();
  
   foreach($skills as $skill){
     $skillsConf[$skill->slug]= $this->getSkillConf($skill->slug);
   }

   return view('pages.skillsconf')->with('skillsConf',$skillsConf);
 }

 public function store(Request $request) {
   $messages=[];
   $slug = 'edv'; //   !!!!! !!!! !!! !!! ! ! ! ! !
   $skill = Skill::where('slug',$slug)->first();
   $skillId=$skill->skillId;

   $vconf = json_encode($request->input());
  
   // If user is logged: save config in DB
   if(auth()->check()){
     $userId=auth()->user()->id;
    
     $skillConf = SkillConf::where('userId',$userId)->where('skillId',$skillId)->first();
     if (!$skillConf) $skillConf = new SkillConf;
    
     $skillConf->userId  = $userId;
     $skillConf->skillId = $skillId;
     $skillConf->vconf   = $vconf;
     $skillConf->save();
    
     $messages['edv'] = "Saved";    // <<<<< ------ TRANSLATE THIS
   } else {
     // GUEST case: save options in session.
     session()->put($slug, $vconf);
     $messages['edv'] = "No loggin";
   }
  
   return view('pages.skills')->with(['skills'=>Skill::all(),'messages'=>$messages]);
 }

 public function show($skill) {   
   return view("skills.$skill.conf")->with([
     'vconf'   => json_decode($this->getSkillConf($skill),true),
     'slug'    => $skill
     ]);
 }
}
```

### Coffret
Aquest model s’encarrega de guardar les dades dins una matriu associativa amb format JSON, seguint el criteri utilitzat per guardar el vector de configuració de **SkillConf**; aquest vector recull les dades enviades pel mòdul d’entrenament que conté les medicions que es pretenen estudiar. En el cas del Skill mecanogràfic, es guarda el nombre de pulsacions i el temps transcorregut per completar la prova, que després s’utilitzen per calcular les pulsacions per minut; també es guarda el llistat de paraules que no s’han escrit correctament.

El model té també funcions internes (d’àmbit privat) per analitzar les dades guardades, tant a nivell global com les particulars de l’usuari, i mostrarles gràficament usant l’eina **Lavacharts**.

Utilitza quatre funcions:
* `PPMevolution($skillId,$userId)`: Obté la gràfica de tipus lineal que mostra el progrés personal de l’usuari al llarg del temps, basat en la mesura de pulsacions per minut.
* `PPMnormal($skillId,$wpm = false)`: Obté una gràfica de barres que mostra la distribució de freqüències global de puntuacions, mesurable en pulsacions o en paraules per minut. Cal dir que aquesta gràfica no cobra molt de sentit fins que el nombre de medicions és suficientment gran com per apreciar acumulacions de puntuació.
* `store(Request $request)`: Guarda les medicions d’una sessió d’entrenament a la base de dades.
* `show($slug)`: Crida les funcions que generen les gràfiques amb les dades actuals de la base de dades per presentar-les a la vista des de la plantilla d’anàlisis de l’Skill

```php
use App\Coffret;
use App\Skill;

class CoffretController extends Controller {
 private function PPMevolution($skillId,$userId) {
   $userCoffrets = Coffret::select()
     ->where('skillId',$skillId)
     ->where('userId',$userId)
     ->get()->toArray();
   $DataTable = \Lava::DataTable();
   $DataTable->addDateColumn('Date')->addNumberColumn('PPM');
  
   foreach ($userCoffrets as $coffret) {
     $analisys= json_decode($coffret['vdata'],true);
     $DataTable->addRow([
       $coffret['created_at'],
       round($analisys['vresults']['pacum']*600/$analisys['vresults']['t'],2)
     ]);
   }
   return \Lava::LineChart('statistics', $DataTable);
 }

 private function PPMnormal($skillId,$wpm = false) {
   $coffrets = Coffret::where('skillId',$skillId)->get()->toArray();
   $DataTable = \Lava::DataTable();
   $DataTable->addNumberColumn('PPM')->addNumberColumn('N');
  
   $sectors = [];
   foreach ($coffrets as $coffret) {
     $analisys= json_decode($coffret['vdata'],true);
     $ppm=(int)round($analisys['vresults']['pacum']*600/($analisys['vresults']['t']*($wpm?5:1)));
     (array_key_exists($ppm,$sectors))?++$sectors[$ppm]:$sectors[$ppm]=1;
   }

   foreach ($sectors as $sector => $n)
     $DataTable->addRow([$sector,$n]);

   $xpm = $wpm?'wpmnormal':'ppmnormal';
   return \Lava::ColumnChart($xpm, $DataTable);
 }

 public function store(Request $request) {
   $slug = $request->skill;
   $skillId = Skill::where('slug',$slug)->first()->skillId;
   $userId = auth()->check() ? auth()->user()->id : 1;

   $vresults = json_decode($request->vresults,true);
   $coffretData = [ 'skill' => $slug, 'vresults' => $vresults ];
   $coffret = new Coffret;
   $coffret->userId = $userId;
   $coffret->skillId = Skill::where('slug',$slug)->first()->skillId;;
   $coffret->vdata= json_encode($coffretData);
   $coffret->save();

   return view("skills.$slug.data")->with('vresults', $vresults);
 }

 public function show($slug) {
   $skillId = Skill::where('slug',$slug)->first()->skillId;
   $userId = auth()->check() ? auth()->user()->id : 1;
   $statistics = ($userId != 1)?$this->PPMevolution($skillId,$userId):null;

   $ppmNormal = $this->PPMnormal($skillId);
   $wpmNormal = $this->PPMnormal($skillId,true);

   return view("skills.$slug.analytics")->with('statistics', isset($statistics));
 }
}
```

# Skill - Entrenador Dvorak

La Skill inicial és homònima a l’aplicació: *Entrenador Dvorak*; pretén captar les dades del procés d’aprenentatge per poder fer en un futur la comparativa entre diverses opcions o mètodes, per deduir quin és el més efectiu comparant les diverses etapes de progrés d’escriptura. Actualment es troba en una fase molt bàsica perquè s’ha centrat l’atenció en preveure les possibilitats de desenvolupament posterior. Primer s’explicarà el criteri d’entrenament i posteriorment es descriuen les línies de codi més rellevants.

## Criteri d’entrenament per mesura probabilística
Un fet comú en que coincideixen tots els idiomes naturals humans és que en la comunicació hi ha una reduïda col·lecció de les paraules disponibles que formen la major part del corpus expressiu. Es pot dir que la freqüència d’ús de cada paraula segueix aproximadament una Distribució de Pareto.

Per això, aquesta Skill està pensada per mostrar les paraules a practicar d’acord amb la freqüència relativa associada a cada paraula. De manera que s’ha cercat diferents fonts que recompten el nombre de paraules dins una àmplia col·lecció, i encara que per cada idioma les fonts usades no han obtingut el corpus amb la mateixa estratègia, l’aproximació és bastant realista per la finalitat de l’aplicació:

* Anglès: s’ha obtingut en base al projecte Guttenberg, que recopila les obres literàries (actualment més de 59 000) de les que ha expirat qualsevol restricció per llicència (Copyright).
* Castellà: obtingut de la web oficial de la RAE
* Català: recompte de paraules usades dins la Vikipèdia.

Aquestes llistes de paraules en format text mantenen un format similar: 

|Pos. | word | n per billion
|---|---|---|
|1|the|56271872|
|2|of|33950064|
|3|and|29944184|
|4|to|25956096|
|5|in|17420636|
|6|i|11764797|
|7|that|11073318|
|8|was|10078245|
|9|his|8799755|
|10|he|8397205|
|11|it|8058110|
|12|with|7725512|

Primer s’ha transformat aquesta col·lecció de dades per obtenir en cada cas la seva freqüència relativa acumulada en format probabilístic, és a dir, cobrint el rang entre 0 i 1, atorgant vuit decimals de precisió. Aquesta conversió s’ha guardat per ser cercada després per una funció que genera un nombre aleatori i cerca la seva paraula corresponent.
S’ha comprovat que el mètode de recerca més efectiu entre els que s’han fet mesures, en aquest cas és el lineal, el qual té molt de sentit ja que les paraules estan ordenades dins la llista per ordre de probabilitat, per tant, davant un nombre aleatori, és d’esperar que els primers elements contenen la paraula acertada.

També s’han separat quatre opcions respecte l’elecció del paràmetre sigma, que reconeix un percentatge del vocabulari i modifica les freqüències acumulades per ser proporcionals a la nova col·lecció sesgada. Una sigma és a probabilitat el coeficient de desviació típica a una distribució normal, i amb aquesta es cobreix -aproximadament- el ~68.27% d’una població. Amb dues sigmas s’obté un ~95.45% i amb tres un ~99.7% . 

![Distribució normal - Sigma][Distrib-sigma]

Per exemple, en el cas de l’anglès:

```php
 "sigma_0" => "P < 50%", // 177 words",
 "sigma_1" => "P < 68.27%",  // 1635 words",
 "sigma_2" => "P < 95.45%",  // 6769 words",
 "sigma_3" => "P < 99.73%",  // 36664 words",
```

O del corpus en castellà:

```php
 "sigma_0" => "P < 50%", // 130 palabras",
 "sigma_1" => "P < 68.27%",  // 1256 palabras",
 "sigma_2" => "P < 95.45%",  // 40032 palabras",
 "sigma_3" => "P < 99.73%",  // 71119 palabras",
```

Com es pot apreciar, la primera meitat funció de densitat de freqüència acumulada, la cobreixen menys de dos centenars de paraules; menys de dos milers cobreixen la primera sigma. 

Per això l’aplicació està pensada per reforçar les paraules més habituals. Més endavant, caldria tenir en compte també la llista de paraules incorrectes per sel·leccionar-les amb major pes.

## Disseny del Skill

Les diferents pàgines de l’aplicació, incloent els mòduls Skill, parteixen d’una plantilla bàsica definida a **views/layouts/app.blade.php**. Aquesta carrega les capçaleres, que inclou un apartat per incrustar codi JavaScript adicional:

```php
 <!-- Skill's Scripts -->
 @stack('skill-script')
```

També carrega la secció `<body>` i inclou la barra de navegació superior, deixant una etiqueta per incorporar el contingut. Aleshores, per tal de seguir la plantilla bàsica, les pàgines comencen definint que són extensió d’aquesta i que es contingut s’incorpora a seva secció:

```php
@extends('layouts.app')
@section('content')
  {{-- Contingut --}}
@endsection
```

A continuació es descriuen les parts que suposen l’estructura del Skill. S’ha omès el que és codi HTML estructural (`<div class`,...).

Al contingut de la pàgina principal del Skill hi tenim vuit components:

1. El títol i presentació del Skill, adaptat al idioma en ús.

```php
 <h1> {{ __('edv.title') }} </h1>
 <p> {{ __('edv.slogan') }} </p>
```

2. Un llistat de paraules obtingut de la funció wordRecruiter($vconf)

```php
  @foreach (wordRecruiter($vconf) as $w => $word)
  <span class="word-stream" id="w-{{$w}}">{{$word}}</span>
  @endforeach
```

3. La secció interactiva on es mostra: la paraula a escriure, l’àrea d’entrada de text, i les medicions que es van prenent.

```php
  <h2 class="display-2 mb-5" id="current-word">·</h2>
  <input type="text" class="form-control form-control-lg"
  placeholder="· · ·" id="word-input" autofocus>

      <h3> {{ __('edv.time') }}:<span id="time">00:00.0</span></h3>

      <h3> {{ __('edv.ppm') }}:<span id="ppm">0</span></h3>
```

4. Un apartat descriptiu, també escrit en base a la traducció corresponent

```php
  <h5>{{ __('edv.instruc') }} </h5>
  <p> {{ __('edv.instxt') }} </p>
```

5. Un formulari ocult que serà activat per JavaScript quan acaba el test, que envía les dades capturades a la funció `@store` del controlador.

```php
  {{ Form::open(['action' => 'CoffretController@store','id' => 'stadistics']) }}
    <div class="form-group">
      {{ Form::hidden('skill', 'edv') }}
      {{ Form::hidden('vresults', '{ "t":0, "pacum":0, "wrong": [] }',
        ['class' => 'form-control','id' => 'vresults', 'readonly']) }}
    </div>
  {{ Form::close() }}
```

6. L’etiqueta que permet incorporar el codi JavaScript a la capçalera de la plantilla base.

```php
@push('skill-script')
<script src={{ asset('edv/js/edv.js') }}></script>
@endpush
```

7. Un apartat PHP que defineix la funció `wordRecruiter($vconf)`. Aquesta s’encarrega de obtenir el llistat de paraules tenint en compte els diferents paràmetres de configuració de manera aleatòria d’acord amb el criteri probabilístic que s’ha exposat.

```php
@php
  function wordRecruiter($vconf){
   $file = "edv/".$vconf['lang']."/wl_sigma".$vconf['sigma']."-".$vconf['lang'].".txt";
   $lines = file($file);
   $nlines = count($lines);
   $repeatable = array_key_exists("reptwords",$vconf);
   $wordlist = [];
   $top = (($nlines<144) && !$repeatable) ? $nlines : 144;
   for($i=0;$i<$top;$i++){
     $random = rand(0,100000000)/100000000;
     //  Search apropiate pondered index: lineal search (since prob. density is inverse)
     for($n=1;$n<$nlines;$n++){
       $line = preg_split("/\s+/",$lines[$n]);
       if ($random >= (float)$line[1]) continue;
       if (!$repeatable && in_array($line[2],$wordlist)) continue;
       $wordlist[] = $line[2];
       break;
     }
   }
 return $wordlist;
 }
@endphp
```

8. JavaScript, usant funcions jQuery, per controlar i recopilar la sessió d’entrenament, interactuant amb els diferents elements de la llista de paraules, l’àrea interactiva, i finalment l’ús del formulari.

```js
window.addEventListener('load', init);
let vresults = { "t":0, "pacum":0, "wrong": [] };
let nword = ppm = pacum = t = time = seconds = minutes = dec = 0;
let word = "";
let lastword = 144;
let training = chronometer = false;
let wordInput = document.getElementById('word-input');

function init() {
 wordInput  = document.getElementById('word-input');
  word = $(`#w-${nword}`).text();
 $('#current-word').text(word);
 $('#word-input').on("keydown",function (evt) {
   if (!training) startTraining();
   if (evt.which=='32') nextWord(this.value);
 });
 $('#word-input').on("keyup",function (evt) {
   if (!training) startTraining();
 });
 wordInput.addEventListener("change", function (evt) { nextWord(this.value); });
}

function startTraining() {
 if (chronometer) resetChrono();
 resetPPM();
 chronometer = setInterval(chrono,100);
 training = true;
}

function endTraining(){
$('#word-input').prop("disabled",true);
 clearInterval(chronometer);
 training = false;

 vresults['t']=t; vresults['pacum']=pacum;
 $('#vresults').val(JSON.stringify(vresults));
 $('#stadistics').submit();
}

function nextWord(value){
 entryword = value.trim();
 if (word.trim() == entryword) {
   pacum += entryword.length;
   ppm = pacum*(600/t);
   $("#ppm").text(`${Math.round(ppm*100)/100} ppm`);
 } else {
   vresults.wrong.push([word,entryword]);
   $(`#w-${nword}`).css("text-decoration","line-through");
 }
$(`#w-${nword}`).addClass("text-muted");
 nword++;
 if (nword<lastword){
   word = $(`#w-${nword}`).text();
   $('#current-word').text(word);
   $('#word-input').val("");
 } else endTraining();
}

function chrono() {
 t++; dec++;
 if (dec > 9) {
   dec = 0;
   seconds++;
 }
 if (seconds > 59) {
   seconds = 0;
   minutes++;
 }
 time = ((minutes < 10)?`0${minutes}`:`${minutes}`)
     + ((seconds < 10)?`:0${seconds}`:`:${seconds}`)
     + `.${dec}`;
 $("#time").text(time);
}

function resetChrono() {
 t = minutes = seconds = dec = 0;
 $("#time").text(`00:00.0`);
}

function resetPPM() {
 ppm = 0;
 $("#ppm").text(`0`);
}
```

### Formulari de configuració
El formulari presenta les opcions de configuració disponibles del Skill; aquest obté el vector que defineix l’estat actual dels elements configurables a partir de la matriu associativa `$vconf` per incorporar-los com valors predefinits al formulari. Per exemple, per definir la Sigma que regula el rang del vocabulari disponible, es defineix amb un element select, amb opcions entre 0 i 3, i establint per defecte el que conté la clau `$vconf['sigma']`.

```php
{{ Form::open(['action' => 'SkillConfController@store']) }}
    {{-- [...] --}}
      </li>
      {{ Form::label("sigma",__("edv.sigma")) }}
      {{ Form::select("sigma", [
          "0" => __("edv.sigma_0"),
          "1" => __("edv.sigma_1"),
          "2" => __("edv.sigma_2"),
          "3" => __("edv.sigma_3")
          ], $vconf['sigma'],['class' => 'form-control'])}}
      </li>
    {{-- [...] --}}
  {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
{{ Form::close() }}
```

### Data
Un cop acaba la sessió d’entrenament, el codi JavaScript envía amb el formulari les dades al controlador per emmagatzemar-les a la base de dades, i seguidament es presenta a aquesta pàgina els resultats obtinguts: es calcula les pulsacions per minut i es mostra la llista d’errades. 

```php
  <span>{{ round($vresults['pacum']*600/$vresults['t'],2) }} {{ __('edv.ppm')}} </span>
 
  <a href="/coffret/edv" class="btn btn-info float-left"> {{ __("edv.coffretbtn") }}</a>
  <a href="/skills/edv" class="btn btn-primary float-right"> {{ __("edv.skillbtn") }}</a>
  
  <h5> {{__('edv.wrongs') }} </h5>

  <ul>
    @foreach ($vresults['wrong'] as $wrong)
      <li class="list-group-item list-group-item-dark">
        {{$wrong[0]}}: {{$wrong[1]}}
      </li>
    @endforeach
  </ul>
```

### Analytics

Aquesta és la pàgina on es presenten les gràfiques de dades. Lavacharts permet imprimirles usant les plantilles Blade fent crida al mètode `render` de la classe `Lava`.

```php
 <h1> {{ __('edv.statistics') }} </h1>

     <div id="statistics"></div>
       {!! \Lava::render('LineChart', 'statistics', 'statistics') !!}
     </div>

   <div id="ppmnormal"></div>
     {!! \Lava::render('ColumnChart', 'ppmnormal', 'ppmnormal') !!}
   </div>
```

# Docker - entorn d’aplicació

Fins ara, l’entorn **Docker** ha estat orientat a l’entorn de desenvolupament, de manera que es necessitava l’accés de manera local al volum que conté l’aplicació web per accedir-hi amb l’editor que, en aquest cas, s’ha emprat **VSCode**, que integra l’edició de codi amb la gestió de versions **Git**, el terminal i altres utilitats; també que es tingués permisos d’edició al sistema d’arxius. Però per preparar la imatge que forma l’aplicació a un entorn d’ús o he producció, això ja no serà necessari. Tampoc s’hauran de fer moltes modificacions ja que l’entorn de desenvolupament ja està dissenyat per simular el millor possible l’entorn final.

A continuació es mostren les passes per poder habilitar l’aplicació que s’ha estat creant des dels repositoris de **Docker Hub**

## Creació d’un compte a Docker Hub
Des del portal hub.docker.com podem crear un compte que serà on es guarden les instàncies a imatges que haguem creat; contretament a https://hub.docker.com/signup 

![Docker Sign-in][docker-signin]

El compte bàsic ens permet pujar imatges públiques i un sol repositori privat, per ampliar el nombre de repositòris privats s’ha d’ampliar la capacitat de la compta (i pagar-ho). Però com el propòsit d’aquesta aplicació serà d’ús obert, no necessitem cap ampliació.

En els passos següents es veurà com es munten i publiquen les imatges: s’han preparat dues:
* **edv-web** conté l’aplicació Laravel i els serveis php i web
* **edv-db** és una instància a una imatge MariaDB que s’inicia amb un script SQL per crear l’estat inicial: crear la base de dades, les taules que es van generar amb la migració, i els primers valors necessaris per definir la primera Skill, la configuració per defecte, i l’usuari Guest.

![Docker Repository][docker-repo]

## Repositoris
Primer s’ha creat un arxiu Dockerfile que recull les necessitats incloses a l’entorn de desenvolupament i afegint el volum de la configuració d’**Apache** tal com hem preparat, més el contingut de l’aplicació web a la ruta **/var/www/html** al contenidor. Bàsicament, hem estat treballant amb una imatge original de php separant en volums els directoris a treballar, i ara estem creant una imatge que ja incorpora aquests canvis.

### Dockerfile: edv-web

```dockerfile
FROM php:apache
MAINTAINER "Andreu Bió" <info.andreubio@gmail.com>
RUN  docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
RUN  docker-php-ext-install bcmath
RUN  a2enmod rewrite
RUN  a2enmod ssl
COPY --chown=www-data:www-data ./apache2_files /etc/apache2
COPY --chown=www-data:www-data ./edv /var/www/html
EXPOSE 443
```

### Dockerfile: edv-db

```dockerfile
FROM mariadb:latest
COPY init.sql docker-entrypoint-initdb.d/
```

### Muntatge
L’arxiu **Dockerfile** es troba a l’arrel del projecte per poder capturar els directoris on s’han muntat els volums de configuració d’**Apache** i de contingut web; no es podria resoldre la imatge si es troba a un directori i realitzar la copia usant `../apache2_files` ja que les ordres del **Dockerfile** han de mantenir-se dins el mateix contexte.

Amb la següent instrucció es munta la imatge a partir del **Dockerfile** del context arrel i se’l etiqueta amb el nom **edv-web:beta** per identificar-ho posteriorment:

```shell
:$ docker build . -t edv-web:beta
Sending build context to Docker daemon    173MB
Step 1/7 : FROM php:apache
---> efa3c1e7a53f
Step 2/7 : RUN  docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
---> Using cache
---> 03ec5a896824
Step 3/7 : RUN  docker-php-ext-install bcmath
---> Using cache
---> 235399697a08
Step 4/7 : RUN  a2enmod ssl
---> Using cache
---> a189e813bb67
Step 5/7 : COPY --chown=www-data:www-data ./apache2_files /etc/apache2
---> 769a0aecd752
Step 6/7 : COPY --chown=www-data:www-data ./edv /var/www/html
---> 5b84fa881fc5
Step 7/7 : EXPOSE 443
---> Running in 7280b747b532
Removing intermediate container 7280b747b532
---> 1d9744ab1837
Successfully built 1d9744ab1837
Successfully tagged edv-web:beta
```

Podem comprovar que s’ha creat correctament llistant la llibreria local d’imatges Docker i comprovar que l’identificador `1d9744ab1837` coincideix:

```shell
:$ docker image ls
REPOSITORY          TAG                 IMAGE ID            CREATED             SIZE
edv-web             beta                1d9744ab1837        2 minutes ago       519MB
pfc_edv-database    latest              2f12b6e8f7f8        14 minutes ago      349MB
pfc_edv-web         latest              c67c783083e7        26 minutes ago      519MB
php                 apache              efa3c1e7a53f        17 hours ago        378MB
mariadb             latest              56089178535f        8 days ago          349MB
```

Per crear la imatge que inicia la base de dades seguim el mateix procediment, la diferència és que s’ha col·locat el **Dockerfile** corresponent a aquesta imatge a un directori **mariadb** on hi ha l’script SQL; com aquest és l’únic arxiu a copiar i es troba dins el seu context, no hi ha problema

```shell
:$ docker build ./mariadb -t edv-db:beta
Sending build context to Docker daemon  10.24kB
Step 1/2 : FROM mariadb:latest
---> 56089178535f
Step 2/2 : COPY init.sql docker-entrypoint-initdb.d/
---> 75c31ee71a1b
Successfully built 75c31ee71a1b
Successfully tagged edv-db:beta
```

### Publicació
Primer hem d’autenticar a l’entorn **Docker** amb el compte que hem creat a **Docker Hub**. Els credencials queden registrats en un codi encriptat a un arxiu JSON guardat al nostre directori local.

```shell
:$ docker login
Login with your Docker ID to push and pull images from Docker Hub. If you don't have a Docker ID, head over to https://hub.docker.com to create one.
Username: infoabio
Password:
WARNING! Your password will be stored unencrypted in /home/ariany/.docker/config.json.
Configure a credential helper to remove this warning. See
https://docs.docker.com/engine/reference/commandline/login/#credentials-store

Login Succeeded
```

Un cop identificats, s’assigna amb l’ordre docker tag una etiqueta a la imatge que declara la direcció del repositori remot que hem creat, i amb l’ordre docker push la imatge es carrega al repositori:

```shell
:$ docker tag edv-web:beta infoabio/edv-web:beta
:$ docker push infoabio/edv-web:beta
The push refers to repository [docker.io/infoabio/edv-web]
c9ca2830d091: Pushed
99a548584182: Pushed
901f45071218: Pushed
934ae500153f: Pushed
22995779ba1f: Pushed
6fa86a6932c8: Layer already exists
5e40cd10b5d0: Layer already exists
d34bea688cc8: Layer already exists
81f1c6fa1e95: Layer already exists
c2346c659df7: Layer already exists
2b7b9c6931ec: Layer already exists
0bd858268038: Layer already exists
00bdf648ad3c: Layer already exists
778c22283a6d: Layer already exists
0318b3b010ef: Layer already exists
d7b30b215a88: Layer already exists
9717e52dd7bd: Layer already exists
cf5b3c6798f7: Layer already exists
beta: digest: sha256:ea4be1afaeda870cfda0a08a11d2fe24bc7df402d1f856351b2aa37d4f50dd63 size: 4082

:$ docker tag edv-db:beta infoabio/edv-db:beta
:$ docker push infoabio/edv-db:beta
The push refers to repository [docker.io/infoabio/edv-db]
ebcbbb44d007: Pushed
c7a487306f02: Mounted from library/mariadb
391301aefa5b: Mounted from library/mariadb
c19170557862: Mounted from library/mariadb
86c9ea2c9fa4: Mounted from library/mariadb
cc464e173b96: Mounted from library/mariadb
ff763fe66f4b: Mounted from library/mariadb
6c5c7d6846be: Mounted from library/mariadb
466fae997be1: Mounted from library/mariadb
6cdee6a0a989: Mounted from library/mariadb
60599e4a285c: Mounted from library/mariadb
8d267010480f: Mounted from library/mariadb
270f934787ed: Mounted from library/mariadb
02571d034293: Mounted from library/mariadb
beta: digest: sha256:84d7433250dad09220c5178abe784c13186eb91b1e2198c2d0c692d877432458 size: 3240
```

Es pot apreciar que no es carrega tota la imatge resultant, sinó que les instàncies que s’han carregat són només les que suposen un valor addicional a partir de les imatges originàries de **php:apache** o **mariadb:latest**: els resultats de les ordres `RUN`, `COPY`, etc. que s’han afegit.

## Activar l’aplicació

L’objectiu final de l’ús dels contenidors és poder encapsular tots els paquets necessaris per tal que qualsevol màquina pugui executar-ho. Actualment, els serveis d'infraestructura com **Google Cloud**, **Amazon Web Service** o **Azure**, compten amb les eines per descarregar i executar contenidors, de manera que amb pocs passos es pot tenir l’aplicació funcionant dins aquests serveis; a més, les actualitzacions que es poden emetre al repositori, es poden replicar allà on estiguin funcionant. 

Partint d’una màquina amb l’entorn **Docker**, es pot posar en marxa a partir del **docker-compose.yml**:

```yml
version: '3.3'
networks:
 edv-net:

services:
 edv-database:
   image: infoabio/edv-web:beta
   container_name: edv-db
   volumes:
     - ./db_data:/var/lib/mysql
   restart: always
   networks:
     edv-net:
       aliases:
         - edv-db
   env_file:
     - edv.env

 edv-web:
   image: infoabio/edv-web:beta
   container_name: edv-web
   depends_on:
     - "edv-database"
   networks:
     - edv-net
   ports:
     - "80:80"
     - "443:443"
   links:
     - edv-database
   restart: always
```

És molt similar al que hem fet servir a l'entorn de desenvolupament, però la imatge del * servei *edv-web* és la que s’obté del repositori creat que ja inclou tot el paquet **Laravel** i la configuració **Apache**.

S’ha de tenir en compte que el primer cop que s’activa l’aplicació, cal incorporar a la base de dades els valors inicials que creen les taules i els valors per l’Skill, la configuració predeterminada i l’usuari *Guest*. Això es pot fer de dues maneres:

* Utilitzar la imatge `mariadb:latest` i executar directament l’script d’inici dins el contenidor **edv-db**, que es pot fer amb l’ordre: `$docker exec -i edv-db /usr/bin/mysql -u root --password=contrasenya edv < init.sql`
* Utilitzar la imatge de base de dades del repositori que ja inclou l’script: `infoabio/edv-web:beta`

## Còpies de seguretat
Com l’estructura de l’aplicació ja ve encapsulada al contenidor, l’únic del que es necessita realitzar còpies de seguretat és de la base de dades. Si bé tenim el volum de la base de dades definit a fora, aquest no és l’objectiu a salvar; realment la còpia es pot realitzar amb una sola ordre que genera l’arxiu SQL on hi ha les dades de les taules i continguts:

```shell
:$ docker exec edv-db /usr/bin/mysqldump -u root --password=contrasenya edv > nom-backup.sql
```

De la mateixa manera, per recuperar les dades d’una còpia feta, es pot executar:
```shell
:$ docker exec -i edv-db /usr/bin/mysql -u root --password=contrasenya edv < nom-backup.sql
```

Es pot crear un script que faci la còpia de seguretat i programar-la periòdicament amb **Cron**:

```bash
#!/bin/bash
backups_dir="./db_backup/"
datetime=$(date +'%Y-%m-%dT%H:%M:%S')

docker exec edv-db /usr/bin/mysqldump -u root --password=contrasenya edv | gzip -9 > $backups_dir$db_name--$datetime.sql.gz
```

S’han de donar permisos d’execució a l’script i incloure’l al **Crontab**, amb l’ordre `sudo crontab -e` s’obre amb un editor de text l’arxiu de configuració de tasques programades i al que s’ha d’incloure la línia seguint el format: 
**minuts** (0-59) **hora** (0-23) **dia del mes** (1-31) **mes** (1-12) **dia de la setmana** (0-7) **comande** 

Per exemple, si volem que es repeteixi diàriament a les 05:00:

```shell
#  m    h    dom    mon    dow    command
   0    5     *      *      *     bash /ruta/del/backup.sh
```

## Requisits del sistema
Hi ha només dos factors a l’hora de veure els requisits mínims: els necessaris per **Docker** i per executar PHP -que encara que estigui encapsulat a un contenidor, els recursos els disposa el sistema-.

Requisits per **Docker**: Debian/Raspian Stretch (stable)
Soporta arquitectures x86_64 (or amd64), armhf, i arm64;

Com necessitat heredada de **Debian** Stretch:
* RAM mínima: 128 megabytes
* RAM recomendable: 512 megabytes
* Espai de disc: 2 gigabytes

Els recursos necessaris per executar PHP es troben molt per davall dels anteriors, per tant els requisits del sistema **Docker** són els indispensables per l’execució de l’aplicació.

# Notes finals

En aquest treball de final de cicle hi ha la convergència de diferents objectius personals:

Per una part, la més formal i acadèmica, mostrar diferents habilitats apreses durant el curs, i la capacitat d’afrontar nous reptes que, al cap i a la fi, és una condició constant en el món informàtic; per això, al marge de l’ús de serveis d’aplicació, servei web, ús de repositòris, etc., he ampliat amb elements nous als que m’he hagut d’adaptar en aquests tres mesos.

També he volgut aprofitar el projecte per conèixer el framework de **Laravel**, el qual m’ha duit uns quants entrebancs, però que només per això ha estat interessant. Es va plantejar l’opció d’utilitzar una base de dades NoSQL com **MongoDB**, però després de veure la naturalesa del seu ús durant les pràctiques d’empresa vaig decidir que no era el projecte adequat i que una base de dades relacional resulta més adequada.

Desde principi d’aquest curs, hem vaig interessar pel mapa de teclat, la seva història i detalls tècnics, i vaig decidir aprendre el mapa Dvorak i que actualment faig servir ja de manera cotidiana (de fet, usar el QUERTY hem resulta un esforç). Ho vaig comentar al grup TIC de l’escola del meu fill del que formo part des de fa alguns anys, i va sorgir la proposta d’usar una aplicació d’aprenentatge mecanogràfic. Per tant, a més d’un interés personal, també hi ha l’intenció d’aplicar-ho el curs vinent a l’escola, ja sigui amb una màquina de la seva xarxa interna, o a través d’un servei IAS com pot ser AWS.

I l’objectiu final és que aquesta aplicació no quedi aturada amb el compliment del projecte acadèmic, que si és per hores dedicades puc assegurar que estan molt més que cobertes, sinó que es mantengui en desenvolupament per complir l’objectiu de cara a l’inici del proper curs ser una aplicació funcional i extensible.

Un descobriment addicional durant l’elaboració d’aquest treball ha estat comprovar que la intenció de mantenir una documentació suficientment clara, molts cops implica al moment de donar una explicació adonar-se’n de falles estructurals que necessiten correcció; a vegades, correccions que suposen dies de treball. Passa anvant, passa enrrera.

Si bé és cert que l’estat actual de l’**Entrenador Dvorak** està encara en fase de desenvolupament i té diverses mancances -sobretot estètiques- he fet el possible perquè mostri la seva capacitat funcional bàsica i estigui d’acord amb una estructura modular i ampliable.

Tot el material referent al codi (variables, comentaris,...) s’han escrit principalment en anglès, ja que essent que el projecte pretén ser escalable i de codi lliure, l’ús de l’anglès obre la porta a la col·laboració a través del Git.

Aquesta documentació es mantindrà pública, actualitzant la versió Markdown junt amb el projecte al Git: https://github.com/2aven/edv 


[ER-mod]: img/ER_1.png "Entitat-Relació Model"
[ER-mod-atrib]: img/ER_0.png "Entitat-Relació Model-Atributs"
[ER-mod-norm]: img/ER_2.png "Entitat-Relació Normalització"
[Distrib-sigma]: img/500px-Empirical_rule_histogram.svg.png "Distribució normal - Sigma"
[docker-signin]: img/Screen-01.png "Docker Sign-in"
[docker-repo]: img/Screen-02.png "Docker Repository"