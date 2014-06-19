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
    
    public function getBookImgs($bid){
        $res=$this->dbBookDetail->fetchAll(array('book_id=?'=>$bid),array('order asc'));
        if(empty($res)){
            throw new Exception("没有找到图片！");
        }else{
            return $res->toArray();
        }
    }
    
    

}
?>