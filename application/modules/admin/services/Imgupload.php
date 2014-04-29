<?php
class Admin_Service_Imgupload
{
    private $originFile;
    private $destFile;
    public function __construct(){
        
    }
    
    public function upload($data){
        try{
            $imgPath=$this->copyImg($data['img_name']);
            if(empty($imgPath)){
                throw new Exception('没有获得有效文件存放路径');
            }
            $data['path']=$imgPath;
            $this->saveData($data);
            unlink($this->originFile);
        }catch (Exception $e){
            unlink($this->destFile);
            throw $e;
        }
    }
    /**
     * 将图片从临时路径拷贝到存放路径
     * @param unknown_type $imgName
     */
    public function copyImg($imgName){
        $originFile=PUBLIC_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$imgName;
        $this->originFile=$originFile;
        $imgDir=date('Ym',time());
        $destPath=PUBLIC_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.$imgDir.DIRECTORY_SEPARATOR;
        if(!is_dir($destPath)){
			mkdir($destPath,0777,true);
		}
		$destFile=$destPath.$imgName;
		$this->destFile=$destFile;
		//检测同名文件是否已经存在
		if(!file_exists($destFile)){
    		if(copy($originFile, $destFile)){
    		    return $imgDir.'/'.$imgName;
    		}else{
    		    throw new Exception('文件移动失败');
    		}
		}else{
		    throw new Exception('同名文件已经存在，请重命名上传文件');
		}
    }
    
    public function thumbnails(){
        
    }
    
    public function saveData(Array $data){
        $clImg=new Admin_Model_Class_Img();
        $clImg->addNewImg($data);
    }
}
?>