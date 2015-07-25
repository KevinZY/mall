#category
create table category (
cat_id int auto_increment primary key,
cat_name varchar(20) not null default '',
intro varchar(100) not null default '',
parent_id int not null default 0
)engine myisam charset utf8;

#goods
create table if not exists goods(
goods_id int(10) unsigned not null auto_increment primary key,
goods_sn char(15) not null default '' unique key,
cat_id smallint(6) not null default 0,
goods_name varchar(30) not null default '',
shop_price decimal(9,2) not null default 0.00,
market_price decimal(9,2) not null default 0.00,
goods_number smallint(6) not null default 1,
click_count mediumint(9) not null default 0,
goods_weight decimal(6,3) not null default 0.000,
goods_brief varchar(100) not null default '',
goods_desc text not null,
thumb_img varchar(100) not null default '',
goods_img varchar(100) not null default '',
ori_img varchar(100) not null default '',
is_on_sale tinyint(4) not null default 1,
is_delete tinyint(4) not null default 0,
is_best tinyint(4) not null default 0,
is_new tinyint(4) not null default 0,
is_hot tinyint(4) not null default 0,
add_time int(10) unsigned not null default 0,
last_update int(10) unsigned not null default 0
)engine=myisam default charset=utf8;