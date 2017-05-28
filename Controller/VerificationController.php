<?php

/**
 * Created by PhpStorm.
 * User: Dito
 * Date: 2017/4/18
 * Time: 21:03
 * QQ : 1207916218
 * Email : m13007230048@163.com
 */

session_start();

class VerificationController
{
    //  验证码的宽度
    private $width;
    //  验证码的高度
    private $height;
    //  验证码的字符数目
    private $codeNum;
    //  干扰点的数目
    private $pointNum;
    //  干扰线的数目
    private $lineNum;
    //  验证码字符
    private $code;
    //  验证码资源
    private $image;
    //  验证码字符字体url
    private $path;
    //  验证码字符大小
    private $fontsize;

    private $chars;
    //  构造函数

    /**
     * VerificationCode constructor.
     * @param null $width   验证码的宽度  默认为200
     * @param null $height      验证码的高度  默认为100
     * @param null $codeNum     验证码的字符数  默认为4
     * @param null $pointNum       验证码中干扰点的数目  默认为1500
     * @param null $lineNum         验证码中干扰线的数目  默认为5
     * @param null $code           验证码字符的来源  默认为大小写字母和数字
     * @param null $image       验证码资源  用于释放
     * @param null $path        验证码字体的路径  默认为当前路径下的font文件夹
     * @param null $fontsize        验证码的字体大小
     */
    public function __construct($width=null,$height=null,$codeNum=null,$pointNum=null,$lineNum=null,$code=null,$image=null,$path=null,$fontsize=null)
    {
        //  判断  为空则设置值   否则设置为传递的值
        $this->width = is_null($width)?200:$width;
        $this->height = is_null($height)?100:$height;
        $this->codeNum = is_null($codeNum)?4:$codeNum;
        $this->pointNum = is_null($pointNum)?1500:$pointNum;
        $this->lineNum = is_null($lineNum)?5:$lineNum;
        $this->code = is_null($code)?"zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP12314567890":$code;
        $this->image = is_null($image)?imagecreatetruecolor($this->width,$this->height):$image;
        $this->path = is_null($path)?'./Public/font/FZZZHONGJW.TTF':$path;
        $this->fontsize = is_null($fontsize)?40:$fontsize;
        //  设置头部信息
        header('Content-type:image/jpeg');
    }

    //  生成随机颜色

    /**
     * @return int  返回分配的颜色
     */
    private function getRandColor(){
        $color = imagecolorallocate($this->image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        return $color;
    }


    //  生成字符

    /**
     * @return string  将生成的验证码字符返回   以便比较
     */
    private function getChars(){
        //  创建一个字符串用来保存生成的验证码   以便验证
        $chars = "";
        for ($i=0;$i<$this->codeNum;$i++){
            //  每个字符的x坐标
            $x = ($this->width/$this->codeNum)*$i+($this->width/$this->codeNum-$this->fontsize);
            //  每个字符的y的坐标
            $y = ($this->height/2)+10;
            //  获取颜色
            $color = $this->getRandColor();
            $text = $this->code[mt_rand(0,strlen($this->code)-1)];
            $chars .= $text;
            imagettftext($this->image,$this->fontsize,mt_rand(-45,45),$x,$y,$color,$this->path,$text);
        }
       return $chars;
    }

    //  生成干扰点

    /**
     * 生成若干的干扰点
     */
    private function getDisturbPoint(){
        for($i=0;$i<$this->pointNum;$i++){
            $color = $this->getRandColor();
            imagesetpixel($this->image,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }

    //  生成干扰线

    /**
     * 生成若干的干扰线
     */
    private function getDisturbLine(){
        for($i=0;$i<$this->lineNum;$i++){
            $color = $this->getRandColor();

            imageline($this->image,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }


    /**
     *  总方法   用来生成整个验证码
     */
    public function getValidationCode(){
        //  分配白色
        $white = imagecolorallocate($this->image,255,255,255);
        //  将画布填充为白色
        imagefill($this->image,0,0,$white);
        //  生成并获取产生的随机字符
        $chars = $this->getChars();
        //  生成干扰点
        $this->getDisturbPoint();
        //  生成干扰线
        $this->getDisturbLine();
        //  将生成的图片输出
        ob_clean();
        imagejpeg($this->image);
//        setcookie('codes',$chars,time()+3600,'/');
        $_SESSION['vcode'] = $chars;
    }


    //  析构函数

    /**
     *  释放验证码资源
     */
    public function __destruct()
    {
        imagedestroy($this->image);
    }
}
//$c = new VerificationCode();
//$c->getValidationCode();