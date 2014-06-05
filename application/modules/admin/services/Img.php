<?php
class Admin_Service_Img
{
    private $img;
    private $canvas; //设置正方形canvas的宽和高 
    
    public function __construct($img,$w=180,$h=180){
        $this->setCanvas($w, $h);//默认canvas宽和高为180px
        $this->img=$img;
    }
    
    public function setCanvas($w,$h){
        $this->canvas['w']=$w;
        $this->canvas['h']=$h;
    }
    /**
     * 创建缩略图
     * Enter description here ...
     * @param unknown_type $thumbImg //缩略图存储路径
     */
    public function createThumbNails($thumbImg){
        list($width,$height,$type)=getimagesize($this->img);
        $imgObj=$this->createImgObj($type);
        $image_canvas = imagecreatetruecolor($this->canvas['w'],$this->canvas['h']);
        $bg=imagecolorallocate($image_canvas, 255, 255, 255);
        imagefilledrectangle($image_canvas,0,0,$this->canvas['w'],$this->canvas['h'],$bg);
        //背景的宽高比
        $cp=floatval($this->canvas['w']/$this->canvas['h']);
        //图片的宽高比
        $ip=floatval($width/$height);
        if($ip>=$cp){
            $newWidth=$this->canvas['w'];
            $newHeight=intval($newWidth*$height/$width);
            imagecopyresampled($image_canvas, $imgObj, 0, ($this->canvas['h']-$newHeight)/2, 0, 0, $newWidth, $newHeight, $width, $height);
        }else{
            $newHeight=$this->canvas['h'];
            $newWidth=intval($newHeight*$width/$height);
            imagecopyresampled($image_canvas, $imgObj, ($this->canvas['w']-$newWidth)/2,0, 0, 0, $newWidth, $newHeight, $width, $height);
            
        }
        
        $this->createImgFile($image_canvas, $type, $thumbImg);
        
    }
    /**
     * 根据图片的类型创建一个图片资源对象
     * Enter description here ...
     * @param unknown_type $type
     */
    public function createImgObj($type){
        if(IMAGETYPE_PNG==$type){
            return imagecreatefrompng($this->img);
        }elseif(IMAGETYPE_JPEG==$type){
            return imagecreatefromjpeg($this->img);
        }else{
            throw new Exception('图片类型只能为jpg和png');
        }
    }
    
    public function createImgFile($image,$type,$fileName){
        if(IMAGETYPE_PNG==$type){
            return imagepng($image,$fileName,9);
        }elseif(IMAGETYPE_JPEG==$type){
            return imagejpeg($image,$fileName,100);
        }else{
            throw new Exception('图片类型只能为jpg和png');
        }
    }
    
    
}
?>