<?php
/**
 * 验证格式类
 * @author Echolove4 
 * @date 2017-07-20
 */
namespace app\service;
class Validate
{
    // 验证中英文数字格式
    public static function cn_word_or_en_word_or_number($str)
    {
        if(preg_match('/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u',$str)) return true;  
        else return false;  
    }

    // 验证中英文格式
    public static function cn_word_or_en_word($str)
    {
        if(preg_match('/^[a-zA-Z_\x{4e00}-\x{9fa5}]+$/u',$str)) return true;  
        else return false;  
    }

    // 验证英文数字格式
    public static function en_word_or_number($str)
    {
        if(preg_match('/^[0-9a-zA-Z_]+$/u',$str)) return true;  
        else return false;  
    }

    // 验证邮件格式  
    public static function email($str){  
        if(preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $str)) return true;  
        else return false;  
    }  
  
    // 验证身份证  
    public static function idcode($str){  
        if(preg_match("/^\d{14}(\d{1}|\d{4}|(\d{3}[xX]))$/", $str)) return true;  
        else return false;  
    }  
  
    // 验证http地址  
    public static function http($str){  
        if(preg_match("/[a-zA-Z]+:\/\/[^\s]*/", $str)) return true;  
        else return false;  
    }  
  
    //匹配QQ号(QQ号从10000开始)  
    public static function qq($str){  
        if(preg_match("/^[1-9][0-9]{4,}$/", $str)) return true;  
        else return false;  
    }  
  
    //匹配中国邮政编码  
    public static function postcode($str){  
        if(preg_match("/^[1-9]\d{5}$/", $str)) return true;  
        else return false;  
    }  
  
    //匹配ip地址  
    public static function ip($str){  
        if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $str)) return true;  
        else return false;  
    }  
  
    // 匹配电话格式  
    public static function telephone($str){  
        if(preg_match("/^\d{3}-\d{8}$|^\d{4}-\d{7}$/", $str)) return true;  
        else return false;  
    }  
  
    // 匹配手机格式  
    public static function mobile($str){  
        if(preg_match("/^(13[0-9]|15[0-9]|18[0-9])\d{8}$/", $str)) return true;  
        else return false;  
    }  
  
    // 匹配26个英文字母  
    public static function en_word($str){  
        if(preg_match("/^[A-Za-z]+$/", $str)) return true;  
        else return false;  
    }  
  
    // 匹配只有中文  
    public static function cn_word($str){  
        if(preg_match("/^[\x80-\xff]+$/", $str)) return true;  
        else return false;  
    }  
  
    // 验证账户(字母开头，由字母数字下划线组成，4-20字节)  
    public static function user_account($str){  
        if(preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,19}$/", $str)) return true;  
        else return false;  
    }  
  
    // 验证数字  
    public static function number($str){  
        if(preg_match("/^[0-9]+$/", $str)) return true;  
        else return false;  
    } 

    // 验证正浮点数
    public static function float_number($str){
        if(preg_match("/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/", $str)) return true; 
        else return false;  
    }










}