<?php
defined('ACC') || exit('Access Denied');
/***
 * file GoodsModel.class.php
 * 商品类Model
 * @author zhangyang
 */

class GoodsModel extends Model{
	protected $table = 'goods';
	protected $pk = 'goods_id';
	protected $field = array(
			'goods_id','goods_sn','cat_id','brand_id','goods_name','shop_price',
			'market_price','goods_number','click_count','goods_weight','goods_brief',
			'goods_desc','thumb_img','goods_img','ori_img','is_on_sale','is_delete',
			'is_best','is_new','is_hot','add_time','last_update');
	protected $_auto = array(
			array('is_hot' , 'value' , 0),
			array('is_new' , 'value' , 0),
			array('is_best' , 'value' , 0),
			array('add_time' , 'function' , 'time')
	);
	protected $_valid = array(
			array('goods_name', 1 , '商品名不能为空' , 'require'),
			array('cat_id', 1 , 'cat_id必须是整型值' , 'number'),
			array('shop_price', 1 , '价格必须是数值' , 'number'),
			array('market_price', 1 , '价格必须是数值' , 'number'),
			array('is_new', 0 , 'is_new只能是0或1' , 'in' , '0,1'),
			array('is_hot', 0 , 'is_hot只能是0或1' , 'in' , '0,1'),
			array('is_best', 0 , 'is_best只能是0或1' , 'in' , '0,1'),
			array('goods_brief', 2 , '商品简介应在10到100字' , 'length' , '10,100')
	);

	/**
	 * 获取数据显示列表
	 */
	public function getList(){
		$sql = 'select * from ' . $this->table . ' where is_delete=0';
		return $this->db->getAll($sql);
	}

	/**
	 * 取出单个商品信息
	 * @param $goods_id
	 * @return array
	 */
	public function getOne($goods_id){
		$sql = 'select * from ' . $this->table . ' where goods_id=' . $goods_id;
		return $this->db->getRow($sql);
	}

	/**
	 * 获取已被删除的数据
	 */
	public function getDelete(){
		$sql = 'select * from ' . $this->table . ' where is_delete=1';
		return $this->db->getAll($sql);
	}

	/**
	 * 执行删除操作
	 */
	public function doDelete($id){
		return $this->update(array('is_delete'=>1,'is_on_sale'=>0), $id);
	}

	public function createSn(){
		$sn = 'sn' . date('Ymd') . mt_rand(10000,99999);

		$sql = 'select count(*) from ' . $this->table . "where goods_sn='" . $sn . "'";

		return $this->db->getOne($sql) ? $this->createSn() : $sn;
	}

	/**
	 * 获取新品
	 * @param int $n 查询个数
	 * @return array
	 */
	public function getNew($n=5){
		$sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img from ' . $this->table .
			' where is_new=1 order by add_time limit ' . $n;
		return $this->db->getAll($sql);
	}

	/**
	 * 取出指定栏目的商品
	 * @param $cat_id
	 * @return array $sons
	 */
	public function getGoodsByCat($cat_id){
		$category = new CatModel();
		$cats = $category->getList();
		$sons = $category->getListTree($cats, $cat_id);

		$sub = array($cat_id);
		if(!empty($sons)){
			foreach($sons as $v){
				$sub[] = $v['cat_id'];
			}
		}
		$in = implode(',', $sub);
		$sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img from ' . $this->table .
			' where cat_id in (' . $in . ') order by add_time';
		return $this->db->getAll($sql);
	}
}