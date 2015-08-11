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
}
?>