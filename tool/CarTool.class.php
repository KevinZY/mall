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
     * @param $shop_price
     * @param $market_price
     * @param $goods_img
     * @param int $num
     */
    public function addItem($id, $name, $shop_price, $market_price, $goods_img, $num=1){
        if($this->hasItem($id)){
            $this->incNum($id, $num);
            return;
        }
        $this->items[$id] = array();
        $this->items[$id]['name'] = $name;
        $this->items[$id]['market_price'] = $market_price;
        $this->items[$id]['shop_price'] = $shop_price;
        $this->items[$id]['goods_img'] = $goods_img;
        $this->items[$id]['num'] = $num;
    }

    /**
     * 清空购物车
     */
    public function clear(){
        $this->items = array();
    }

    /**
     * 判断有无商品
     * @param $id
     * @return bool
     */
    public function hasItem($id){
        return array_key_exists($id, $this->items);
    }

    /**
     * 修改商品数量
     * @param $id
     * @param int $num
     * @return bool
     */
    public function modNum($id, $num=1){
        if(!$this->hasItem($id)){
            return false;
        }
        $this->items[$id]['num'] = $num;
    }

    /**
     * 删除商品
     * @param $id
     */
    public function delItem($id){
        unset($this->items[$id]);
    }

    /**
     * 商品种类数量
     * @return int
     */
    public function getCnt(){
        return count($this->items);
    }

    /**
     * 获取商品总数
     * @return int
     */
    public function getNum(){
        if($this->getCnt() == 0){
            return 0;
        }
        $total = 0;
        foreach($this->items as $item){
            $total += $item['num'];
        }
        return $total;
    }

    public function getShopPrice(){
        if($this->getCnt() == 0){
            return 0;
        }
        $shop_price = 0.0;
        foreach($this->items as $item){
            $shop_price += $item['num'] * $item['shop_price'];
        }
        return $shop_price;
    }

    public function getMarketPrice(){
        if($this->getCnt() == 0){
            return 0;
        }
        $market_price = 0.0;
        foreach($this->items as $item){
            $market_price += $item['num'] * $item['market_price'];
        }
        return $market_price;
    }

    /**
     * 数量加1
     * @param $id
     * @param int $num
     */
    public function incNum($id, $num=1){
        if($this->hasItem($id)){
            $this->items[$id]['num'] += $num;
        }
    }

    /**
     * 数量减1
     * @param $id
     * @param $num
     */
    public function decNum($id, $num){
        if($this->hasItem($id)){
            $this->items[$id]['num'] -= $num;
            if($this->items[$id]['num'] <= 0){
                $this->delItem($id);
            }
        }
    }

    /**
     * 返回所有商品
     */
    public function getAll(){
        return $this->items;
    }
}

//function test(){
//    session_start();
//    //print_r(CarTool::getCar());
//    $car = CarTool::getCar();
//    $car->addItem(1, '王八', 25);
//    print_r(CarTool::getCar());
//    $car->addItem(2, '乌龟', 50, 3);
//    print_r($car->getAll());
//    echo '<br />';
//    echo $car->getCnt() . '<br />';
//    echo $car->getNum() . '<br />';
//    echo $car->getPrice() . '<br />';
//}
//
//test();