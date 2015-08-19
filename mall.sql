-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-08-19 05:05:14
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mall`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL DEFAULT '',
  `intro` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `intro`, `parent_id`) VALUES
(1, 'Apple', '', 0),
(2, 'Samsung', '', 0),
(3, 'iPhone', '', 1),
(4, 'iPad', '', 1),
(5, 'Galaxy系列', '', 2),
(6, 'Note系列', '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_sn` char(15) NOT NULL DEFAULT '',
  `cat_id` smallint(6) NOT NULL DEFAULT '0',
  `goods_name` varchar(30) NOT NULL DEFAULT '',
  `shop_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `market_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(6) NOT NULL DEFAULT '1',
  `click_count` mediumint(9) NOT NULL DEFAULT '0',
  `goods_weight` decimal(6,3) NOT NULL DEFAULT '0.000',
  `goods_brief` varchar(100) NOT NULL DEFAULT '',
  `goods_desc` text NOT NULL,
  `thumb_img` varchar(100) NOT NULL DEFAULT '',
  `goods_img` varchar(100) NOT NULL DEFAULT '',
  `ori_img` varchar(100) NOT NULL DEFAULT '',
  `is_on_sale` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`goods_id`, `goods_sn`, `cat_id`, `goods_name`, `shop_price`, `market_price`, `goods_number`, `click_count`, `goods_weight`, `goods_brief`, `goods_desc`, `thumb_img`, `goods_img`, `ori_img`, `is_on_sale`, `is_delete`, `is_best`, `is_new`, `is_hot`, `add_time`, `last_update`) VALUES
(1, 'sn2015081972171', 3, 'iPhone 5s', '3566.00', '3899.00', 2000, 0, '0.256', '', 'iPhone 5s', 'data/images/1508/19/thumb_kt0hnj.jpg', 'data/images/1508/19/goods_kt0hnj.jpg', 'data/images/1508/19/kt0hnj.jpg', 1, 0, 1, 0, 1, 1439953084, 0),
(2, 'sn2015081923093', 3, 'iPhone 6', '4899.00', '4999.00', 3265, 0, '0.289', '', 'iPhone 6', 'data/images/1508/19/thumb_6raq4s.jpg', 'data/images/1508/19/goods_6raq4s.jpg', 'data/images/1508/19/6raq4s.jpg', 1, 0, 1, 1, 1, 1439953238, 0),
(3, 'sn2015081949683', 5, 'Galaxy s6', '5899.00', '5999.00', 1026, 0, '0.302', '', 'Galaxy s6', 'data/images/1508/19/thumb_v86ydo.jpg', 'data/images/1508/19/goods_v86ydo.jpg', 'data/images/1508/19/v86ydo.jpg', 1, 0, 1, 1, 1, 1439953289, 0),
(4, 'sn2015081991794', 4, 'iPad Air 2', '3289.00', '3588.00', 2065, 0, '0.645', '', 'iPad Air 2', 'data/images/1508/19/thumb_yw807k.jpg', 'data/images/1508/19/goods_yw807k.jpg', 'data/images/1508/19/yw807k.jpg', 1, 0, 1, 1, 1, 1439953335, 0),
(5, 'sn2015081968868', 6, 'Galaxy Note 5', '5689.00', '5888.00', 3056, 0, '0.326', '', 'Galaxy Note 5', 'data/images/1508/19/thumb_sxjpmu.jpg', 'data/images/1508/19/goods_sxjpmu.jpg', 'data/images/1508/19/sxjpmu.jpg', 1, 0, 1, 1, 1, 1439953379, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(30) NOT NULL DEFAULT '',
  `passwd` char(32) NOT NULL DEFAULT '',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `passwd`, `regtime`, `lastlogin`) VALUES
(1, 'Kevin_KK', 'zy1123581321@qq.com', '8a2bda6192d217855ed4a37f63d4f5dd', 1439953482, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
