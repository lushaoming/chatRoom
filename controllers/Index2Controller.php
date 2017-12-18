<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\controllers\CenterController;
use app\service\MCore;
use yii\web\Gateway;
use app\service\UserService;
use app\service\ChatRecordService;
use app\service\FriendService;
use app\service\EncryptService;

class IndexController extends CenterController
{
	public $enableCsrfValidation = false;//关闭csrf验证，接口不用开启
  
	public function actionIndex()
	{
    $session = \Yii::$app->session;
    $from_id = $session->get('user_id');
    $data = array();
    $to_user_info = array();
    
		// $user_list = UserService::get_detail_by_where_sql(UserService::$table,'status="1" and id<>"'.$session->get('user_id').'"',1);
    $friend_list = FriendService::get_detail_by_where_sql(FriendService::$table,'status="1" and (user_id="'.$from_id.'" or friend_id="'.$from_id.'")',1);

    $to_id = MCore::get_var('code','0');
    if(!$friend_list){
      $to_id = $to_id ? $to_id : 0;
    }
      
    if($friend_list){
      if($from_id==$friend_list[0]['user_id']){
        $to_id = $to_id ? EncryptService::decrypt($to_id,'Lu!@admin001') : $friend_list[0]['friend_id'];
      }else{
        $to_id = $to_id ? EncryptService::decrypt($to_id,'Lu!@admin001') : $friend_list[0]['friend_id'];
      }
      
    }

    if($to_id){
      ChatRecordService::update_all(ChatRecordService::$table,array('from_id'=>$to_id,'to_id'=>$from_id),array('is_read'=>1));
    }

    $friend_list_1 = array();
    foreach ($friend_list as $k => $v) {
      if($v['user_id']==$from_id){
        $friend_list_1[$k]['friend_id'] = $v['friend_id'];
        $friend_list_1[$k]['user_id'] = $v['user_id'];
      }else{
        $friend_list_1[$k]['friend_id'] = $v['user_id'];
        $friend_list_1[$k]['user_id'] = $v['friend_id'];
      }
      $userinfo = UserService::get_detail(UserService::$table,array('id'=>$friend_list_1[$k]['friend_id']));
      $friend_list_1[$k]['username'] = $userinfo['username'];

      $has_unread = ChatRecordService::get_detail(ChatRecordService::$table,array('to_id'=>$from_id,'from_id'=>$friend_list_1[$k]['friend_id'],'is_read'=>0));
      $friend_list_1[$k]['code'] = EncryptService::encrypt($friend_list_1[$k]['friend_id'],'Lu!@admin001');
       $friend_list_1[$k]['verify'] = md5($friend_list_1[$k]['code']);
      if($has_unread){//判断有无未读消息
        $friend_list_1[$k]['is_read'] = '1';
      }else{
        $friend_list_1[$k]['is_read'] = '0';
      }
       // $friend_list_1[$k]['is_online'] = Gateway::isUidOnline($friend_list_1[$k]['friend_id']);
    }
    // var_dump($friend_list_1);exit;

      
    $to_user_info = UserService::get_detail(UserService::$table,array('id'=>$to_id));
    
    $where_sql = '(from_id="'.$from_id.'" and to_id="'.$to_id.'") or (from_id="'.$to_id.'" and to_id="'.$from_id.'")';
    $data = ChatRecordService::get_detail_by_where_sql(ChatRecordService::$table,$where_sql,'1','id',100);

    // var_dump($data);exit;
    foreach ($data as $k => $v) {
      $user_info = UserService::get_detail(UserService::$table,array('id'=>$v['from_id']));
      $data[$k]['username'] = $user_info['username'];
    }

    $is_online = Gateway::isUidOnline($to_id);



    
   
		return $this->render('index1',array(
      'friend_list'=>$friend_list_1,
      'uid'=>$from_id,
      'username'=>$session->get('username'),
      'data'=>$data,
      'to_user_info'=>$to_user_info,
      'is_online'=>$is_online,
    ));
	}

	function actionBind() 
   	{ 
   		$session = \Yii::$app->session;
   		$uid = $session->get('user_id'); 
   		$client_id = MCore::get_var('client_id'); 
   		$gateway = new Gateway();
      
   		$gateway->bindUid($client_id, $uid);

      $user = UserService::get_detail(UserService::$table,array('id'=>$uid));
   		$message = '进入房间';
      // if(!in_array($uid, MCore::$users)){
      //   $users[] = $uid;
      // }
      // var_dump($users);
      

   		$gateway->sendToUid($uid, json_encode(array('type'=>'connect','msg'=>$message))); 
   	} 

   	function actionMessage() 
   	{
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
   		$to_uid = MCore::get_var('to_id'); 
   		$message = MCore::get_var('msg'); 
   		$gateway = new Gateway(); 
      $from_user = UserService::get_detail(UserService::$table,array('id'=>$uid));
   		$data['msg'] = $message; 
   		$data['from_id'] = $uid;
   		$data['to_id'] = $to_uid;
      $data['create_time'] = date('Y-m-d H:i:s');
      ChatRecordService::save(ChatRecordService::$table,$data);
      $data['type'] = 'chat';
      $data['fromname'] = $from_user['username'];
   		$gateway->sendToUid($to_uid, json_encode($data)); //发给对方 
   		// $gateway->sendToUid($data['from_uid'], json_encode($data)); //发给自己 
   		echo json_encode($data); 
   	}

