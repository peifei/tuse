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
    /**
     * 向临时书筐中添加图片
     * @param unknown_type $imgId
     */
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
    /**
     * 取得临时图片列表
     * Enter description here ...
     */
    public function getTmpImgs(){
        $res=$this->dbTmpBook->fetchAll(null,'order asc');
        return $res;
    }
    /**
     * 清除临时图片
     * Enter description here ...
     */
    public function clearTmpImgs(){
        $res=$this->dbTmpBook->getDefaultAdapter()->query('truncate tmp_book')->execute();
    }
    
    public function getTop5KeyWords(){
        
    }
}
?>