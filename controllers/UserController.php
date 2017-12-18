<?php
/**
* 用户管理
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\service\MCore;
use app\service\UserService;
class UserController extends CenterController
{
	//列表
	public function actionList()
	{
		$page = MCore::get_var('page',0);
		$page_size = MCore::get_var('page_size',0);
		$keyword = MCore::get_var('keyword',0);
		$page = $page ? $page : 1;
		$page_size = $page_size ? $page_size : 10;
		$integer = '/^[0-9]*$/';
		if(!preg_match($integer, $page)){
			MCore::show_msg_go_back('页码错误');
		}
		$where[] = '1=1';
		if($keyword){
			$where[] = '(nickname like "%'.$keyword.'%" or stu_no like "%'.$keyword.'%")';
		}
		$where_sql = implode(' and ', $where);

		$total = UserService::get_total(UserService::$table,$where_sql);
		$total_page = ceil($total/$page_size);

		$data = UserService::get_list(UserService::$table,$where_sql,$page,$page_size);

		foreach ($data as $k => $v) {
			if($v['gender']=='1'){
				$data[$k]['gender_name'] = '男';
			}elseif($v['gender']=='2'){
				$data[$k]['gender_name'] = '女';
			}else{
				$data[$k]['gender_name'] = '未知';
			}

			if($v['valid']=='1'){
				$data[$k]['valid_name'] = '有效';
			}else{
				$data[$k]['valid_name'] = '禁用';
			}
		}

		return $this->render('list',array(
			'data'=>$data,
			'page'=>$page,
			'page_size'=>$page_size,
			'total'=>$total,
			'total_page'=>$total_page,
			'keyword'=>$keyword,
		));
	}

	//更改状态
	public function actionAjaxupdatestatus()
	{
		$user_id = MCore::get_var('user_id');
		$valid = MCore::get_var('valid_status','0');
		if(!$valid) $changed_valid = 1;
		else $changed_valid = 0;
		UserService::update(UserService::$table,$user_id,array('valid'=>$changed_valid));
		MCore::ajax_return(array('code'=>0,'msg'=>'成功'));
	}
}