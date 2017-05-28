<?php

/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/21
 * Time: 13:37
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */
class MsgController extends CommonController {

    private $hopes;

    public function __construct(){
        $this->hopes = include "./Data/hopes.php";
    }

    public function index(){
        if(isset($_SESSION['user'])){
            include './View/msg/index.html';
        }else{
            $this->error("请您先登录!");
        }
    }

    public function add(){
        if(IS_POST){

            $upload = new FileController();

            $_POST['name'] = $_SESSION['user']['name'] ;
            $_POST['account'] = $_SESSION['user']['account'] ;
            $_POST['time'] = time();
            $_POST['pic-path'] = "./Public/img/".date("Ymd")."/".current($_FILES)['name'];
            $this->hopes[] = $_POST;
            $this->putData($this->hopes,'./Data/hopes.php');
            $upload->setIsRandomName(false);
            $upload->setPath('./Public/img/');
            $upload->uploadFile();

            $key = array_keys($this->hopes);
            echo json_encode(["title"=>$_POST['title'],'name'=>$_POST['name'],"content"=>$_POST['content'],"time"=>$_POST['time'],"path"=>$_POST['pic-path'],'id'=>end($key)]);
        }
    }


    public function edit(){
        if(IS_POST){

            $upload = new FileController();

            $this->hopes[$_GET['index']]['title'] = $_POST['title'];
            $this->hopes[$_GET['index']]['content'] = $_POST['content'];
//            unlink($this->hopes[$_GET['index']]['pic-path']);
            $_POST['pic-path'] = "./Public/img/".date("Ymd")."/".current($_FILES)['name'];
            $this->hopes[$_GET['index']]['pic-path'] = $_POST['pic-path'];
            $this->putData($this->hopes,'./Data/hopes.php');
            $upload->setIsRandomName(false);
            $upload->setPath('./Public/img/');
            $upload->uploadFile();

            $key = array_keys($this->hopes);
            echo json_encode(["title"=>$_POST['title'],'name'=>$this->hopes[$_GET['index']]['name'],"content"=>$_POST['content'],"time"=>$this->hopes[$_GET['index']]['time'],"path"=>$_POST['pic-path'],'id'=>end($key)]);
        }
    }

    public function delete(){
        if(IS_POST){

            unset($this->hopes[$_POST['index']]);
            $this->putData($this->hopes,'./Data/hopes.php');

            echo json_encode(["status"=>true]);
        }
    }
}