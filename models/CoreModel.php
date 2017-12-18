<?php
/**
*核心类，包含一些统一标准的方法
*@author echo
*@date 2017-08-18
*/
namespace app\models;

class CoreModel
{

	public static $return_code = array(
        'SUCCESS'           =>array('code'=>'0','msg'=>'成功'),
        'FAIL'              =>array('code'=>'-1','msg'=>'失败'),
        'EMPTY_PARAMETER'   =>array('code'=>'-30001','msg'=>'参数不能为空'),
        'ERROR_CODE'        =>array('code'=>'-30002','msg'=>'验证码不正确'),
        'LOGIN_FAIL'        =>array('code'=>'-30003','msg'=>'账号不存在或密码错误'),
        'TYPE_ERROR'        =>array('code'=>'-30004','msg'=>'图片格式错误'),
        'MAX_SIZE_LIMIT'        =>array('code'=>'-30004','msg'=>'上传文件超出最大限制'),
        'NO_IMAGE_ERROR'        =>array('code'=>'-30005','msg'=>'请选择一张图片'),
        'EMPTY_TITLE'        =>array('code'=>'-30006','msg'=>'标题不能为空'),
        'EMPTY_CONTENT'        =>array('code'=>'-30007','msg'=>'内容不能为空'),
        'EMPTY_TAGS'        =>array('code'=>'-30008','msg'=>'标签不能为空'),
        
    );

    public static $FILES_SAVE_PATH = 'upload_images';//上传文件的保存路径
    public static $prefix_path = 'http://www.ifour.net.cn/blog/blog_admin/basic/web/';//上传文件保存地址前缀

    /**
     * 获取请求值
     * @param  string $key         请求的key名
     * @param  string $check_empty 是否检查为空
     * @return 请求值
     */
	public static function get_var($key,$check_empty='1')
    {
        if($check_empty && ( !isset($_REQUEST[$key]) || !$_REQUEST[$key] ) ){
            MCore::ajax_return(MCore::$return_code['EMPTY_PARAMETER']);
        }
        $ret = '';
        if(isset($_REQUEST[$key])){
            $ret = addslashes($_REQUEST[$key]);
        }
        return $ret;
    }

    /**
     * 返回json格式字符串
     * @param  array $res  需要返回的状态码和提示信息
     * @param  array $data 需要返回的数据
     * @return string      返回json
     */
    public static function ajax_return($res,$data=array())
    {
        $return_data['status'] = $res['code'];
        $return_data['msg'] = $res['msg'];
        if($data){
            $return_data['data'] = $data;
        }else{
            $return_data['data'] = array();
        }
        echo json_encode($return_data);
        exit;
    }

    /**
     * 数组转字符串
     * @param  array $arr 数组
     * @return string     转换后的字符串
     */
    public static function array2string($arr)
    {
        $return = var_export($arr,TRUE);
        return $return;
    }

    /**
     * 字符串转数组
     * @param  string $data 字符串
     * @return array  转换后的数组
     */
    public static function string2array($data) 
    {
        if($data == '') return array();
        @eval("\$array = $data;");
        return $array;
    }

    /**
     * alert提示，并跳转
     * @param  string $msg 提示
     * @param  string $url 跳转链接
     * @return 
     */
    public static function show_msg($msg,$url)
    {
        echo "<script>alert(\"".$msg."\")</script>";
        echo "<script>location.href='".$url."'</script>";
        exit;
    }

    /**
     * alert提示，并返回上一页（不刷新）
     * @param  string $msg 提示
     * @return 
     */
    public static function show_msg_go_back($msg)
    {
        echo "<script>alert(\"".$msg."\")</script>";
        echo "<script>window.history.go(-1)</script>";
        exit;
    }

    /**
     * 获取数组的数据
     * @param  array  $data    数据
     * @param  string $params  数据的键值
     */
    public static function get($data,$params)
    {
        return isset($data[$params])?$data[$params]:'';
    }

    /**
     * 检测数组数据是否为空
     * @param  array $data 数组数据
     */
    public static function check_empty($data)
    {
        if(is_array($data)){
            foreach ($data as $key => $val) {
                if(!is_array($val)){
                    if(!$val){
                        MCore::show_msg_go_back($key."不能为空");
                    }
                }
            }
        }
        
    }

    /**
     * 下载文件
     * @param  string $filename 文件路径
     */
    public static function download_file($filename)
    {
        header("content-Type: text/html; charset=utf-8");
        header('Content-Description: File Transfer'); 
        header('Content-Type: application/octet-stream'); 
        header('Content-Disposition: attachment; filename='.basename($filename)); 
        header('Content-Transfer-Encoding: binary'); 
        header('Expires: 0'); 
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
        header('Pragma: public'); 
        header('Content-Length: ' . filesize($filename)); 
        ob_clean(); 
        flush(); 
        readfile($filename); 
        exit; 
    }



}