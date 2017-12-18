<?php
/**
* 图集类型
*/
namespace app\service;
use app\service\BaseService;
class ImageTypeService extends BaseService
{
	
	public static $table = 'img_type';

	public static function get_total_group_by_id($ids)
	{
		$sql = "select count(*) as total 
				from img_type
				where status='1'
				and id in (".$ids.")
				group by id
				order by id desc";
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
}