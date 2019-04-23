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
