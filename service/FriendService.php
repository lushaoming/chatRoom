<?php
/**
* 用户管理
*/
namespace app\service;
use Yii;
use app\service\BaseService;
class FriendService extends BaseService
{
	
	public static $table = 'friend_list';

	public static function get_total_friends($uid)
	{
		$sql = "select count(*) as total from friend_list
				where status=1
				and (user_id=".$uid." or friend_id=".$uid.")";
		$res = Yii::$app->db->createCommand($sql)->queryOne();
		return $res['total'];
	}
}