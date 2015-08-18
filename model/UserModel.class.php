<?php
defined('ACC') || exit('Acc Denied');
/**
 * UserModel类
 * @authors zhangyang (zy1123581321@qq.com)
 * @date    2015-08-09 16:34:18
 */

class UserModel extends Model{
    protected $table = 'user';
    protected $pk = 'user_id';
    protected $field = array(
        'user_id',
        'username',
        'email',
        'passwd',
        'regtime',
        'lastlogin');
    protected $_valid = array(
        array('username', 1, '用户名必须存在', 'require'),
        array('username', 0, '用户名必须在4-16字符之间', 'length', '4,16'),
        array('email', 1, '错误的email格式', 'email'),  //针对email多做一种判断
        array('passwd', 1, '密码不能为空', 'require'),
        array('agreement', 1, '您必须同意《用户协议》', 'require')
    );
    protected $_auto = array(
        array('regtime', 'function', 'time')
    );

    /**
     * 注册
     * @param $data
     * @return $this
     */
    public function reg($data){
        if($data['passwd']){
            $data['passwd'] = $this->encPasswd($data['passwd']);
        }
        return $this->add($data);
    }

    /**
     * md5加密密码
     * @param $p
     * @return string
     */
    protected function encPasswd($p){
        return md5($p);
    }

    public function checkUser($username, $passwd = ''){
        if($passwd == '') {
            $sql = 'select count(*) from ' . $this->table . " where username='" . $username . "'";
            return $this->db->getOne($sql);
        }else{
            $sql = "select user_id,username,email,passwd from " . $this->table . " where username='" . $username . "'";
            $row = $this->db->getRow($sql);
            //print_r($row);
            if(empty($row)){
                return false;
            }

            if($row['passwd'] !== $this->encPasswd($passwd)){
                return false;
            }

            unset($row['passwd']);
            return $row;
        }
    }


}