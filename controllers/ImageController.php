<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\service\MCore;
use app\models\BaseModel;
use app\models\ImagesModel;
use app\models\UploadImageModel;
use app\service\ImageTypeService;
use app\service\ImageService;


class ImageController extends CenterController
{
	//图集列表
	public function actionIndex()
	{
		$request = Yii::$app->request;
		$page = $request->get('page');
		$page_size = $request->get('page_size');
		$page = $page ? $page : 1;
		$page_size = $page_size ? $page_size : 10;
		$integer = '/^[0-9]*$/';
		if(!preg_match($integer, $page)){
			MCore::show_msg_go_back('页码错误');
		}
		$total = ImageTypeService::get_total(ImageTypeService::$table,'status=1');
		$total_page = ceil($total/$page_size);
		if($total_page==0) $total_page=1;
		if($page>$total_page){
			$page = $total_page;
		}
		$data = ImageTypeService::get_list(ImageTypeService::$table,'status=1',$page,$page_size);
		$ids_arr = array();
		foreach ($data as $k => $v) {
			$first_img = ImageService::get_detail(ImageService::$table,array('status'=>1,'type_id'=>$v['id']),'0','id desc');
			$data[$k]['num'] = ImageService::get_total(ImageService::$table,"status='1' and type_id='".$v['id']."'");

			if($first_img){
				$data[$k]['img_url'] = MCore::$prefix_path.$first_img['img_url'];
			}else{
				$data[$k]['img_url'] = __IMG_PATH__.'/default.jpg';
			}
			$ids_arr[] = $v['id'];
		}
		// $ids_str = implode(',', $ids_arr);
		// ImageTypeService::get_total_group_by_id($ids_str);
		return $this->render('index',array(
			'data'=>$data,
			'page'=>$page,
			'page_size'=>$page_size,
			'total'=>$total,
			'total_page'=>$total_page,
		));
	}

	public function actionUpload()
	{
		$check = UploadImageModel::check_images('file',1);
		if($check){
			return $check;
		}else{
			$upload = UploadImageModel::upload_file('file','/upload_images');
			if($upload['status']==0){
				$session = \Yii::$app->session;
				$data['img_url'] = $upload['msg'];
				$data['admin_user_id'] = $session->get('admin_id');
				$id = ImagesModel::save(ImagesModel::$table,$data,1);
				if($id){
					return 'success';
				}else{
					return 'fail';
				}
			}
		}
	}

	public function actionList()
	{
		$request = Yii::$app->request;
		$page = $request->get('page');
		$page_size = $request->get('page_size');
		$type_id = $request->get('id');
		$page = $page ? $page : 1;
		$page_size = $page_size ? $page_size : 11;
		$integer = '/^[0-9]*$/';
		if(!preg_match($integer, $page)){
			CoreModel::show_msg_go_back('页码错误');
		}
		$type_info = ImageTypeService::get_detail(ImageTypeService::$table,array('id'=>$type_id,'status'=>1));
		if(!$type_info){
			MCore::ajax_return(array('code'=>500,'msg'=>'该图集不存在'));
		}
		$total = ImageService::get_total(ImageService::$table,'status=1 and type_id="'.$type_id.'"');
		$total_page = ceil($total/$page_size);
		if($total_page==0) $total_page=1;
		if($page>$total_page){
			$page = $total_page;
		}
		$data = ImageService::get_list(ImageService::$table,'status=1 and type_id="'.$type_id.'"',$page,$page_size);
		foreach ($data as $k => $v) {
			$data[$k]['img_url'] = MCore::$prefix_path.$v['img_url'];
		}
		return $this->render('list',array(
			'data'=>$data,
			'page'=>$page,
			'page_size'=>$page_size,
			'total_page'=>$total_page,
			'total'=>$total,
			'type_id'=>$type_id,
			'type_name'=>$type_info['name'],
			'type_info'=>$type_info,
			));
	}

	


	//保存图集名称
	public function actionAjaxsaveimageatlas(){
		$data['name'] = MCore::get_var('name');
		$info = ImageTypeService::get_detail(ImageTypeService::$table,array('name'=>$data['name'],'status'=>1));
		if($info){
			MCore::ajax_return(array('code'=>500,'msg'=>'该图集已存在'));
		}
		$insert_id = ImageTypeService::save(ImageTypeService::$table,$data);
		if($insert_id){
			MCore::ajax_return(array('code'=>0,'msg'=>'保存成功'));
		}else{
			MCore::ajax_return(array('code'=>500,'msg'=>'保存失败'));
		}
	}

	//保存上传图片
	public function actionSaveimage()
	{
		// $request = Yii::$app->request;
		$data['type_id'] = MCore::get_var('type_id');
		$data['img_url'] = MCore::get_var('img_url');
		$data['create_by'] = \Yii::$app->session->get('admin_id');
		$data['img_url'] = mb_substr($data['img_url'],8);
		$insert_id = ImageService::save(ImageService::$table,$data);
		if($insert_id){
			MCore::ajax_return(array('code'=>0,'msg'=>'保存成功'));
		}else{
			MCore::ajax_return(array('code'=>500,'msg'=>'保存失败'));
		}
	}

	//保存图集名称
	public function actionAjaxupdatename()
	{
		$type_id = MCore::get_var('type_id');
		$data['name'] = MCore::get_var('name');
		$one = ImageTypeService::get_detail(ImageTypeService::$table,array('status'=>1,'name'=>$data['name']));
		if($one && $one['id']!=$type_id){
			MCore::ajax_return(array('code'=>500,'msg'=>'图集名称“'.$data['name'].'”已存在'));
		}
		ImageTypeService::update(ImageTypeService::$table,$type_id,$data);
		MCore::ajax_return(MCore::$return_code['SUCCESS']);
	}

	//保存图集描述
	public function actionAjaxsavedescription()
	{
		$type_id = MCore::get_var('type_id');
		$data['description'] = MCore::get_var('description');
		ImageTypeService::update(ImageTypeService::$table,$type_id,$data);
		MCore::ajax_return(MCore::$return_code['SUCCESS']);
	}

	//删除图片
	public function actionDeleteimage()
	{
		$img_id = MCore::get_var('img_id');
		ImageService::update(ImageService::$table,$img_id,array('status'=>2));
		MCore::ajax_return(MCore::$return_code['SUCCESS']);
	}

	//隐藏图集
	public function actionAjaxhideset()
	{
		$type_id = MCore::get_var('type_id');
		ImageTypeService::update(ImageTypeService::$table,$type_id,array('is_show'=>2));
		MCore::ajax_return(MCore::$return_code['SUCCESS']);
	}

	//显示图集
	public function actionAjaxshowset()
	{
		$type_id = MCore::get_var('type_id');
		ImageTypeService::update(ImageTypeService::$table,$type_id,array('is_show'=>1));
		MCore::ajax_return(MCore::$return_code['SUCCESS']);
	}
}