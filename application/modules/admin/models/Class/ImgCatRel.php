<?php
class Admin_Model_Class_ImgRel
{
    private $dbImgCatRel;
    public function __construct(){
        $this->$dbImgCatRel=new Admin_Model_DbTable_ImgCatRel();
    }
    
}
?>