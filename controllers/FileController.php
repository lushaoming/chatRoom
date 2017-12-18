<?php
/**
* 学习资料管理
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\service\MCore;
use app\service\UserService;
use app\service\FileService;
use app\service\FileTypeService;
class FileController extends CenterController
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
		$where[] = 'status<>2';
		if($keyword){
			$where[] = 'file_name like "%'.$keyword.'%"';
		}
		$where_sql = implode(' and ', $where);//查询条件

		$total = FileService::get_total(FileService::$table,$where_sql);//获取总数
		$total_page = ceil($total/$page_size);

		$data = FileService::get_list(FileService::$table,$where_sql,$page,$page_size);//获取列表，分页

		foreach ($data as $k => $v) {
			if($v['user_id']){
				$user_info = UserService::get_detail(UserService::$table,array('id'=>$v['user_id']));
				$data[$k]['nickname'] = $user_info['nickname'];
			}else{
				$data[$k]['nickname'] = '管理员';
			}

			$file_type = FileTypeService::get_detail(FileTypeService::$table,array('id'=>$v['type_id']));
			$data[$k]['type_name'] = $file_type['name'];

			
			if($v['file_size']>1024*1024){
				$data[$k]['file_size'] =  round($v['file_size']/1024/1024,2).'MB';
			}elseif($v['file_size']>1024){
				$data[$k]['file_size'] =  round($v['file_size']/1024,2).'KB';
			}else{
				$data[$k]['file_size'] = $v['file_size'].'B';
			}

			if($v['status']=='1'){
				$data[$k]['status_name'] = '正常';
			}else{
				$data[$k]['status_name'] = '隐藏';
			}

			$data[$k]['file_url'] = $v['file_url'];
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
		$type_list = FileTypeService::get_detail(FileTypeService::$table,array('status'=>1),'1');
		return $this->render('add',array(
			'type_list'=>$type_list,
		));
	}

	public function actionSave()
	{
		$data['file_name'] = MCore::get_var('file_name');
		$data['file_url'] = MCore::get_var('file_url');
		$data['file_size'] = MCore::get_var('file_size');
		$data['type_id'] = MCore::get_var('type_id');
		$data['description'] = MCore::get_var('description');
		$data['code'] = md5($data['file_url']);
		$insert_id = FileService::save(FileService::$table,$data);
		if($insert_id){
			MCore::ajax_return(array('code'=>0,'msg'=>'保存成功'));
		}else{
			MCore::ajax_return(array('code'=>500,'msg'=>'保存失败'));
		}
	}

	//下载文件
	public function actionDownload()
	{
		$url = MCore::get_var('file_url');
		// MCore::download_file($url);
		$file_info = FileService::get_detail_by_where_sql(FileService::$table,'file_url="'.$url.'" and status<>2');
		if(!$file_info){
			echo "该文件不存在";exit;
		}
		$url = MCore::get_full_url($url);
		echo '<script>location.href="'.$url.'";</script>';

	}

	public function actionAjaxchangestatus()
	{
		$file_id = MCore::get_var('file_id');
		$file_status = MCore::get_var('file_status','0');
		if(!$file_status) $changed_valid = 1;
		else $changed_valid = 0;
		FileService::update(FileService::$table,$file_id,array('status'=>$changed_valid));
		$file_info = FileService::get_detail(FileService::$table,array('id'=>$file_id));
		if($file_info && $file_info['user_id']){
			$user_info = UserService::get_detail(UserService::$table,array('id'=>$file_info['user_id']));
			if($user_info&&$user_info['email']){
				if($changed_valid==0){
					$subject = '文件被隐藏通知';
					$body = '尊敬的'.$user_info['nickname'].'，您上传的文件：'.$file_info['file_name'].'由于某些原因被管理员隐藏，如有异议，可直接恢复此邮件！----华农之窗项目组敬上';
				}else{
					$subject = '文件被解除隐藏通知';
					$body = '尊敬的'.$user_info['nickname'].'，您上传的文件：'.$file_info['file_name'].'已被管理员取消隐藏！----华农之窗项目组敬上';
				}
				$mail= Yii::$app->mailer->compose();   
		        $mail->setTo($user_info['email']);  
		        $mail->setSubject($subject);
		        $mail->setTextBody($body);   //发布纯文字文本
		        if($mail->send()){
		            // AdminUserModel::update(AdminUserModel::$table,$admin_info['id'],$data);
		        }else{
		        } 
			}
		}
		
		MCore::ajax_return(array('code'=>0,'msg'=>'成功'));
	}


}