<?php
/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/14
 * Time: 7:43
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */
//多文件上传类
class FileController
{
    //  默认保存目录
    private $path = './uploads';
    //  指定上传文件被允许的大小 默认为10M
    private $size = 10485760;
    //  设置上传后的文件是否使用原文件名    默认为true
    private $isRandomName = true;
    //  是否限制格式 默认不限制
    private $limitType = [];
    //  返回的错误
    private $error = [];
    /**
     * @param string $path
     *      设置保存路径
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param int $size
     *      设置上传文件允许的大小
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param bool $isRandomName
     *      设置是否使用原文件名
     */
    public function setIsRandomName($isRandomName)
    {
        $this->isRandomName = $isRandomName;
    }

    /**
     * @param array $limitType
     *      是否有限制的类型
     */
    public function setLimitType(array $limitType)
    {
        $this->limitType = $limitType;
    }


    //  重组文件数组
    private function resetFileArr()
    {
        //获取文件信息数组
        $files = current($_FILES);
        //重新创建一个保存信息的数组
        $arr = [];
        //遍历数组
        if(is_array($files['name'])){
            foreach ($files['name'] as $k => $v) {
                //判断上传文件是否合法
                if (is_uploaded_file($files['tmp_name'][$k])) {
                    //  获取文件后缀名
                    $suffix = ltrim(strrchr($files['name'][$k],'.'),'.');
                    //  判断该文件类型是否被限制
                    if(in_array($suffix,$this->limitType)){
                        //  将错误信息存入数组
                        $this->error[$k] = "{$files['name'][$k]}文件类型不被支持";
                        continue;
                    }
                    if($files['size'][$k]>$this->size){
                        //  将错误信息存入数组
                        $this->error[$k] = "{$files['name'][$k]}文件大小超过限制";
                        continue;
                    }
                    //  将信息存入数组
                    $arr[] = [
                        'name'=>$files['name'][$k],
                        'type'=>$files['type'][$k],
                        'tmp_name'=>$files['tmp_name'][$k],
                        'error'=>$files['error'][$k],
                        'size'=>$files['size'][$k]
                    ];
                }
            }
        }else{
            $arr[] = $files;
        }
        return $arr;
    }

    //  上传文件
    public function uploadFile()
    {
        //  接受返回的文件数组信息
        $files = $this->resetFileArr();
        //  判断目录是否已存在   如果不存在则创建
        $this->path = $this->path."/".date('Ymd');
        is_dir($this->path)||mkdir($this->path,0777,true);
        //  遍历文件数组
        foreach ($files as $k=>$v){
                //  文件的完整路径
                $filename = $this->isRandomName?mt_rand().".".ltrim(strrchr($v['name'],'.'),'.'):$v['name'];
                $filename = $this->path."/{$filename}";
                //移动指定的文件
                move_uploaded_file($v['tmp_name'],$filename);
        }
        //  当错误非空时  返回true 否则将错误数组返回
        return is_null($this->error)?true:$this->error;
    }
}
?>