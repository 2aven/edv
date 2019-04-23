
  -- userID          ->  user, nom, alies, email, passwd ...
  -- skillID         ->  nom, directori, autor, ...
  -- dadesID         ->  vector-dades
  -- userID, skillID ->  vector-config
  -- codSesio, userID,
  --   skillID,dadesID   ->  tinici, tfinal, (verificació?)  

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
  pag     tinytext not null,
  imatge  tinytext not null
);

create or replace table dades (
  dadesID bigint unsigned not null auto_increment primary key,
  dades   longtext not null
);

create or replace table configura (
  userID  bigint unsigned not null,
  skillID bigint unsigned not null,
  foreign key (userID)  references usuari(userID),
  foreign key (skillID) references skill(skillID)
  
);

create or replace table sessio (
  sessioID  bigint unsigned not null auto_increment primary key,
  userID    bigint unsigned not null,
  skillID   bigint unsigned not null,
  dadesID   bigint unsigned not null,
  foreign key (userID)  references usuari(userID),
  foreign key (skillID) references skill(skillID),
  foreign key (dadesID) references dades(dadesID)
  
);



