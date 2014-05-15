<?php
class Admin_Model_Class_Book
{
    private $dbBook;
    public function __construct(){
        $this->dbBook=new Admin_Model_DbTable_Book();
    }

    public function initBook(Array $data){
        $db=$this->dbBook->getDefaultAdapter();
        $clTmpBook=new Admin_Model_Class_TmpBook();
        $clBookDetail=new Admin_Model_Class_BookDetail();
        $tmpImgs=$clTmpBook->getTmpImgs()->toArray();
        $db->beginTransaction();
        try{
            $bookId=$this->dbBook->insert($data);
            foreach ($tmpImgs as $tmpImg){
                $tmpImg['book_id']=$bookId;
                $clBookDetail->addNewBookImg($tmpImg);
            }
            $clTmpBook->clearTmpImgs();
            $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
    
    

}
?>