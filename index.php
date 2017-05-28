<?php
/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/21
 * Time: 12:48
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */
session_start();

include 'functions.php';

function __autoload($name){
  include "./Controller/{$name}.php";
}

$c = isset($_GET['c'])?$_GET['c']:'index';

$c = ucfirst($c)."Controller";

$class = new $c();

$a = isset($_GET['a'])?$_GET['a']:'index';

$class->$a();
?>
