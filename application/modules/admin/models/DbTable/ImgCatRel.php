<?php

class Admin_Model_DbTable_ImgCatRel extends Zend_Db_Table_Abstract
{

    protected $_name = 'img_cat_rel';

    public function getImgCatInfos($imgId){
        $imgCatInfos=$this->_db->fetchAll('select a.*,b.* from img_cat_rel as a inner join img_cat_detail as b on a.cat_detailid=b.id where a.imgid=?',array($imgId));
        return $imgCatInfos;
    }
}

