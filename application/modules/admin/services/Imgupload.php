<?php
class Admin_Service_Imgupload
{
    private $originFile;
    private $destFile;
    public function __construct(){
        
    }
    /**
     * 上传图片方法
     * @param unknown_type $data
     * @throws Exception
     */
    public function upload($data){
        try{
            $imgPath=$this->copyImg($data['img_name']);
            if(empty($imgPath)){
                throw new Exception('没有获得有效文件存放路径');
            }
            $data['path']=$imgPath;
            $this->saveData($data);
        }catch (Exception $e){
            $errorCode=$e->getCode();
            if(101!=$errorCode){
                unlink($this->destFile);
            }
            unlink($this->originFile);
            throw $e;
        }
    }
    /**
     * 更新图片信息
     * @param unknown_type $data
     */
    public function update($data){
        
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
    		if(rename($originFile, $destFile)){
    		    $this->thumbnails($destFile);
    		    return $imgDir.'/'.$imgName;
    		}else{
    		    throw new Exception('文件移动失败');
    		}
		}else{
		    //设定error code的目的是为了在捕获异常的时候做判断
		    throw new Exception('同名文件已经存在，请重命名上传文件','101');
		}
    }
    
    public function thumbnails($fileName){
        $thumbFileName=str_replace(DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR, $fileName);
        $fileInfo=pathinfo($thumbFileName);
        if(!is_dir($fileInfo['dirname'])){
			mkdir($fileInfo['dirname'],0777,true);
		}
		$svcImg=new Admin_Service_Img($fileName);
		$svcImg->createThumbNails($thumbFileName);
    }
    
    public function saveData(Array $data){
        $clImg=new Admin_Model_Class_Img();
        $clImg->addNewImg($data);
    }
}
?>