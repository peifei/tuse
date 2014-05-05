<?php

class Admin_Model_DbTable_Img extends Zend_Db_Table_Abstract
{

    protected $_name = 'img';
    
    public function addNewImg($data){
        $db=$this->_db;
        $db->beginTransaction();
        try{
            $imgId=$this->insert($data['img']);
            if(isset($data['cats'])){
                $tempArr=explode(',', $data['cats']);
                $fdata=array();
                foreach ($tempArr as $arr){
                    $fdata[]=array('imgid'=>$imgId,'cat_detailid'=>$arr);
                }
                $clImgCatRel=new Admin_Model_Class_ImgCatRel();
                $clImgCatRel->addImgCatRels($fdata);
            }
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw new Exception('数据库存储数据异常');
        }
    }
    
    public function updateImg($data){
        $db=$this->_db;
        $db->beginTransaction();
        try{
            $this->update($data['img'],array('id=?'=>$data['img']['id']));
            $imgId=$data['img']['id'];
            $clImgCatRel=new Admin_Model_Class_ImgCatRel();
            $clImgCatRel->removeCatRels($imgId);
            if(!empty($data['cats'])){
                $tempArr=explode(',', $data['cats']);
                $fdata=array();
                foreach ($tempArr as $arr){
                    $fdata[]=array('imgid'=>$imgId,'cat_detailid'=>$arr);
                }
                $clImgCatRel->addImgCatRels($fdata);
            }
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw new Exception('数据库存储数据异常');
        }
    }
    
    
    public function deleteImg($imgId){
        $db=$this->_db;
        $db->beginTransaction();
        try{
            $db->delete($this->_name,array('id=?'=>$imgId));
            $db->delete('img_cat_rel',array('imgid=?'=>$imgId));
            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }
    }

}

