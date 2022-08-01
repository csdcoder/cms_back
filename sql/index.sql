create database if not exists `cms`
default character set utf8;

-- ----------------------------
-- table structure for user
-- ----------------------------
drop table if exists `admin`;
create table `admin` (
  `id` tinyint(3) unsigned not null auto_increment,
  `username` varchar(20) not null default '' comment '姓名',
  `password` char(32) not null default '' comment 'md5()处理之后的单向密码',
  primary key (`id`)
) engine=innodb default charset=utf8;

insert into `admin` values(1,'admin',md5('123456'));
insert into `admin` values(2,'coderwhy',md5('123456'));


create table `userinfo` (
  `id` int unsigned not null auto_increment,
  `name` char(20) not null,
  `realname` char(20) not null,
  `cellphone` bigint(11) not null,
  `createAt` varchar(30) not null,
  `updataAt` varchar(30) not null,
  primary key (`id`)
) engine=innodb default charset=utf8;

insert into `userinfo` values(2,'coderwhy', "coderwhy", "18812345678", "2021-02-01", "2022-02-03" );

create table role (
  id int unsigned not null auto_increment,
  roleName char(20) not null,
  intro char(20) not null comment '权限情况介绍',
  createAt varchar(30) not null,
  updateAt varchar(30) not null,
  primary key (`id`)
) engine=innodb default charset=utf8;

insert into role values(2, '超级管理员', '所有权限', '2021-02-02', '2021-02-04');

create table department (
  id int unsigned not null auto_increment,
  departmentName char(20) not null,
  parentId int unsigned comment '上级部门id',
  createAt varchar(30) not null,
  updateAt varchar(30) not null,
  leader char(20),
  primary key (`id`)
) engine=innodb default charset=utf8;

insert into department values(2, '总裁办', null, '2021-02-02', '2021-02-04', 'kobe');