Entrenador Dvorak
===
Projecte Final de Cicle - ASIX
---
### Autor: Andreu Bió

Aplicació web plantejada per a l’aprenentatge o pràctica d’habilitats mentals i perceptives abordant diferents tècniques o metodologies, amb la finalitat d’obtenir dels usuaris una mostra estadísticament rellevant per poder realitzar un anàlisi fundat sobre quins mètodes (o combinació d’aquests) són més efectius, ràpids o eficients.

La documentació del projecte es troba a **docs**.

Per descarregar la versió BETA, descarrega **docker-compose.yml** a una carpeta local on es crearà el volum persistent *db_data*:

```shell
docker-compose up
```

Per obtenir l'aplicació en entorn de desenvolupament, descarrega **docker-compose-dev.yml**; es crearà el volum de base de dades *db_data*, el de configuració del servei **Apache** a *apache2_files* i el contingut de l'aplicació a *edv*:

```shell
docker-compose -f docker-compose-dev.yml up
```

Asigna la ruta de l'aplicació a l'arxiu de variables d'entorn **.env** del directòri arrel de l'aplicació, o adapta la redirecció de manea local incloent la linia a **/etc/hosts**:

```bash
127.0.0.1	dev.edv.net ca.dev.edv.net es.dev.edv.net en.dev.edv.net
```

Requisits:

* Entorn Docker i docker-compose


ToDo - List
===
- [ ] Traduir a anglès :)
- [x] Documentació a .md
  - [x] Install notes
- [x] Docker - Producció
  - [x] DockerHub
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
