<?php
defined('ACC')||exit('Access Denied');
/***
* @auther:zhangyang
*/

/***
* file UpTool.class.php
* 单文件上传类
* 配置允许的后缀
* 配置允许的大小
* 随机生成目录
* 随机生成文件名

* 获取文件后缀
* 判断文件后缀

* 良好的报错支持
*/

class UpTool {
	protected $allowExt = 'jpg,jpeg,gif,bmp,png';
	protected $maxSize = 1;  //1M,M为单位

	protected $errno = 0;  //错误代码
	protected $error = array(
		0=>'没有错误',
		1=>'上传的文件超出系统限制',
		2=>'上传的文件超出网页表单限制',
		3=>'文件只有部分被上传',
		4=>'没有文件被上传',
		6=>'找不到临时文件夹',
		7=>'文件写入失败',
		8=>'不允许的文件类型',
		9=>'文件大小超出类的允许范围',
		10=>'创建目录失败',
		11=>'移动文件失败'
		);

	/**
	* 上传
	*/
	public function up($key){
		if(!isset($_FILES[$key])){
			return false;
		}
		$f = $_FILES[$key];
		/*
		* 检验上传有没有成功
		*/
		if($f['error']){
			$this->errno = $f['error'];
			return false;
		}


		/*
		* 获取、检查后缀
		*/
		$ext = $this->getExt($f['name']);
		if(!$this->isAllowedExt($ext)){
			$this->errno = 8;
			return false;
		}

		/*
		* 检查大小
		*/
		if(!$this->isAllowedSize($f['size'])){
			$this->errno = 9;
			return false;
		}

		//通过，创建目录
		$dir = $this->mk_dir();
		if($dir == false){
			$this->errno = 10;
			return false;
		}

		$newname = $this->randName() . '.' . $ext;

		//移动
		if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$newname)){
			$this->errno = 11;
			return false;
		}

		return str_replace(ROOT, '', $dir.'/'.$newname);
	}

	/**
	* parm string $file
	* return string $ext 后缀
	*/
	protected function getExt($file){
		$tmp = explode('.',$file);
		return end($tmp);
	}

	/**
	* parm string $ext
	* return bool
	* 防止大小写问题
	*/
	protected function isAllowedExt($ext){
		return in_array(strtolower($ext),explode(',',strtolower($this->allowExt)));
	}

	/**
	* 检查文件大小
	*/
	protected function isAllowedSize($size){
		return $size<=$this->maxSize*1024*1024;
	}

	/**
	* 按日期创建目录
	*/
	protected function mk_dir(){
		$dir = ROOT . 'data/images/' . date('ym/d');

		if(is_dir($dir) || mkdir($dir,0777,true)){
			return $dir;
		}else{
			return false;
		}
	}

	/**
	* 生成随机文件名
	*/
	protected function randName($length=6){
		$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
		return substr(str_shuffle($str),0,$length);
	}

	/**
	* 获取错误信息
	*/
	public function getError(){
		return $this->error[$this->errno];
	}

	/**
	* 设置允许的后缀
	*/
	public function setExt($ext){
		$this->allowExt = $ext;
	}

	/**
	* 设置允许上传文件最大值
	*/
	public function setSize($size){
		$this->maxSize = $size;
	}
}