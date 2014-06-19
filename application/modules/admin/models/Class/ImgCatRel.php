<?php
class Admin_Model_Class_ImgCatRel
{
    private $dbImgCatRel;
    public function __construct(){
        $this->dbImgCatRel=new Admin_Model_DbTable_ImgCatRel();
    }
    
    public function addImgCatRels($data){
        foreach ($data as $singleData){
            $this->dbImgCatRel->insert($singleData);
        }
    }
    
    public function getImgCatInfos($imgId){
        $imgCatInfos=$this->dbImgCatRel->getImgCatInfos($imgId);
        if(count($imgCatInfos)>0){
            $cats=array();
            $catinfo=array();
            foreach ($imgCatInfos as $imgCat){
                $cats[]=$imgCat['cat_detailid'];
                $catinfo[$imgCat['cat_detailid']]=$imgCat['name'];
            }
            $catInfos=array();
            $catInfos['cats']=implode(',', $cats);
            $catInfos['catinfo']=$catinfo;
            return $catInfos;
        }
    }
    
    public function removeCatRels($imgId){
        $this->dbImgCatRel->delete(array('imgid=?'=>$imgId));
    }
    
    public function get
    
}
?>