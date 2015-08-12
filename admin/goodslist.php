<?php
define('ACC', true);
require '../include/init.php';
/***
 * file goodslist.php
 * 商品列表显示控制器
 * @author zhangyang
 */

$goods = new GoodsModel();
$goodslist = $goods->getList();

include ROOT . 'view/admin/templates/goodslist.html';