    //接口-获取聊天记录
    public function actionAjaxGetRecord()
    {
      $page = MCore::get_var("page","0");
      $page_size = MCore::get_var("page_size","0");
      $page = $page? $page : 1;
      $page_size = $page_size? $page_size : 20;
      $session = \Yii::$app->session;
      $from_id = $session->get('user_id');
      $to_uid = MCore::get_var('to_id');
      $where_sql = '(from_id="'.$from_id.'" and to_id="'.$to_uid.'") or (from_id="'.$to_uid.'" and to_id="'.$from_id.'")';
      $data = ChatRecordService::get_list(ChatRecordService::$table,$where_sql,$page,$page_size,'create_time');
      foreach ($data as $k => $v) {
        $user_data = UserService::get_detail(UserService::$table,array('id'=>$v['from_id']));
        $data[$k]['username'] = $user_data['username'];
        if($v['from_id']==$from_id){
          $data[$k]['is_myself'] = '1';
        }else{
          $data[$k]['is_myself'] = '0';
        }
      }
      $total = ChatRecordService::get_total(ChatRecordService::$table,$where_sql);
      $total_page = ceil($total/$page_size);
      $ret['page'] = $page;
      $ret['total_page'] = $total_page;
      $ret['total'] = $total;
      $ret['list'] = $data;
      MCore::ajax_return(MCore::$return_code['SUCCESS'],$ret);
    }

    //接口-获取聊天记录100条
    public function actionAjaxGetFriendList()
    {
     
      $session = \Yii::$app->session;
      $user_id = $session->get('user_id');
      $where_sql = '(user_id="'.$user_id.' or friend_id="'.$user_id.'") and status="1"';
      $data = ChatRecordService::get_detail_by_where_sql(ChatRecordService::$table,$where_sql,'1');
      foreach ($data as $k => $v) {
        $user_data = UserService::get_detail(UserService::$table,array('id'=>$v['from_id']));
        $data[$k]['username'] = $user_data['username'];
        if($v['from_id']==$from_id){
          $data[$k]['is_myself'] = '1';
        }else{
          $data[$k]['is_myself'] = '0';
        }
      }
      $total = ChatRecordService::get_total(ChatRecordService::$table,$where_sql);
      $total_page = ceil($total/$page_size);
      $ret['page'] = $page;
      $ret['total_page'] = $total_page;
      $ret['total'] = $total;
      $ret['list'] = $data;
      MCore::ajax_return(MCore::$return_code['SUCCESS'],$ret);
    }

	//退出登录
    public function actionLogout()
    {
        $session = \Yii::$app->session;
        $session->set('user_id' , '');
        $session->set('user_id' , '');
        $session->set('username' , '');
        return $this->redirect('index.php?r=login/index');
    }

    //查找并发送好友请求
    public function actionAjaxFindUser()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $friend_id = MCore::get_not_empty_var('friend_id','请输入账号');
      $gateway = new Gateway(); 
      $return_data['type'] = 'friend_request';//好友请求
      $return_data['user_id'] = $uid;
      $return_data['username'] = $session->get('username');
      $return_data['message'] = '你好，我是'.$session->get('username').'，能加个好友吗？';
      $user_info = UserService::get_detail(UserService::$table,array('status'=>1,'user_id'=>$friend_id));

      if(!$user_info){
        MCore::ajax_return(array('code'=>500,'msg'=>'未找到用户，请核对输入'));
      }
      if($user_info['id']==$uid){
        MCore::ajax_return(array('code'=>500,'msg'=>'不能添加自己为好友'));
      }
      $friend_info = FriendService::get_detail_by_where_sql(FriendService::$table,'user_id="'.$uid.'" and friend_id="'.$user_info['id'].'" and status<>2');
      if($friend_info){
        if($friend_info['status']=='1'){
          MCore::ajax_return(array('code'=>500,'msg'=>'对方已经是你的好友'));
        }
        if($friend_info['status']=='0'){
          FriendService::update(FriendService::$table,$friend_info['id'],array('update_time'=>date('Y-m-d H:i:s')));
           
          $gateway->sendToUid($user_info['id'], json_encode($return_data)); //发给对方 
          MCore::ajax_return(array('code'=>0,'msg'=>'好友请求发送成功，等待对方确认'));
        }
      }else{
        $data['user_id'] = $uid;
        $data['friend_id'] = $user_info['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['type'] = 'friend_request';
        $data['message'] = '你好，我是'.$session->get('username').'，能加个好友吗？';
        $insert_id = FriendService::save(FriendService::$table,$data);
        if($insert_id){
          $gateway->sendToUid($user_info['id'], json_encode($return_data)); //发给对方
          MCore::ajax_return(array('code'=>0,'msg'=>'好友请求发送成功，等待对方确认'));
        }else{
          MCore::ajax_return(array('code'=>500,'msg'=>'发送失败，请重试'));
        }
      }
    }


    public function actionAjaxFriendRequestList()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $list = FriendService::get_detail(FriendService::$table,array('friend_id'=>$uid),'1','status,id desc');
      foreach ($list as $k => $v) {
        $user_info = UserService::get_detail(UserService::$table,array('id'=>$v['user_id']));
        $list[$k]['username'] = $user_info['username'];
        $list[$k]['friend_user_id'] = $user_info['user_id'];
      }

      return $this->render('friend_request_list',array('list'=>$list));
    }

    //删除好友
    public function actionAjaxDelFriend()
    {
      $friend_id = MCore::get_var('friend_id');

    }

    //退出
    public function actionQuit()
    { 
      $session = \Yii::$app->session;
      
      // Gateway::unbindUid($client_id, $session->get('user_id'));
      
      $session->set('user_id','');
      $session->set('username','');
      $this->redirect('index.php?r=login/index');
    }
}