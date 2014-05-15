<?php
class Admin_Model_Class_BookDetail
{
    private $dbBookDetail;
    public function __construct(){
        $this->dbBookDetail=new Admin_Model_DbTable_BookDetail();
    }

    public function addNewBookImg(Array $data){
        $this->dbBookDetail->insert($data);
    }
    
    

}
?>