<?php
define('ACC', true);
require('./include/init.php');
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/9/8/0008
 * Time: 21:28
 */

$act = isset($_GET['act']) ? $_GET['act'] : 'buy';
$goods = new GoodsModel();

$car = CarTool::getCar();
if($act == 'buy'){
    //添加商品到购物车
    $goods_id = isset($_GET['goods_id']) ? $_GET['goods_id']+0 : 0;
    $num = isset($_GET['num']) ? $_GET['num']+0 : 1;
    if($goods_id){
        $g = $goods->find($goods_id);
        if(!empty($g)){
            $car->addItem($goods_id, $g['goods_name'], $g['shop_price'], $num);
        }
//        print_r($car->getAll());
        $allItems = $car->getAll();
        include(ROOT . '/view/front/jiesuan.html');
    }
}