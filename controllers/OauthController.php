<?php
/**
* oauth授权
*/
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\service\MCore;
use app\service\CurlService;
use app\service\UserService;
class OauthController extends Controller
{
	
	public function actionIndex()
	{
		$app_id = '123456';
		$app_secret = '965EB72C92A549DD';
		$openid = Mcore::get_var('openid');

		$fp = fopen('access_token.json', 'w');
		fclose($fp);
		// var_dump($openid);exit;
		$data = json_decode(file_get_contents('access_token.json'),true);
		if(!$data || $data['expire_tims']<time()){
			$url = "https://www.ifour.net.cn/scau_info/oauth/v1/web/token/get-token?app_id=$app_id&app_secret=$app_secret";
			$res = CurlService::curl_get($url);
			if(isset($res['status'])){//发生错误
				MCore::ajax_return(array('code'=>-1,'msg'=>$res['msg']));
			}
			file_put_contents('access_token.json', json_encode($res));
			$access_token = $res['access_token'];
		}else{
			$access_token = $data['access_token'];
		}



		
		$get_user_info_url = "https://www.ifour.net.cn/scau_info/oauth/v1/web/user/get-user-info?app_id=$app_id&access_token=$access_token&openid=$openid";
		// var_dump($access_token);exit;
		$res1 = CurlService::curl_get($get_user_info_url);
		if(isset($res1['status'])){
			echo json_encode($res1);
			exit;
		}
		$data['username'] = $res1['nickname'];
		$data['avatarUrl'] = $res1['avatarUrl'];
		$data['country'] = $res1['country'];
		$data['province'] = $res1['province'];
		$data['city'] = $res1['city'];
		$data['language'] = $res1['language'];
		$data['gender'] = $res1['gender'];

		$user_id = 0;

		$one = UserService::get_detail(UserService::$table,array('status'=>1,'openid'=>$openid));
		if($one){
			UserService::update(UserService::$table,$openid,$data);
			$user_id = $one['id'];
		}else{
			$data['openid']= $openid;
			$id = UserService::save(UserService::$table,$data);
			if(!$id){
				MCore::show_msg_go_back('登录失败，请重试');
			}
			$user_id = $id;
		}
		$session = \Yii::$app->session;
		$session->set('user_id' , $user_id);
		$session->set('username' , $data['username']);
		// MCore::ajax_return(array('code'=>0,'msg'=>'登录成功'));
		return $this->redirect('index.php?r=index/index');


		// var_dump($res1);
	}
}