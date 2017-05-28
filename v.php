<?php
/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/23
 * Time: 22:24
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */

session_start();

if(strtolower($_POST['data']) == strtolower($_SESSION['vcode'])){
    echo json_encode(["status"=>true]);
}else{
    echo json_encode(["status"=>false]);
}


?>