<?php
/**
 * 基类
 * @author echo
 * @date 2017-08-18
 */
namespace app\models;

use Yii;
use app\models\BaseModel;

class SigninModel extends BaseModel
{
	public static $table = 'sign';

	public static function get_num_list()
	{
		$sql = "select blog_id,count(*) as num 
				from comment
				 
				group by blog_id 
				order by num desc 
				limit 10";
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
}
