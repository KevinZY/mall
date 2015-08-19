<?php
define('ACC', true);
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/8/19 0019
 * Time: 16:25
 */

require './include/init.php';

session_start();

$cat = new CatModel();
$catList = $cat->getList();
$catList = $cat->getListTree($catList, 0);

$goods = new GoodsModel();
if(isset($_GET['cat_id'])){
    $goodsList = $goods->getGoodsByCat($_GET['cat_id']);
    $catFamily = $cat->getFamilyTree($_GET['cat_id']);
    $catFamily = array_reverse($catFamily);
}else{
    $goodsList = $goods->getGoodsByCat(0);
}

include(ROOT. 'view/front/lanmu.html');