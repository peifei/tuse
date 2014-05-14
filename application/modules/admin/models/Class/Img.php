<?php
class Admin_Model_Class_Img
{
    private $dbImg;
    public function __construct(){
        $this->dbImg=new Admin_Model_DbTable_Img();
    }
    /**
     * 添加新图片
     */
    public function addNewImg($data){
        //整理form表单传递过来的数组
        $fdata=array();
        $fdata['img']['path']=$data['path'];
        if(!empty($data['text'])){
            $fdata['img']['text']=$data['text'];
        }
        if(!empty($data['show_date'])){
            $fdata['img']['show_date']=$data['show_date'];
        }
        $fdata['img']['upload_time']=date('Y-m-d H:i:s',time());
        if(!empty($data['cats'])){
            $fdata['cats']=substr($data['cats'],0,-1);
        }
        $this->dbImg->addNewImg($fdata);
    }
    
	/**
     * 更新图片
     */
    public function updateImg($data){
        //整理form表单传递过来的数组
        $fdata=array();
        $fdata['img']['text']=$data['text'];
        $fdata['img']['show_date']=$data['show_date'];
        $fdata['img']['id']=$data['img_id'];
        $fdata['cats']=substr($data['cats'],0,-1);
        $this->dbImg->updateImg($fdata);
    }
    
    
    
    /**
     * 获取文件列表selecter
     * 主要用于列表分页
     */
    public function getImgListSelecter($cats=null){
        if(null!=$cats){
            $catsArr=explode(',', substr($cats,0,-1));
            $cnt=count($catsArr);
            $sqlwhere='';
            $n=0;
            foreach ($catsArr as $cat){
                if(0==$n){
                    $sqlwhere.="cat_detailid='".$cat."'";
                }else{
                    $sqlwhere.=" or cat_detailid='".$cat."'";
                }
                $n++;
            }
            $selecter=$this->dbImg->getAdapter()->select()->from('img')
                ->where("id in (select imgid from img_cat_rel where ".$sqlwhere." group by imgid having count(*)=$cnt)");
        }else{
            $selecter=$this->dbImg->getAdapter()->select()->from('img');
        }
        return $selecter;
    }
    /**
     * 删除图片
     * @param unknown_type $imgId
     */
    public function deleteImg($imgId){
        $res=$this->dbImg->fetchRow(array('id=?'=>$imgId));
        if(count($res)==0){
            throw new Exception('图片不存在');
        }else{
            $this->dbImg->deleteImg($imgId);
            unlink(PUBLIC_PATH.'/images/resources/'.$res['path']);
        }
        
    }
    /**
     * 取得某一日期的每日一涂图片信息
     * @param unknown_type $date
     */
    public function getDateImg($date=null){
        
    }
    /**
     * 根据图片id取得图片信息
     * @param unknown_type $id
     */
    public function getImgInfoById($imgId){
        $res=$this->dbImg->fetchRow(array('id=?'=>$imgId));
        if(count($res)==0){
            throw new Exception('图片不存在');
        }else{
            $res=$res->toArray();
            $clImgCatRel=new Admin_Model_Class_ImgCatRel();
            $catInfos=array();
            $catInfos=$clImgCatRel->getImgCatInfos($imgId);
            
            if(!empty($catInfos)){
                $res['cats']=$catInfos['cats'];
                $res['catinfo']=$catInfos['catinfo'];
            }
            return $res;
        }
    }
    
    public function getTmpBookImgs($order){
        return $this->dbImg->getTmpBookImgs($order);
    }
    
    

}
?>