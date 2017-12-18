<?php
/**
 * 自助服务
 * @author Echolove4 
 * @date 2017-11-08
 */
namespace app\service;
use Yii;
use app\service\BaseService;
use app\service\UserService;
use app\service\AutoReplyService;
use app\service\FriendService;
use app\service\ChatRecordService;
use yii\web\Gateway;

class RobotService extends BaseService
{
	public static function robot($from_id,$msg)
	{
		// $data['msg'] = $message; 
		$user_info = UserService::get_detail(UserService::$table,array('id'=>$from_id));
		$user_id = $user_info['user_id'];
		$nickname = $user_info['username'];
		$create_time = $user_info['create_time'];
		$friend_num = FriendService::get_total_friends($from_id);
   		$return_data['from_id'] = 9;
   		$return_data['to_id'] = $from_id;
   		$reply_data = AutoReplyService::get_detail(AutoReplyService::$table,array('code'=>$msg));
   		if($msg=='1'){
			$return_data['msg'] = "<p>您的个人信息：</p><p>帐号：$user_id</p><p>昵称：$nickname</p><p>注册时间：$create_time</p><p>好友数量：$friend_num</p>";
		}elseif($reply_data){
   			$return_data['msg'] = $reply_data['content'];
   		}else{
   			if(mb_substr($msg, 0,9)=='userInfo&'){
				$user_id_find = mb_substr($msg, 14);
				// echo $user_id_find;
				if($user_id_find){
					$user_info_find = UserService::get_detail(UserService::$table,array('user_id'=>$user_id_find));
					
					
					if($user_info_find){
						$friend_info = FriendService::get_detail_by_where_sql(FriendService::$table,'((user_id="'.$user_info_find['id'].'" and friend_id="'.$from_id.'") or (friend_id="'.$user_info_find['id'].'" and user_id="'.$from_id.'")) and status=1');
						var_dump($friend_info);

						$is_friend = '否';
						$be_friend_time = '';
						if($friend_info){
							$is_friend = '是';
							$be_friend_time = '<p>成为好友的时间：'.$friend_info['create_time'].'</p>';
						}

						$return_data['msg'] = "<p>用户信息：</p><p>帐号：".$user_info_find['user_id']."</p><p>昵称：".$user_info_find['username']."</p><p>注册时间：".$user_info_find['create_time']."</p><p>是否为好友：".$is_friend."</p>".$be_friend_time;
					}else{
						$return_data['msg'] = '未找到该用户信息，请核对';
					}
				}else{
					$return_data['msg'] = '没有输入用户帐号';
				}
			}else{
				$return_data['msg'] = 'Echo无法找到对应的内容，请核对输入。输入help获取帮助。';
			}
   		}
		// if($msg=='help'){
		// 	$return_data['msg'] = '<p>请回复以下数字获取相关内容：</p><p>1、获取个人信息</p><p>2、查询用户信息</p><p>3、如何添加好友</p><p>4、如何管理好友</p><p>5、如何绑定邮箱</p><p>6、获取聊天室信息</p>';
		// }elseif($msg=='1'){
		// 	$return_data['msg'] = "<p>您的个人信息：</p><p>帐号：$user_id</p><p>昵称：$nickname</p><p>注册时间：$create_time</p><p>好友数量：$friend_num</p>";
		// }elseif($msg=='2'){
		// 	$return_data['msg'] = '请按照以下格式回复：userInfo 用户帐号，如userInfo xxxxx';
		// }elseif($msg=='6'){
		// 	$reply_data = AutoReplyService::get_detail(AutoReplyService::$table,array('code'=>6));
		// 	$return_data['msg'] = $reply_data['content'];
		// }
		
		$return_data['type'] = 'chat';
      	$return_data['create_time'] = date('Y-m-d H:i:s');
      	$return_data['fromname'] = $user_info['username'];

      	//保存进数据库
      	$save_data['msg'] = $return_data['msg']; 
   		$save_data['from_id'] = 9;
   		$save_data['to_id'] = $from_id;
        // ChatRecordService::save(ChatRecordService::$table,$save_data);


      	$gateway = new Gateway(); 
   		$gateway->sendToUid($from_id, json_encode($return_data)); //发给对方 

   		
	}
}