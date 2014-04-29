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
            throw $e;
            //throw new Exception('数据库存储数据异常');
        }
    }


}

