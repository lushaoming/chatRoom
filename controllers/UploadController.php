<?php
/**
* 文件上传
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\service\MCore;
use app\service\UploadService;
class UploadController extends CenterController
{
	public $enableCsrfValidation = false;//关闭csrf验证
	
	//上传图片，并将上传后图片的路径返回
	public function actionUpload()
	{
		$upload = UploadService::upload_file('upload_img',MCore::$IMGS_SAVE_PATH);
		if($upload['code']=='0'){
			MCore::ajax_return($upload);
		}else{
			MCore::ajax_return($upload);
		}
		
	}

	//上传文件
	public function actionUploadfile()
	{
		$upload = UploadService::upload_zip_file('upload_file',MCore::$FILES_SAVE_PATH);
		if($upload['code']=='0'){
			MCore::ajax_return(MCore::$return_code['SUCCESS'],$upload['msg']);
		}else{
			MCore::ajax_return($upload);
		}
	}

	//上传新闻列表图片
	public function actionUploadNewsTitleImg()
	{
		$upload = UploadService::upload_img('upload_file',MCore::$news_img_path);
		if($upload['code']=='0'){
			MCore::ajax_return(MCore::$return_code['SUCCESS'],$upload['msg']);
		}else{
			MCore::ajax_return($upload);
		}
	}

	//上传新闻列表图片
	public function actionUploadNewsContentImg()
	{
		$upload = UploadService::upload_img('news_img_upload',MCore::$news_img_path);
		if($upload['code']=='0'){
			MCore::ajax_return(MCore::$return_code['SUCCESS'],$upload['msg']);
		}else{
			MCore::ajax_return($upload);
		}
	}
}