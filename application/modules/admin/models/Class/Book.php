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
        $bookKey=date('Ymdhis');
        $bookName='tuse_'.$bookKey.'.pdf';
        try{
            $savePath=PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR;
            if(!is_dir($savePath)){
                mkdir($savePath,0777,true);
            }
            //取得第一张图片作为书的封面
            $coverImg=PUBLIC_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $tmpImgs[0]['img_path']);
            $data['cover_path']=$this->makeCover($coverImg, $bookKey,$data['title']);
            
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
            $pdf->save(PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR.$bookName);
            $clTmpBook->clearTmpImgs();
            $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
    
    public function makeCover($img,$bookKey,$title){
        $imgName=basename($img);
        $svcImg=new Admin_Service_Img($img,300,420);
        $cover=date(Ymd).DIRECTORY_SEPARATOR.'cover_'.$bookKey.'_'.$imgName;
        $thumbImg=PUBLIC_PATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$cover;
        $svcImg->createThumbNails($thumbImg,$title);
        return str_replace(DIRECTORY_SEPARATOR, '/', $cover);
    }
    
    /**
     * 取得图书列表
     * Enter description here ...
     */
    public function getBookList(){
        $res=$this->dbBook->fetchAll();
        return $res;
    }
    /**
     * 取得单本图书的信息
     * Enter description here ...
     * @param unknown_type $bid
     */
    public function getBookInfo($bid){
        $maimInfo=$this->dbBook->fetchRow(array('id=?'=>$bid));
        if(empty($maimInfo)){
            throw new Exception("没有找到对应的涂色书");
        }
        $clBookDetail=new Admin_Model_Class_BookDetail();
        $imgsInfo=$clBookDetail->getBookImgs($bid);
        $bookInfo=array();
        $bookInfo['mainInfo']=$maimInfo->toArray();
        $bookInfo['imgsInfo']=$imgsInfo;
        return $bookInfo;
    }
}
?>