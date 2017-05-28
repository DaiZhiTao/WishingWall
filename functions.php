<?php
/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/10
 * Time: 15:09
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */

//头部编码设置
header('Content-Type:text/html;charset=utf-8');

//  设置默认时区

date_default_timezone_set("PRC");

//常量定义

define('IS_POST',($_SERVER['REQUEST_METHOD']=='POST')?true:false);



//  打印函数
/**
 * @param $data     需要打印的数据
 *
 * 根据不同的数据类型   以不同的方式输出
 */
function p($data){
    echo '<pre style="background: #aaa;font-size:24px;border-radius: 6px;padding: 20px">';
    if(is_array($data)||is_object($data)||is_bool($data)){
        var_dump($data);
    }else{
        print_r($data);
    }
    echo '</pre>';
}


//提示信息
/**
 * @param $msg  提示信息
 * @param $url  跳转地址
 */
function message($msg,$url){
    echo "<script>";
    echo "alert('$msg');";
    echo "location.href = '$url';";
    echo "</script>";
}



?>
