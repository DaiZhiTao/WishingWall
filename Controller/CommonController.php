<?php
/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/21
 * Time: 13:38
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */

class CommonController{

    /*
     *  成功的提示方法
     */

    public function success($msg,$url){
        echo '<script>';
        echo "alert('{$msg}');";
        echo "location.href = '{$url}';";
        echo '</script>';
        die();
    }

    /*
     *  失败的提示方法
     */

    public function error($msg){
        echo "<script>";
        echo "alert('{$msg}');";
        echo "history.go(-1);";
        echo "</script>";
        die();
    }

    /*
     *  写入数据方法
     */
    public function putData($data,$path){
        //  合法化变量
        $str = var_export($data,true);
        //  写入文件
        file_put_contents($path,"<?php\r\n return $str;?>");
    }
}

?>