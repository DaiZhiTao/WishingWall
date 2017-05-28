<?php

/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/21
 * Time: 13:53
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */
class IndexController{

    public function index(){
       include './View/user/index.html';
    }

    public function register(){
        include './View/user/register.html';
    }

}