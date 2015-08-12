<?php
/***
 * file ImageTool.class.php
 * 图像处理类
 * @authors zhangyang
 * @date    2015-04-28 08:55:42
 */

/**
* 先获取图片信息
*/
class ImageTool{
	/*imageInfo 分析图片的大小
	* return array()
	*/
	public static function imageInfo($image){
		if (!file_exists($image)) {
			return false;
		}

		$info = getimagesize($image);

		if (!$info) {
			return false;
		}

		$img['width'] = $info[0];
		$img['height'] = $info[1];
		$img['ext'] = substr($info['mime'],strpos($info['mime'], '/')+1);

		return $img;
	} 


	/**
	* 加水印
	* parm string $dst 待操作图片
	* parm string $water 水印小图
	* parm string $save 不填默认替换原始图
	* parm 
	*/
	public static function water($dst,$water,$save=NULL,$pos=2,$alpha=50){
		//首先保证水印不能比待操作图片大
		$dinfo = self::imageInfo($dst);
		$winfo = self::imageInfo($water);

		if (($dinfo==false) || ($winfo==false)) {
			return false;
		}

		if ($winfo['height'] > $dinfo['height'] || $winfo['width'] > $dinfo['width']) {
			return false;
		}

		$dfunc = 'imagecreatefrom' . $dinfo['ext'];
		$wfunc = 'imagecreatefrom' . $winfo['ext'];

		if (!function_exists($dfunc) || !function_exists($wfunc)) {
			return false;
		}

		$dim = $dfunc($dst);
		$wim = $wfunc($water);

		//根据水印的位置计算粘贴的坐标
		switch ($pos) {
			case 0:
				$posx = 0;
				$posy = 0;
				break;
			case 1:
				$posx = $dinfo['width'] - $winfo['width'];
				$posy = 0;
				break;
			case 3:
				$posx = 0;
				$posy = $dinfo['height'] - $winfo['height'];
				break;
			default:
				$posx = $dinfo['width'] - $winfo['width'];
				$posy = $dinfo['height'] - $winfo['height'];
				break;
		}

		imagecopymerge($dim, $wim, $posx, $posy, 0, 0, $winfo['width'], $winfo['height'], $alpha);

		//保存
		if (!$save) {
			$save = $dst;
			unlink($dst);
		}

		$createfunc = 'image' . $dinfo['ext'];
		$createfunc($dim,$save);

		imagedestroy($dim);
		imagedestroy($wim);

		return true;
	}

	/**
	* tumb 生成缩略图
	* 等比例缩放 两边留白
	*/
	public static function thumb ($dst, $save=NULL, $width=200, $height=200){
		$dinfo = self::imageInfo($dst);
		if ($dinfo==false) {
			return false;
		}

		//计算缩放比例
		$calc = min($width/$dinfo['width'],$height/$dinfo['height']);

		$dfunc = 'imagecreatefrom' . $dinfo['ext'];
		$dim = $dfunc($dst);

		$tim = imagecreatetruecolor($width, $height);

		$white = imagecolorallocate($tim, 255, 255, 255);

		imagefill($tim, 0, 0, $white);

		$dwidth = (int)$dinfo['width']*$calc;
		$dheight = (int)$dinfo['height']*$calc;

		$paddingx = (int)($width - $dwidth)/2;
		$paddingy = (int)($height - $dheight)/2;


		imagecopyresampled($tim, $dim, $paddingx, $paddingy, 0, 0, $dwidth, $dheight, $dinfo['width'], $dinfo['height']);

		//保存图片
		if (!$save) {
			$save = $dst;
			unlink($dst);
		}

		$createfunc = 'image' . $dinfo['ext'];
		$createfunc($tim,$save);

		imagedestroy($dim);
		imagedestroy($tim);
		return true;
	}
}