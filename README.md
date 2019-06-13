Entrenador Dvorak
===
Projecte Final de Cicle - ASIX
---
### Autor: Andreu Bió




#### Apache:
  ServerName dev.edv.net

#### /etc/hosts
127.0.0.1	localhost
127.0.0.1	dev.edv.net ca.dev.edv.net es.dev.edv.net en.dev.edv.net


#### Storage
El contingut es guarda a /storage/app/public, però necessita un enllaç simbòlic a /public. Això es pot crear amb l'ordre:
```console
$ php artisan storage:link
The [public/storage] directory has been linked.
```


#### config.blade.php
Model inicial tancat::
```php
@extends('layouts.app')
@section('content')

  <div class="text-center">
    {{ Form::open(['action' => 'SkillConfController@store']) }}
      <div class="form-group">
        <ul> @foreach ($vparam as $key => $options)
          <li>
            {{ Form::label("$key",__("$slug.$key")) }}
            {{ Form::select("$key",$options,$vconf[$key],['class' => 'form-control'])}}
          </li> @endforeach
        </ul>
      </div>
      {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@endsection
```
Al Tinker...
```php
>>> $skill->vparam='{"method":{"text":"text_method","word":"word_method","syl":"syllabic_method"},"lang":{"ca":"ca_lang","es":"es_lang","en":"en_lang"},"keymap":{"dv":"dv_keymap","querty":"querty_keymap"},"backspc":{"yes":"allow","no":"disallow"}}' 
=> "{"method":{"text":"text_method","word":"word_method","syl":"syllabic_method"},"lang":{"ca":"ca_lang","es":"es_lang","en":"en_lang"},"keymap":{"dv":"dv_keymap","querty":"querty_keymap"},"backspc":{"yes":"allow","no":"disallow"}}"
```
Necessita que la base de dades tingui un llistat de les opcions, però només utilitza 'select'. S'ha descartat per no limitar la confiugració a posibles skills posteriors.
Posterior canvi a model obert




## Creació dels cert. digitals
```console
root@bae23350d9e2:/etc/apache2/ssl# openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/ssl-cert-snakeoil.key -out /etc/apache2/ssl/ssl-cert-snakeoil.pem -subj "/C=ES/ST=Spain/L=Palma/O=eDv/OU=Development/CN=edv.net"
Generating a RSA private key
.........................................................+++++
..........................+++++
writing new private key to '/etc/apache2/ssl/ssl-cert-snakeoil.key'
-----
```

#### apache conf
```console 
root@bae23350d9e2:/etc/apache2/sites-enabled# cat edv-ssl.conf 
<IfModule mod_ssl.c>
	<VirtualHost *:443>
		ServerAdmin infoabio@gmail.com 

		DocumentRoot /var/www/html

		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined

		SSLEngine on
		SSLCertificateFile	/etc/apache2/ssl/ssl-cert-snakeoil.pem
		SSLCertificateKeyFile	/etc/apache2/ssl/ssl-cert-snakeoil.key
		#SSLCertificateChainFile /etc/apache2/ssl/ssl.crt

		#SSLOptions +FakeBasicAuth +ExportCertData +StrictRequire
		<FilesMatch "\.(cgi|shtml|phtml|php)$">
				SSLOptions +StdEnvVars
		</FilesMatch>
		<Directory /usr/lib/cgi-bin>
				SSLOptions +StdEnvVars
		</Directory>
	</VirtualHost>
</IfModule>
```
#### ln
```console
root@bae23350d9e2:/etc/apache2/sites-enabled# ln ../sites-available/edv-ssl.conf -s
root@bae23350d9e2:/etc/apache2/sites-enabled# ls -la
total 8
drwxr-xr-x 2 root root 4096 Jun 13 14:20 .
drwxr-xr-x 9 root root 4096 Jun 13 13:46 ..
lrwxrwxrwx 1 root root   35 Apr 14 17:21 000-default.conf -> ../sites-available/000-default.conf
lrwxrwxrwx 1 root root   31 Jun 13 14:20 edv-ssl.conf -> ../sites-available/edv-ssl.conf
```

#### .htaccess
```console
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_URI} !^public
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

## Docker login
:$ docker login
Login with your Docker ID to push and pull images from Docker Hub. If you don't have a Docker ID, head over to https://hub.docker.com to create one.
Username: infoabio
Password: 
WARNING! Your password will be stored unencrypted in /home/ariany/.docker/config.json.
Configure a credential helper to remove this warning. See
https://docs.docker.com/engine/reference/commandline/login/#credentials-store

Login Succeeded


ToAdd - List
===



ToDo - List
===
- [x] Documentació a .md
  - [ ] Install notes
- [ ] Docker - Producció
- [x] Docker - Dev
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
      - [x] Validar amb 'alpha_dash'
    - [x] Verificar unique username
  - [x] Incloure Login al Navbar
  - [ ] Dashboard
    - [ ] Info Bàsica
    - [ ] Coffrets
    - [x] Carregar Config a la sessió (Anonim/Guest té els valors per defecte a la DB)
  - [ ] Es manté la sessió entre canvis de idoma?

- [ ] About (presentació)

- [x] Skills
  - [x] Controlador
  - [x] Model DB
  - [x] Incorporar traducció
  - [x] Show returns view with -> config 
  - [x] Botons navegació (Estadístiques)

- [x] Config :: Model-Controlador
  - [x] Model DB
  - [x] Controlador: S'ha de filtrar per usuari (sessió)
  - [x] Obtenció dades config
  - [x] Formulari config -> Modifica les dades...
    - [x] GUEST: a la sessió 
    - [x] si té usuari, les guarda a la DB
    - [x] Inc. sigma
    - [x] paraules amb repetició
    - [x] backspace -> check

- [ ] Skill EDV
  - [ ] Pagina principal edv:
    - [x] correcció: SkillsController show  ==> edv.php
    - [ ] Modificar depenent de la configuració
      - [x] Idioma
      - [x] Sigma
      - [x] Repetició
      - [ ] Imatge del teclat en pantalla
      - [ ] Comportament Backspace
    - [ ] Test
    - [ ] Entrenament
      - [x] Comportament del torrent de paraules
      - [ ] Síl·labes
        - [ ] Obtenir llistat de síl·labes amb probabilitat ponderada
          - [ ] en 
          - [ ] es
          - [ ] ca 
      - [x] Paraules
        - [x] Obtenir llistat de paraules amb probabilitat ponderada
          - [x] en https://en.wiktionary.org/wiki/Wiktionary:Frequency_lists/PG/2006/04/1-10000
          - [x] es
          - [x] ca https://en.wiktionary.org/wiki/Wiktionary:Frequency_lists/Catalan
      - [ ] Text
  - [x] Captació dades dels tests
    - [x] coffert/store
  - [x] Obtenció dades usuari / anònimes <= Coffert
  - [x] analytics.blade.php
    - [x] Lavachart
      - [x] Progrés personal
      - [x] PPM/WPM dades totals
    - [x] Botons navegació (Accés a Coffrets)
    - [x] Traducció
  - [x] data.blade.php:
    - [x] Dades de la sessió
    - [x] Botons navegació (Accés a Coffrets)
    - [x] Traducció

- [x] Banc de dades
  - [x] Model: Coffert
  - [x] CoffertController
    - [x] Escritura 
    - [x] Lectura
  - [x] Migració a base de dades
  
- [ ] :Pendent
- [x] :Realitzat
