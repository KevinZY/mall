<?php
defined('ACC') || exit('Access Denied');
/***
 * file CatModel.class.php
 * 目录Model
 * @author zhangyang
 */

class CatModel extends Model{
    protected $table = 'category';
    protected $pk = 'cat_id';

    /**
     * 查子栏目
     */
    public function getSon($id){
    	$sql = 'select cat_id,cat_name,parent_id from ' . $this->table . ' where parent_id=' . $id;
    	return $this->db->getAll($sql);
    }

    /**
     * 从数据库读出数据
     */
    public function getList(){
    	$sql = 'select cat_id,cat_name,parent_id from ' . $this->table;
    	return $this->db->getAll($sql);
    }

    /**
     * 将数据库读出的数据进行格式化
     * return arrya
     */
    public function getListTree($arr , $id = 0 , $lev = 0){
    	$tree = array();
    	foreach ($arr as $v){
    		if($v['parent_id'] == $id){
    			$v['lev'] = $lev;
    			$tree[] = $v;
    			$tree = array_merge($tree , $this->getListTree($arr , $v['cat_id'] , $lev+1));
    		}
    	}
    	return $tree;
    }

    /**
     *查找$id栏目的家谱树
     */
    public function getFamilyTree($id){
    	$tree = array();
    	$cats = $this->getList();
    	while ($id>0){
    		foreach ($cats as $v){
    			if ($v['cat_id'] == $id){
    				$tree[] = $v;
    				$id = $v['parent_id'];
    				continue;
    			}
    		}
    	}
    	return $tree;
    }

}
?>