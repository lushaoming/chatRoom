<?php
namespace app\models;

use app\models\BaseModel;
use app\models\CoreModel;

class UploadImageModel extends BaseModel
{
	public static $table = 'images';

	/**
	*检查上传文件的合法性
	*@param $name  string  上传文件的控件名称
	*@param $is_photo  int  是否为图片，1是，0否
	*@param $is_update int 是否为更新操作，1是，0否
	*@return array code=0表示检查通过
	*/
	public static function check_images($name,$is_photo='0',$is_update='0')
	{
		if($is_update){
			if(empty($_FILES[$name]['name'])){
				return 0;
			}
		}else{
			if(empty($_FILES[$name]['name'])){
				return array('code'=>500,'msg'=>'请选择文件');
			}
		}

		if($is_photo){
			if (($_FILES[$name]["type"] != "image/gif")
			&& ($_FILES[$name]["type"] != "image/jpeg")
			&& ($_FILES[$name]["type"] != "image/png")){
				return array('code'=>500,'msg'=>'图片格式错误，仅支持jpg,gif,png格式的图片');
			}
		}
		if($_FILES[$name]["size"]>2*1024*1024){//最大2M
			return array('code'=>500,'msg'=>'文件大小超出最大限制');
		}
		return 0;
	}

	/**
	*上传文件
	*@param $name  string  上传文件的控件名称
	*@param $save_path  string  文件保存路径
	*@return array code=0表示上传成功
	*/
	public static function upload_file($name,$save_path,$prefix='0')
	{
		// $str = explode(".", $_FILES[$name][tmp_name]);
		// $ext_name = $str[sizeof($str)-1];
		$prefix_path = '';
		$file_name = strtotime('now').rand(10000,99999).pathinfo($_FILES[$name]["tmp_name"], PATHINFO_EXTENSION);;
		move_uploaded_file($_FILES[$name]["tmp_name"],$save_path.'/'.$file_name);
		if($prefix){
			$prefix_path = $prefix;
		 }
		$save = $prefix_path.$save_path.'/'.$file_name;
		return array('code'=>0,'msg'=>$save);
		
	}
	
	

}