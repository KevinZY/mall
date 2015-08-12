<?php
defined('ACC') || exit('Access Denied');
/***
 * file Model.class.php
 * Model父类
 * @author zhangyang
 */

class Model{
	protected $table = NULL;
	protected $db = NULL;  //使用的数据库
	protected $pk = '';  //表的主键
	protected $field = array();  //保存表字段名
	protected $_auto = array();  //保存需要自动填充的表字段名
	protected $_valid = array();  //验证规则
	protected $error = array();  //报错信息
	
	public function __construct(){
		$this->db = MySql::getIns();
	}

	/**
	 * 自动过滤
	 * 把传来的数组
	 * 清除掉不用的单元
	 * 留下与表的字段对应的单元
	 * 表的字段可以自动分析，也可以手动写
	 * @param array $array
	 * @return array
	 */
	public function _facade($array = array()){
		$data = array();
		foreach ($array as $k=>$v){
			if (in_array($k, $this->field)){
				$data[$k] = $v;
			} //判断$k是否是表的字段
		}
		return $data;
	}

	/**
	 * 自动填充
	 * 表中需要但是POST没有传的
	 * @param $data
	 * @return
	 */
	public function _autoFill($data){
		foreach ($this->_auto as $v){
			if (!array_key_exists($v[0] , $data)){
				switch ($v[1]) {
					case 'value':
						$data[$v[0]] = $v[2];
						break;
					
					case 'function':
						$data[$v[0]] = call_user_func($v[2]);
						break;
				}
			}
		}
		return $data;
	}

	/**
	 * 自动验证
     * 1. 没有，不检；有，必是几个选项之一
     * 2. 必检字段
     * 3. 如有且内容不为空，则检查
	 *
     * 格式 $this->_valid = array(
	 *        array('验证的字段名',0/1/2(验证场景),'报错提示',
	 *        'require/in(某几种情况)/between(范围)/length(某个范围)',参数)
	 * );
	 * @param $data
	 * @return bool
	 */
    //TODO:优化自动验证规则 case 1:只传了两个参数
	public function _validate($data){
		if (empty($this->_valid)){
			return true;
		}
		
		$this->error = array();
		
		foreach ($this->_valid as $v){
			switch ($v[1]) {
				case 0:
					if (isset($data[$v[0]])){
						if(!$this->check($data[$v[0]] , $v[3] , $v[4])){
							$this->error[] = $v[2];
							return false;
						}
					}
					break;
				case 1:
					if (!isset($data[$v[0]])){
						$this->error[] = $v[2];
						return false;
					}
					if (!$this->check($data[$v[0]] , $v[3])){
						$this->error[] = $v[2];
						return false;
					}
					break;
				case 2:
					if(isset($data[$v[0]]) && !empty($data[$v[0]])){
						if(!$this->check($data[$v[0]] , $v[3] , $v[4])){
							$this->error[] = $v[2];
							return false;
						}
					}
			}
		}
		return true;
	}
	
	/**
	 * 验证函数
	 * 重要
	 * @param unknown $value
	 * @param string $rule
	 * @param string $parm
	 * @return boolean
	 */
	protected function check($value,$rule='',$parm=''){
		switch($rule){
			case 'require':
				return !empty($value);
			case 'number':
				return is_numeric($value);
			case 'in':
				$tmp = explode(',' , $parm);
				return in_array($value, $tmp);
			case 'between':
				list($min,$max) = explode(',' , $parm);
				return ($value>=$min) && ($value<=$max);
			case 'length':
				list($min,$max) = explode(',' , $parm);
				return (strlen($value)>=$min) && (strlen($value)<=$max);
            case 'email':
                /* 先使用系统函数
                 * TODO:邮箱验证使用正则表达式
                 */
                return (filter_var($value,FILTER_VALIDATE_EMAIL) !== false);
			default:
				return false;
		}
	}
	
	/**
	 * 获取错误信息
	 * @return Ambigous <multitype:, unknown>
	 */
	public function getError(){
		return $this->error;
	}

	/**
	 * 向数据库添加数据
	 * @param $arr
	 * @return $this
	 */
    public function add($arr){
    	return $this->db->autoExecute($this->table, $arr);
    }

	/**
	 * 删除数据
	 * @param int $id
	 * @return bool|int
	 */
    public function delete($id = 0){
    	$sql = 'delete from ' . $this->table . ' where ' . $this->pk . '=' . $id;
    	if ($this->db->query($sql)){
    		return $this->db->affectedRows();
    	}
    	else{
    		return false;
    	}
    }   

    /**
     * 更新数据
     */
    public function update($data , $id){
    	$rs = $this->db->autoExecute($this->table, $data, 'update', $this->pk . "=" . $id);
    	if ($rs){
    		return $this->db->affectedRows();
    	}
    	else{
    		return false;
    	}
    }

    /**
     * 查询数据
     */
    public function select(){
    	$sql = 'select * from ' . $this->table;
    	return $this->db->getAll($sql);
    }
    
    /**
     * 查一行数据
     */
    public function find($id){
    	$sql = 'select * from ' . $this->table . ' where ' . $this->pk . '=' .  $id;
    	return $this->db->getRow($sql);
    }
}
