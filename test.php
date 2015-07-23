<?php
define('ACC',true);
require "./include/init.php";
require ROOT."tool/UpTool.class.php";
/***
* @auther:zhangyang
*/
$uptool = new UpTool();
if($res = $uptool->up('pic')){
	echo 'OK<br />';
	echo '文件存放在：' . $res;
}else{
	echo 'FAIL<br />';
	echo $uptool->getError();
}

?>