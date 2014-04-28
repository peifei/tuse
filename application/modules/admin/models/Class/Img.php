<?php
class Admin_Model_Class_Img
{
    private $dbImg;
    public function __construct(){
        $this->dbImg=new Admin_Model_DbTable_Img();
    }

}
?>