<?php
/**
* 文件上传
*/
namespace app\service;
class UploadService
{
	
	/**
	*检查上传文件的合法性
	*@param $name  string  上传文件的控件名称
	*@param $is_photo  int  是否为图片，1是，0否
	*@param $is_update int 是否为更新操作，1是，0否
	*@return array code=0表示检查通过
	*/
	public static function check_images($name,$is_photo='0',$is_update='0')
	{
		
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
		if(!is_dir($save_path))
		{
		    mkdir($save_path);
		}
		
		if(empty($_FILES[$name]['name'])){
			return array('code'=>500,'msg'=>'请选择文件');
		}
		if (($_FILES[$name]["type"] != "image/gif")
		&& ($_FILES[$name]["type"] != "image/jpeg")
		&& ($_FILES[$name]["type"] != "image/png")
		&& ($_FILES[$name]["type"] != "image/jpg")){
			return array('code'=>500,'msg'=>'图片格式错误，仅支持jpg,gif,png格式的图片');
		}
		
		if($_FILES[$name]["size"]>2*1024*1024){//最大2M
			return array('code'=>500,'msg'=>'文件大小超出最大限制');
		}
		$prefix_path = '';
		$file_name = strtotime('now').rand(10000,99999).'.jpg';
		
		
		move_uploaded_file($_FILES[$name]["tmp_name"],$save_path.'/'.$file_name);
		if($prefix){
			$prefix_path = $prefix;
		 }
		$save = $prefix_path.$save_path.'/'.$file_name;
		return array('code'=>0,'msg'=>$save);
		
	}

	public static function upload_zip_file($name,$save_path)
	{
		if(!is_dir($save_path))
		{
		    mkdir($save_path);
		}
		
		if(empty($_FILES[$name]['name'])){
			return array('code'=>500,'msg'=>'请选择文件');
		}
		// if (($_FILES[$name]["type"] != "image/gif")
		// && ($_FILES[$name]["type"] != "image/jpeg")
		// && ($_FILES[$name]["type"] != "image/png")
		// && ($_FILES[$name]["type"] != "image/jpg")){
		// 	return array('code'=>500,'msg'=>'图片格式错误，仅支持jpg,gif,png格式的图片');
		// }
		
		if($_FILES[$name]["size"]>5*1024*1024){//最大5M
			return array('code'=>500,'msg'=>'文件大小超出最大限制，上传的文件大小为：'.round($_FILES[$name]["size"]/1024/1024,2).'MB');
		}

		$pre_file_name = $_FILES[$name]["name"];
		
		$type = substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.'));
		$file_name = strtotime('now').rand(10000,99999).$type;
		
		
		move_uploaded_file($_FILES[$name]["tmp_name"],$save_path.'/'.$file_name);
		
		$save = $save_path.'/'.$file_name;

		if($_FILES[$name]["size"]>1024*1024){
			$file_size =  round($_FILES[$name]["size"]/1024/1024,2).'MB';
		}elseif($_FILES[$name]["size"]>1024){
			$file_size =  round($_FILES[$name]["size"]/1024,2).'KB';
		}else{
			$file_size = $_FILES[$name]["size"].'B';
		}


		return array('code'=>0,'msg'=>array('pre_file_name'=>$pre_file_name,'save_name'=>mb_substr($save, 8),'file_size'=>$_FILES[$name]['size'],'file_size_1'=>$file_size));
	}

	public static function upload_img($name,$save_path,$prefix='0')
	{
		if(!is_dir($save_path))
		{
		    mkdir($save_path);
		}
		
		if(empty($_FILES[$name]['name'])){
			return array('code'=>500,'msg'=>'请选择一张图片');
		}
		if (($_FILES[$name]["type"] != "image/gif")
		&& ($_FILES[$name]["type"] != "image/jpeg")
		&& ($_FILES[$name]["type"] != "image/png")
		&& ($_FILES[$name]["type"] != "image/jpg")){
			return array('code'=>500,'msg'=>'图片格式错误，仅支持jpg,gif,png格式的图片');
		}
		
		if($_FILES[$name]["size"]>2*1024*1024){//最大2M
			return array('code'=>500,'msg'=>'图片大小超出最大限制');
		}
		$prefix_path = '';

		$type = substr($_FILES[$name]['name'], strrpos($_FILES[$name]['name'], '.'));
		$file_name = strtotime('now').rand(10000,99999).$type;

		$pre_file_name = $_FILES[$name]["name"];
		
		
		move_uploaded_file($_FILES[$name]["tmp_name"],$save_path.'/'.$file_name);
		if($prefix){
			$prefix_path = $prefix;
		 }
		$save = $prefix_path.$save_path.'/'.$file_name;
		$show_path = MCore::get_full_url(mb_substr($save, 8));
		$file_size = MCore::format_file_size($_FILES[$name]['size']);
		return array('code'=>0,'msg'=>array('pre_file_name'=>$pre_file_name,'save_path'=>mb_substr($save, 8),'show_path'=>$show_path,'file_size'=>$_FILES[$name]['size'],'file_size_1'=>$file_size));
		
	}
}