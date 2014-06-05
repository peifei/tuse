<?php
class Admin_Model_Class_Book
{
    private $dbBook;
    public function __construct(){
        $this->dbBook=new Admin_Model_DbTable_Book();
    }
    /**
     * 生成pdf图书
     * Enter description here ...
     * @param array $data
     * @throws Exception
     */
    public function initBook(Array $data){
        $db=$this->dbBook->getDefaultAdapter();
        $clTmpBook=new Admin_Model_Class_TmpBook();
        $clBookDetail=new Admin_Model_Class_BookDetail();
        //取得临时数目的图片
        $tmpImgs=$clTmpBook->getTmpImgs()->toArray();
        //创建pdf服务类
        $svcPdf=new Admin_Service_Pdf();
        $db->beginTransaction();
        $bookName='tuse_'.date('Ymdhis').'.pdf';
        try{
            
            $data['path']=date('Ymd').'/'.$bookName;
            $bookId=$this->dbBook->insert($data);
            $imgPaths=array();
            foreach ($tmpImgs as $tmpImg){
                $tmpImg['book_id']=$bookId;
                $imgPaths[]=$tmpImg['img_path'];
                unset($tmpImg['id']);
                $clBookDetail->addNewBookImg($tmpImg);
            }
            $pdf=$svcPdf->addImages($imgPaths);
            $savePath=PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR;
            if(!is_dir($savePath)){
                mkdir($savePath,0777,true);
            }
            $pdf->save(PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR.$bookName);
            $clTmpBook->clearTmpImgs();
            $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
    
    public function makeCover($img){
        
    }
    
    /**
     * 取得图书列表
     * Enter description here ...
     */
    public function getBookList(){
        $res=$this->dbBook->fetchAll();
        return $res;
    }
    
    

}
?>