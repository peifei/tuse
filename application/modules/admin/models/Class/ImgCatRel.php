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
    
}
?>