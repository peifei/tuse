<?php
class Admin_Service_Img
{
    private $img;
    private $canvas; //设置正方形canvas的宽和高 
    
    public function __construct($img){
        $this->canvas=180;//默认canvas宽和高为180px
        $this->img=$img;
    }
    
    public function setCanvas($canvas){
        $this->canvas=$canvas;
    }
    
public function createThumbNails(){
        list($width,$height,$type)=getimagesize($this->img);
        $imgObj=$this->createImgObj($type);
        $image_canvas = imagecreatetruecolor($this->canvas,$this->canvas);
        $bg=imagecolorallocate($image_canvas, 255, 255, 255);
        imagefilledrectangle($image_canvas,0,0,$this->canvas,$this->canvas,$bg);
        if($width>=$height){
            $newWidth=$this->canvas;
            $newHeight=intval($newWidth*$height/$width);
            imagecopyresampled($image_canvas, $imgObj, 0, ($this->canvas-$newHeight)/2, 0, 0, $newWidth, $newHeight, $width, $height);
        }else{
            $newHeight=$this->canvas;
            $newWidth=intval($newHeight*$width/$height);
            imagecopyresampled($image_canvas, $imgObj, ($this->canvas-$newWidth)/2,0, 0, 0, $newWidth, $newHeight, $width, $height);
        }
        $this->createImgFile($image_canvas, $type, $this->img);
        
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
            return imagepng($image,$fileName,100);
        }elseif(IMAGETYPE_JPEG==$type){
            return imagejpeg($image,$fileName,100);
        }else{
            throw new Exception('图片类型只能为jpg和png');
        }
    }
    
    
}
?>