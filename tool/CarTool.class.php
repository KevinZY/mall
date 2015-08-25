<?php
/**
 * 购物车 session+单例
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/8/25 0025
 * Time: 15:01
 */

/*
 * 1.刷新页面、怎加商品，最后打开购物车时应是一样的效果 ==> 全局有效
 * 数据库、session解决
 * 2.购物车单例模式
 *
 * 添加、删除、修改数量
 * 查询都无车的商品种类、数量、商品总金额
 * 某商品数量+—1
 * 返回所有商品
 * 清空购物车
 */

/**
 * Class CarTool
 * 需要session_start()
 */
class CarTool{
    private static $ins = null;
    private $items = array();


    final protected function __construct(){
    }
    final protected function __clone(){
    }

    protected static function getIns(){
        if(self::$ins == null){
            self::$ins = new self();
        }
        return self::$ins;
    }

    //单例对象放入session
    public static function getCar(){
        if(!isset($_SESSION['car']) || !($_SESSION['car'] instanceof self)) {
            $_SESSION['car'] = self::getIns();
        }
        return $_SESSION['car'];
    }

    /**
     * 添加商品
     * @param $id
     * @param $name
     * @param $price
     * @param int $num
     */
    public function addItem($id, $name, $price, $num=1){
        $this->items[$id] = array();
        $this->items[$id]['name'] = $name;
        $this->items[$id]['price'] = $price;
        $this->items[$id]['num'] = $num;
    }

    /**
     * 清空购物车
     */
    public function clear(){
        $this->items = array();
    }
}

//TODO:从清空购物车开始
function test(){
    session_start();
//    print_r(CarTool::getCar());
    $car = CarTool::getCar();
    $car->addItem(1, '王八', 25);
    print_r($car);
}

test();