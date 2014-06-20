<?php

class Admin_Model_DbTable_ImgCatRel extends Zend_Db_Table_Abstract
{

    protected $_name = 'img_cat_rel';

    public function getImgCatInfos($imgId){
        $imgCatInfos=$this->_db->fetchAll('select a.*,b.* from img_cat_rel as a inner join img_cat_detail as b on a.cat_detailid=b.id where a.imgid=?',array($imgId));
        return $imgCatInfos;
    }
    
    /**
     * 取得多个图片按标签分组后的标签集合
     * 用户自动生成涂色书的标签
     * Enter description here ...
     * @param unknown_type $imgIds
     */
    public function getGroupImgsCatInfos($imgIds){
        if(is_array($imgIds)){
            $imgIds=implode(',', $imgIds);
        }
        $sql='select b.name,count(b.name) as cnt from img_cat_rel as a inner join img_cat_detail as b on a.cat_detailid=b.id where a.imgid in('.$imgIds.') group by b.name order by cnt desc';
        $res=$this->_db->fetchAll($sql);
        return $res;
    }
}

