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
        $svcPdf=new Admin_Service_Pdf();
        $db->beginTransaction();
        $bookName='tuse_'.date('Ymdhis').'.pdf';
        try{
            $data['path']=$bookName;
            $bookId=$this->dbBook->insert($data);
            $imgPaths=array();
            foreach ($tmpImgs as $tmpImg){
                $tmpImg['book_id']=$bookId;
                $imgPaths[]=$tmpImg['img_path'];
                unset($tmpImg['id']);
                $clBookDetail->addNewBookImg($tmpImg);
            }
            $pdf=$svcPdf->addImages($imgPaths);
            $pdf->save(PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$bookName);
            $clTmpBook->clearTmpImgs();
            $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
    
    public function getBookList(){
        $res=$this->dbBook->fetchAll();
        return $res;
    }
    
    

}
?>