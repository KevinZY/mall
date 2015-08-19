<?php
define('ACC', true);
/***
 * 所有由用户直接访问到的这些页面
 * 都得现加载init.php
 */

require './include/init.php';


session_start();

$goods = new GoodsModel();
$newList = $goods->getNew();
//print_r($newList);
//print_r($goods->getGoodsByCat(1));
$appleList = $goods->getGoodsByCat(1);
$samsungList = $goods->getGoodsByCat(2);
include(ROOT. 'view/front/index.html');