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
            if($g['is_delete'] == 1 || $g['is_on_sale'] == 0){
                $msg = '此商品以下架，不能购买！';
                include(ROOT . 'view/front/msg.html');
            }
            $car->addItem($goods_id, $g['goods_name'], $g['shop_price'],$g['market_price'], $g['goods_img'], $num);
        }
//        print_r($car->getAll());
        $allItems = $car->getAll();
        if(empty($allItems)){
            header('location:index.php');
            exit;
        }
        $shop_total = $car->getShopPrice();
        $market_total = $car->getMarketPrice();
        $save = $market_total - $shop_total;
        $percent = number_format(($save*100.0)/$market_total, 2);
        include(ROOT . '/view/front/jiesuan.html');
    }
}