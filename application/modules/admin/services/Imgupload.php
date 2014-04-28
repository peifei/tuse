<?php
class Admin_Service_Imgupload
{
    public function __construct(){
        
    }
    
    public function upload(){
        
    }
    /**
     * 将图片从临时路径拷贝到存放路径
     * @param unknown_type $imgName
     */
    public function copyImg($imgName){
        $originFile=PUBLIC_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$imgName;
        $destPath=PUBLIC_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.date('Ym',time()).DIRECTORY_SEPARATOR;
        if(!is_dir($destPath)){
			mkdir($destPath,0777,true);
		}
		$destFile=$destPath.$imgName;
		//检测同名文件是否已经存在
		if(!file_exists($destFile)){
    		if(rename($originFile, $destFile)){
    		    return true;
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
        
    }
}
?>