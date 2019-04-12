-- we don't know how to generate schema rest (class Schema) :(
create table avatars
(
  id int auto_increment
    primary key,
  old_name text not null,
  new_path text not null,
  old_path text not null,
  flag int not null,
  new_name text not null
)
  engine=InnoDB
;

create table port
(
  id int auto_increment
    primary key,
  name int not null,
  count int not null,
  status int not null,
  last_update int not null
)
  engine=InnoDB charset=latin1
;

create table users
(
  id int auto_increment
    primary key,
  Date datetime not null,
  Login varchar(40) not null,
  Password varchar(40) not null,
  Phone varchar(15) null,
  ip varchar(40) null,
  Country varchar(20) not null,
  Sex int(1) not null,
  Age int(2) not null,
  Fullname varchar(50) null,
  Bio text null,
  Profilepicture varchar(20) null,
  Interrests int(3) null,
  Quality int(2) null,
  Status int(1) null,
  Mother int default '0' not null,
  is_sf text null,
  Postcount int(5) not null,
  Smsservice int(5) default '0' null,
  Lastpostdate int not null,
  Used int(1) default '0' null,
  Useddate int default '0' null
)
  engine=InnoDB
;
