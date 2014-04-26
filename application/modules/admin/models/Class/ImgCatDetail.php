<?php
class Admin_Model_Class_ImgCatDetail
{
    private $dbImgCatDetail;
    public function __construct(){
        $this->dbImgCatDetail=new Admin_Model_DbTable_ImgCatDetail();
    }
    /**
     * 添加新类别明细
     * @param Array $data
     */
    public function addNewCatDetail(Array $data){
        try{
            $this->dbImgCatDetail->insert($data);
        }catch(Exception $e){
            throw new Exception('添加新类别明细失败！');
        }
    }
    /**
     * 根据类别明细id取得类别信息信息
     * @param Array $data
     */
    public function getCatById(Array $data){
        try{
            $res=$this->dbImgCatDetail->fetchRow(array('id=?'=>$data['id']));
            return $res;
        }catch(Exception $e){
            throw new Exception('图片类别明细查找失败');
        }
    }
    /**
     * 依据类别的名字取得类别信息
     * @param array $data
     */
    public function getCatByName(Array $data){
        try{
            $res=$this->dbImgCatDetail->fetchRow(array('name=?'=>$data['name']));
            return $res;
        }catch(Exception $e){
            throw new Exception('图片类别明细查找失败');
        }
    }
    /**
     * 根据类别id取得所有图片类别明细信息
     */
    public function getCatDetailsById(Array $data){
        try{
            $res=$this->dbImgCatDetail->fetchAll(array('cat_id=?'=>$data['cat_id']));
            return $res->toArray();
        }catch(Exception $e){
            throw new Exception('图片类别明细查找失败');
        }
    }
    /**
     * 取得类别明细，并按主类id进行分组
     */
    public function getCatDetails(){
        try{
            $res=$this->dbImgCatDetail->fetchAll(null,'cat_id asc');
            $cats=array();
            foreach ($res as $re){
                $cats[$re['cat_id']][$re['id']]=$re['name'];
            }
            return $cats;
        }catch(Exception $e){
            throw new Exception('图片类别明细查找失败');
        }
    }
}
?>