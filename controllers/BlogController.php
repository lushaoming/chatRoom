<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\models\BaseModel;
use app\models\BlogModel;
use app\models\UploadImageModel;
use app\models\CommentModel;
use app\models\TagsModel;
use app\controllers\CenterController;
use app\service\EncryptService;
class BlogController extends CenterController
{
	public function actionIndex()
	{
		// $str = EncryptService::encrypt('Lw','Lu!@admin001');
		// echo $str;
		// echo '<br>';
		// echo EncryptService::decrypt($str,'Lu!@admin001');exit;
		return $this->redirect('index.php?r=image/index');
		$request = Yii::$app->request;
		$page = $request->get('page');
		$page_size = $request->get('page_size');
		$page = $page ? $page : 1;
		$page_size = $page_size ? $page_size : 10;
		$keyword = $request->get('keyword');
		$type = $request->get('type');
		$integer = '/^[0-9]*$/';
		if(!preg_match($integer, $page)){
			CoreModel::show_msg_go_back('页码错误');
		}
		$where = array();
		$where[] = 'status=1';
		if($type=='1'){
			$where[] = 'is_publish=1';
		}elseif($type=='2'){
			$where[] = 'is_publish=2';
		}
		if($keyword){
			$where[] = "title like '%".$keyword."%'";
		}
		$where_sql = implode(" and ", $where);
		$total = BlogModel::get_total(BlogModel::$table,$where_sql);
		$total_page = ceil($total/$page_size);
		if($total_page==0){
			$total_page=1;
		}
		if($page>$total_page){
			$page = $total_page;
		}
		$data = BlogModel::get_list(BlogModel::$table,$where_sql,$page,$page_size);
		foreach ($data as $k => $v) {
			$admin_info = AdminUserModel::get_detail(AdminUserModel::$table,array('id'=>$v['admin_user_id']));
			$data[$k]['admin_name'] = $admin_info['admin_name'];
			$data[$k]['tag'] = explode(",", $v['tags']);
			$data[$k]['num'] = CommentModel::get_total(CommentModel::$table,"status=1 and blog_id='".$v['id']."'");
			if($v['is_publish']=='1'){
				$data[$k]['status_name'] = '未发表';
			}elseif($v['is_publish']=='2'){
				$data[$k]['status_name'] = '已发表';
			}else{
				$data[$k]['status_name'] = '未知';
			}
		}

		$num_list = CommentModel::get_num_list();
		$data1 = array();
		foreach ($num_list as $k => $v) {
			$data1[$k] = BlogModel::get_detail_by_id(BlogModel::$table,$v['blog_id']);
			$admin_info1 = AdminUserModel::get_detail(AdminUserModel::$table,array('id'=>$data1[$k]['admin_user_id']));
			$data1[$k]['admin_name'] = $admin_info1['admin_name'];
			$data1[$k]['num'] = $v['num'];
		}

		

		return $this->render('index',array(
			'data'=>$data,
			'data1'=>$data1,
			'page'=>$page,
			'page_size'=>$page_size,
			'total'=>$total,
			'total_page'=>$total_page,
			'keyword'=>$keyword,
			));
	}

	//新增页面
	public function actionAdd()
	{
		return $this->render('add');
	}

	//新增操作
	public function actionAddnew()
	{
		$session = \Yii::$app->session;
		$request = Yii::$app->request;
		$title = $request->post('title');
		$tags = $request->post('tags');
		$content = $request->post('content');
		if(!$title){
			CoreModel::ajax_return(CoreModel::$return_code['EMPTY_TITLE']);
		}
		if(!$tags){
			CoreModel::ajax_return(CoreModel::$return_code['EMPTY_TAGS']);
		}
		if(!$content){
			CoreModel::ajax_return(CoreModel::$return_code['EMPTY_CONTENT']);
		}
		$check = UploadImageModel::check_images('image',1);//检查图片的合法性
		if($check){
			CoreModel::ajax_return(array('code'=>500,'msg'=>$check['msg']));
		}
		$upload = UploadImageModel::upload_file('image',CoreModel::$FILES_SAVE_PATH,CoreModel::$prefix_path);//上传图片
		if($upload['code']==0){
			$data['img_url'] = $upload['msg'];
		}
		$data['title'] = $title;
		$data['content'] = $content;
		$data['tags'] = $tags;
		$data['admin_user_id'] = $session->get('admin_id');
		$tag = explode(',', $tags);
		foreach ($tag as $k => $v) {//将不存在的新标签写进数据库
			$check_exist = TagsModel::get_detail(TagsModel::$table,array('status'=>1,'tag'=>$v));
			if(!$check_exist){
				TagsModel::save(TagsModel::$table,array('tag'=>$v),1);
			}
			
		}
		$id = BlogModel::save(BlogModel::$table,$data,1);//保存数据
		
		if($id){
			CoreModel::ajax_return(CoreModel::$return_code['SUCCESS']);
		}else{
			CoreModel::ajax_return(CoreModel::$return_code['FAIL']);
		}
		
	}

	//详情页
	public function actionDetail()
	{
		$request = Yii::$app->request;
		$bid = $request->get('bid');
		if(!$bid){
			CoreModel::show_msg_go_back('无法获取到博客信息');
		}
		$data = BlogModel::get_detail_by_where_sql(BlogModel::$table,"status<>3 and id='".$bid."'");
		if(!$data){
			CoreModel::show_msg_go_back('该到博客不存在或已被删除');
		}
		
		return $this->render('detail',array(
			'data'=>$data,
			));
	}

	//删除
	public function actionDel()
	{
		$request = Yii::$app->request;
		$bid = $request->post('bid');
		if(!$bid){
			CoreModel::ajax_return(array('code'=>500,'msg'=>'无法获取到博客信息'));
		}
		$data = BlogModel::get_detail_by_where_sql(BlogModel::$table,"status<>3 and id='".$bid."'");
		if(!$data){
			CoreModel::ajax_return(array('code'=>500,'msg'=>'该到博客不存在或已被删除'));
		}
		BlogModel::update(BlogModel::$table,$bid,array('status'=>3));
		CoreModel::ajax_return(CoreModel::$return_code['SUCCESS']);
	}

	//更新状态（发表或下架）
	public function actionUpdatestatus()
	{
		$request = Yii::$app->request;
		$bid = $request->post('bid');
		$status = $request->post('status');
		if(!$bid){
			CoreModel::ajax_return(array('code'=>500,'msg'=>'无法获取到博客信息'));
		}
		$data = BlogModel::get_detail_by_where_sql(BlogModel::$table,"status<>3 and id='".$bid."'");
		if(!$data){
			CoreModel::ajax_return(array('code'=>500,'msg'=>'该到博客不存在或已被删除'));
		}
		if($status && $status=='1'){
			BlogModel::update(BlogModel::$table,$bid,array('is_publish'=>2));
		}else{
			BlogModel::update(BlogModel::$table,$bid,array('is_publish'=>1));
		}
		CoreModel::ajax_return(CoreModel::$return_code['SUCCESS']);

	}
}