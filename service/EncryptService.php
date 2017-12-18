<?php
/**
* 加密和解密
*/
namespace app\service;
class EncryptService
{
	/**
	 * 加密算法
	 * @param   string   $data   需要加密的字符串
	 * @param   string   $key    加密密钥
	 * @return  string           加密后的字符串
	 */
	function encrypt($data, $key)
	  {
	      $key    =    md5($key);
	      $x        =    0;
	      $len    =    strlen($data);
	      $l        =    strlen($key);
	      $char = '';
	      $str = '';
	      for ($i = 0; $i < $len; $i++)
	      {
	          if ($x == $l) 
	         {
	             $x = 0;
	         }
	         $char .= $key{$x};
	         $x++;
	     }
	     for ($i = 0; $i < $len; $i++)
	     {
	         $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
	     }
	     return base64_encode($str);
	 }

	 /**
	 * 解密算法
	 * @param   string   $data   需要解密的加密字符串
	 * @param   string   $key    加密密钥
	 * @return  string           解密后的字符串
	 */
	 function decrypt($data, $key)
	  {
	      $key = md5($key);
	      $x = 0;
	      $data = base64_decode($data);
	      $len = strlen($data);
	      $l = strlen($key);
	      $char = '';
	      $str = '';
	      for ($i = 0; $i < $len; $i++)
	      {
	         if ($x == $l) 
	         {
	             $x = 0;
	         }
	         $char .= substr($key, $x, 1);
	         $x++;
	     }
	     for ($i = 0; $i < $len; $i++)
	     {
	         if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
	         {
	             $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
	         }
	         else
	         {
	             $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
	         }
	     }
	     return $str;
	 }
}