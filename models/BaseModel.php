<?php
/**
 * 基类
 * @author echo
 * @date 2017-08-18
 */
namespace app\models;

use Yii;

class BaseModel
{

	/**
     * 获取详情byid
     * @param  string $table  表
     * @param  int    $id     id
     * @return array  数据
     */
	public static function get_detail_by_id($table,$id)
	{
		$sql = "select * from ".$table." where id ='".$id."' limit 1";
    	$one = Yii::$app->db->createCommand($sql)->queryOne();
    	return $one;
	}

	/**
     * 获取详情，根据sql
     * @param  string $table  表
     * @param  array  $data   搜索条件
     * @param  string $order      排序
     * @return array  数据
     */
	public static function get_detail($table,$data,$query_all = '0',$order='')
	{
		$order_by = "";
		if($order){
			$order_by = " order by ".$order;
		}
		$where = array();
		foreach ($data as $k => $v) {
			$where[] = $k."='".addslashes($v)."'";
		}
		$where = implode(" and ", $where);
		$sql = " select * from ".$table." where ".$where." ".$order_by;
		// echo $sql;exit;
		if($query_all){
			return Yii::$app->db->createCommand($sql)->queryAll();
		}else{
			return Yii::$app->db->createCommand($sql)->queryOne();
		}
	}

	/**
     * 获取详情，根据sql
     * @param  string $table  表
     * @param  string $where_sql  搜索条件
     * @param  string $order      排序
     * @return array  数据
     */
	public static function get_detail_by_where_sql($table,$where_sql,$query_all = '0',$order='')
	{
		$order_by = "";
		if($order){
			$order_by = " order by ".$order;
		}
		$sql = " select * from ".$table." where ".$where_sql." ".$order_by;
		if($query_all){
			return Yii::$app->db->createCommand($sql)->queryAll();
		}else{
			return Yii::$app->db->createCommand($sql)->queryOne();
		}
	}

	/**
     * 获取列表
     * @param  string $table      表
     * @param  string $where_sql  查询sql
     * @param  int    $page       页码
     * @param  int    $page_size  每页大小
     * @param  string $order      排序
     * @return array  数据
     */
	public static function get_list($table,$where_sql,$page,$page_size=10,$order='')
	{
		$order_by = " id desc ";
		if($order){
			$order_by = $order;
		}
		$sql = "select * from ".$table." where ".$where_sql." order by ".$order_by." limit ".(($page-1)*$page_size).",".$page_size."";
    	$data = Yii::$app->db->createCommand($sql)->queryAll();
		return $data;
	}

	/**
     * 获取总数，根据条件
     * @param  string  $table      表
     * @param  string  $where_sql  查询sql
     * @return string  总数
     */
	public static function get_total($table,$where_sql)
	{
		$sql = "select count(*) as total from ".$table." where ".$where_sql." ";
		// echo ($sql);exit;
    	$res = Yii::$app->db->createCommand($sql)->queryOne();
		return $res['total'];
	}

	/**
     * 新增
     * @param  string $table               表
     * @param  array  $insert_data         插入数据
     * @param  int    $insert_create_time  是否插入create_time时间，1-是，0-否
     * @return int    最后插入记录的id
     */
	public static function save($table,$insert_data,$insert_create_time=1)
	{
		date_default_timezone_set('PRC'); // 中国时区

		if($insert_create_time){
			$insert_data['create_time'] = date("Y-m-d H:i:s");
		}

		foreach ($insert_data as $k => $v) {
			$fields[] = $k;
			$values[] = "'".addslashes($v)."'";
		}
		$field = implode(",", $fields);
		$value = implode(",", $values);
		$sql = " insert into ".$table." ( ".$field." ) VALUES ( ".$value." ) ";
		//echo $sql;exit;;
		Yii::$app->db->createCommand($sql)->execute();
		return Yii::$app->db->getLastInsertID();
	}

	/**
     * 更新
     * @param  string $table        表
     * @param  int    $id           id
     * @param  array  $update_data  更新数据
     * @return 
     */
	public static function update($table,$id,$update_data)
	{

		$update_sql = array();
		foreach ($update_data as $k => $v) {
			$update_sql[] = $k."='".addslashes($v)."'";
		}
		$update_sql = implode(",", $update_sql);
		$sql = " update ".$table." set ".$update_sql." where id='".$id."' ";
		Yii::$app->db->createCommand($sql)->execute();
	}

	/**
     * 更新，根据条件
     * @param  string $table        表
     * @param  array  $where_data   搜索条件
     * @param  array  $update_data  更新数据
     * @return 
     */
	public static function update_all($table,$where_data,$update_data)
	{

		$update_sql = array();
		foreach ($update_data as $k => $v) {
			$update_sql[] = $k."='".addslashes($v)."'";
		}
		$update_sql = implode(",", $update_sql);

		$where = array();
		foreach ($where_data as $k => $v) {
			$where[] = $k."='".addslashes($v)."'";
		}
		$where = implode(" and ", $where);

		$sql = " update ".$table." set ".$update_sql." where ".$where;

		Yii::$app->db->createCommand($sql)->execute();
	}

	/**
     * 更新，根据条件
     * @param  string $table        表
     * @param  array  $where_data   搜索条件
     * @param  array  $update_data  更新数据
     * @return 
     */
	public static function update_all2($table,$where_data,$update_data)
	{

		$update_sql = array();
		foreach ($update_data as $k => $v) {
			$update_sql[] = $k."=".addslashes($v)."";
		}
		$update_sql = implode(",", $update_sql);

		$where = array();
		foreach ($where_data as $k => $v) {
			$where[] = $k."='".addslashes($v)."'";
		}
		$where = implode(" and ", $where);

		$sql = " update ".$table." set ".$update_sql." where ".$where;

		Yii::$app->db->createCommand($sql)->execute();
	}

	/**
     * 删除
     * @param  string $table        表
     * @param  int    $id           id
     * @param  array  $update_data  更新数据
     * @return 
     */
	public static function delete($table,$id)
	{
		$sql = " delete from ".$table." where id='".$id."' ";
		Yii::$app->db->createCommand($sql)->execute();
	}

	/**
     * 删除，根据条件
     * @param  string $table 表
     * @param  array  $data  条件数据
     * @return 
     */
	public static function delete_all($table,$data)
	{
		$delete_sql = array();
		foreach ($data as $k => $v) {
			$delete_sql[] = $k."='".addslashes($v)."'";
		}
		$delete_sql = implode(" and ", $delete_sql);
		$sql = " delete from ".$table." where ".$delete_sql;
		Yii::$app->db->createCommand($sql)->execute();
	}

	/**
	 * 搜索条件数组 转 搜索条件sql
	 * @param  array  $where_data 搜索条件数组
	 * @return string 搜索条件sql
	 */
	public static function where_data_to_where_sql($where_data)
	{
		$where = array();
		foreach ($where_data as $k => $v) {
			$where[] = $k."='".addslashes($v)."'";
		}
		$where_sql = implode(" and ", $where);
		return $where_sql;
	}



}