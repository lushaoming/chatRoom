<?php
/**
 * curl操作
 * Created by PhpStorm.
 * User: DH004
 * Date: 2017/8/23
 * Time: 15:26
 */
namespace app\service;
use app\service\BaseService;
class CurlService extends BaseService{

    /**
     * curl操作
     * @param string $url 接口地址
     * @return array 接口返回的数据
     */
    public static function curl_get($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // curl_setopt($ch, CURLOPT_POST, TRUE);

        $output = curl_exec($ch);
        // var_dump($output);exit;
        curl_close($ch);
        return json_decode($output,true);
    }


     /**
     * curl操作
     * @param string $url 接口地址
     * @return array 接口返回的数据
     */
    public static function curl_post($url,$params){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}