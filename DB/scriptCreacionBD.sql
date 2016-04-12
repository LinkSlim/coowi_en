/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     11/04/2016 12:34:55                          */
/*==============================================================*/


drop table if exists items;

drop table if exists items_tags;

drop table if exists jobs;

drop table if exists offers;

drop table if exists petitions;

drop table if exists rates;

drop table if exists roles;

drop table if exists studies;

drop table if exists tags;

drop table if exists users;

/*==============================================================*/
/* Table: items                                                 */
/*==============================================================*/
create table items
(
   id                   int not null auto_increment,
   petition_id          int not null,
   user_id              int not null,
   name                 varchar(100) not null,
   description          varchar(256),
   date                 date not null,
   state                varchar(100) not null default 'activado',
   primary key (id)
);

/*==============================================================*/
/* Table: items_tags                                            */
/*==============================================================*/
create table items_tags
(
   id                   int not null auto_increment,
   item_id              int not null,
   tag_id               int not null,
   primary key (id),
   unique key ak_unique_item_tag (item_id, tag_id)
);

/*==============================================================*/
/* Table: jobs                                                  */
/*==============================================================*/
create table jobs
(
   id                   int not null auto_increment,
   user_id              int not null,
   company              varchar(100) not null,
   start_date           date,
   ending_date          date,
   position             varchar(100),
   primary key (id)
);

/*==============================================================*/
/* Table: offers                                                */
/*==============================================================*/
create table offers
(
   id                   int not null auto_increment,
   item_id              int not null,
   user_id              int not null,
   price                decimal not null,
   date                 date not null,
   comment              varchar(256),
   state                varchar(100) not null default 'activado',
   primary key (id)
);

/*==============================================================*/
/* Table: petitions                                             */
/*==============================================================*/
create table petitions
(
   id                   int not null auto_increment,
   user_id              int not null,
   title                varchar(100) not null,
   description          varchar(256) not null,
   creation_date        date not null,
   shell_by_date        date not null,
   location             varchar(100) not null,
   budget               decimal(8,2),
   photo                varchar(500),
   state                varchar(100) not null default 'activado',
   primary key (id)
);

/*==============================================================*/
/* Table: rates                                                 */
/*==============================================================*/
create table rates
(
   id                   int not null auto_increment,
   user1_id             int not null,
   user2_id             int not null,
   comment              varchar(256) not null,
   rate                 dec(2,1) not null,
   date                 date not null,
   state                varchar(100) not null default 'activado',
   primary key (id)
);

/*==============================================================*/
/* Table: roles                                                 */
/*==============================================================*/
create table roles
(
   id                   int not null auto_increment,
   rol                  varchar(100) not null,
   primary key (id),
   unique key ak_unique_rol (rol)
);

/*==============================================================*/
/* Table: studies                                               */
/*==============================================================*/
create table studies
(
   id                   int not null auto_increment,
   user_id              int not null,
   center               varchar(100),
   degree               varchar(100),
   start_date           date,
   ending_date          date,
   primary key (id)
);

/*==============================================================*/
/* Table: tags                                                  */
/*==============================================================*/
create table tags
(
   id                   int not null auto_increment,
   name                 varchar(100) not null,
   date                 date not null,
   state                varchar(100) not null default 'activado',
   primary key (id),
   unique key ak_unique_name (name)
);

/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   id                   int not null auto_increment,
   rol_id               int not null,
   nif                  varchar(9) not null,
   email                varchar(100) not null,
   password             varchar(100) not null,
   name                 varchar(100) not null,
   subname              varchar(100) not null,
   phone                varchar(100) not null,
   location             varchar(100) not null,
   postal_code          varchar(5) not null,
   photo                varchar(500),
   date                 date not null,
   state                varchar(100) not null default 'activado',
   primary key (id),
   unique key ak_unique_nif (nif),
   unique key ak_unique_email (email)
);

alter table items add constraint fk_is_composed foreign key (petition_id)
      references petitions (id) on delete restrict on update restrict;

alter table items add constraint fk_suggests foreign key (user_id)
      references users (id) on delete restrict on update restrict;

alter table items_tags add constraint fk_identifies foreign key (item_id)
      references items (id) on delete restrict on update restrict;

alter table items_tags add constraint fk_identifies2 foreign key (tag_id)
      references tags (id) on delete restrict on update restrict;

alter table jobs add constraint fk_works foreign key (user_id)
      references users (id) on delete restrict on update restrict;

alter table offers add constraint fk_contiene2 foreign key (item_id)
      references items (id) on delete restrict on update restrict;

alter table offers add constraint fk_offers foreign key (user_id)
      references users (id) on delete restrict on update restrict;

alter table petitions add constraint fk_makes foreign key (user_id)
      references users (id) on delete restrict on update restrict;

alter table rates add constraint fk_rates foreign key (user1_id)
      references users (id) on delete restrict on update restrict;

alter table rates add constraint fk_rates2 foreign key (user2_id)
      references users (id) on delete restrict on update restrict;

alter table studies add constraint fk_studies foreign key (user_id)
      references users (id) on delete restrict on update restrict;

alter table users add constraint fk_defines foreign key (rol_id)
      references roles (id) on delete restrict on update restrict;

