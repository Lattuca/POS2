create database POS2;

use POS2;

create table customers
(
  customerid int unsigned not null auto_increment primary key,
  name tinytext not null,
  address tinytext not null,
  city tinytext not null,
  state tinytext,
  zip char(10),
  country char(20) not null,
  last_update timestamp
);

create table orders
(
  orderid int unsigned not null auto_increment primary key,
  customerid int unsigned not null,
  amount float(6,2),
  date date not null,
  order_status char(10),
  last_update timestamp
);

create table products
(
   product_upc char(13) not null primary key,
   product_desc tinytext,
   quantity integer,
   price float(4,2) not null,
   cost float(4,2) not null,
   catid int unsigned,
   available boolean,
   product_notes longtext,
   last_update timestamp
);

create table categories
(
  catid int unsigned not null auto_increment primary key,
  catname char(60) not null,
  last_update timestamp
);

create table user  (
  username varchar(16) primary key,
  passwd char(40) not null,
  first tinytext,
  last tinytext,
  email varchar(100) not null,
  last_update timestamp
);

create table order_items
(
  orderid int unsigned not null,
  product_upc char(13) not null,
  item_price float(4,2) not null,
  quantity tinyint unsigned not null,
  primary key (orderid, product_upc)
);
