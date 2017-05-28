<?php

/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/21
 * Time: 16:27
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */
class UserController extends CommonController
{
    /**
     * @var mixed   存储用户数据
     */
    private $userData;

    /**
     * UserController constructor.  获取用户数据
     */
    public function __construct(){
        $this->userData = include './Data/user.php';
    }

    /**
     *  处理用户登录
     */
    public function login(){
        if(IS_POST){
            //  遍历信息
            foreach ($this->userData as $k=>$v){
                //  匹配用户
                if($_POST['account'] == $v['account'] && md5($_POST['password'])==$v['password']){
                    //  匹配成功则将用户信息保存
                    $_SESSION['user'] = ['name'=>$v['nickname'],'account'=>$v['account']];
                    $this->success("登录成功",'index.php?c=msg&a=index');
                }
            }
           $this->error("密码错误!");
        }
    }

    public function register(){
        if(IS_POST){
            unset($_POST['password1']);
            $_POST['password'] = md5($_POST['password']);
            $this->userData[] = $_POST;
            $this->putData($this->userData,'./Data/user.php');
            $this->success("注册成功!",'index.php?c=index&a=index');
        }
    }

    public function logout(){
        if(isset($_SESSION['user'])){
            session_unset();
            session_destroy();
            $this->success("成功退出!",'index.php?c=index&a=index');
        }else{
            $this->error("您还没有登录!");
        }
    }


    public function checkAccount(){
        if (IS_POST){
            foreach ($this->userData as $v){
                if($v['account'] == $_POST['account']){
                    echo json_encode(['status'=>false]);
                    return;
                }
            }
            echo json_encode(['status'=>true]);
        }
    }

}