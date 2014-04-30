<?php
class Admin_Model_Class_Img
{
    private $dbImg;
    public function __construct(){
        $this->dbImg=new Admin_Model_DbTable_Img();
    }
    /**
     * 添加新图片
     */
    public function addNewImg($data){
        //整理form表单传递过来的数组
        $fdata=array();
        $fdata['img']['path']=$data['path'];
        if(!empty($data['text'])){
            $fdata['img']['text']=$data['text'];
        }
        if(!empty($data['show_date'])){
            $fdata['img']['show_date']=$data['show_date'];
        }
        $fdata['img']['upload_time']=date('Y-m-d H:i:s',time());
        if(!empty($data['cats'])){
            $fdata['cats']=substr($data['cats'],0,-1);
        }
        $this->dbImg->addNewImg($fdata);
    }
    /**
     * 获取文件列表selecter
     * 主要用于列表分页
     */
    public function getImgListSelecter(){
        $selecter=$this->dbImg->getAdapter()->select()->from('img');
        return $selecter;
    }
    /**
     * 删除图片
     * @param unknown_type $imgId
     */
    public function deleteImg($imgId){
        $res=$this->dbImg->fetchRow(array('id=?'=>$imgId));
        if(count($res)==0){
            throw new Exception('图片不存在');
        }else{
            $this->dbImg->deleteImg($imgId);
            unlink(PUBLIC_PATH.'/images/resources/'.$res['path']);
        }
        
    }

}
?>