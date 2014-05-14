<?php
class Admin_Model_Class_TmpBook
{
    private $dbTmpBook;
    public function __construct(){
        $this->dbTmpBook=new Admin_Model_DbTable_TmpBook();
    }
    /**
     * 取得当前临时书筐中的图片数量
     * Enter description here ...
     */
    public function getImgNum(){
        return $this->dbTmpBook->getImgNum();
    }
    
    public function addNewImg($imgId){
        $clImg=new Admin_Model_Class_Img();
        $imgInfo=$clImg->getImgInfoById($imgId);
        $data=array();
        $data['img_id']=$imgId;
        $data['img_path']=$imgInfo['path'];
        $data['order']=$this->getImgNum()+1;
        $this->dbTmpBook->insert($data);
        return $imgInfo;
    }
    
    public function getTmpImgs(){
        $res=$this->dbTmpBook->fetchAll(null,'order asc');
        return $res;
    }
}
?>