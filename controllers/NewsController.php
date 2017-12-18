<?php
/**
* 新闻管理
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\service\AdminUserService;
use app\service\MCore;
use app\service\UserService;
use app\service\NewsService;
class NewsController extends CenterController
{
	
	//列表
	public function actionList()
	{
		$page = MCore::get_var('page',0);//MCore_get_var();获取请求参数，0表示可以为空，默认为1
		$page_size = MCore::get_var('page_size',0);
		$keyword = MCore::get_var('keyword',0);
		$page = $page ? $page : 1;
		$page_size = $page_size ? $page_size : 10;
		$integer = '/^[0-9]*$/';
		if(!preg_match($integer, $page)){
			MCore::show_msg_go_back('页码错误');
		}
		$where[] = 'status=1';
		if($keyword){
			$where[] = 'title like "%'.$keyword.'%"';
		}
		$where_sql = implode(' and ', $where);//查询条件

		$total = NewsService::get_total(NewsService::$table,$where_sql);//获取总数
		$total_page = ceil($total/$page_size);

		$data = NewsService::get_list(NewsService::$table,$where_sql,$page,$page_size);//获取列表，分页

		foreach ($data as $k => $v) {
			if($v['creat_by']){
				$admin_info = AdminUserService::get_detail(AdminUserService::$table,array('id'=>$v['creat_by']));
				$data[$k]['admin_name'] = $admin_info['admin_name'];
			}else{
				$data[$k]['admin_name'] = '';
			}

			
			// $data[$k]['img_url'] = $v['img_url'];
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

	public function actionAdd()
	{
		return $this->render('add',array(
			
		));
	}
}