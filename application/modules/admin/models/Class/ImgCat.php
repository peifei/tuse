<?php
class Admin_Model_Class_ImgCat
{
    private $dbImgCat;
    public function __construct(){
        $this->dbImgCat=new Admin_Model_DbTable_ImgCat();
    }
    /**
     * 添加新类别
     * @param Array $data
     */
    public function addNewCat(Array $data){
        try{
            $this->dbImgCat->insert($data);
        }catch(Exception $e){
            throw new Exception('添加新类别失败！');
        }
    }
    /**
     * 根据类别id取得类别信息
     * @param Array $data
     */
    public function getCatById(Array $data){
        try{
            $res=$this->dbImgCat->fetchRow(array('id=?'=>$data['id']));
            return $res;
        }catch(Exception $e){
            throw new Exception('图片类别查找失败');
        }
    }
    /**
     * 依据类别的名字取得类别信息
     * @param array $data
     */
    public function getCatByName(Array $data){
        try{
            $res=$this->dbImgCat->fetchRow(array('name=?'=>$data['name']));
            return $res;
        }catch(Exception $e){
            throw new Exception('图片类别查找失败');
        }
    }
    /**
     * 取得所有图片类别信息
     */
    public function getCats(){
        try{
            $res=$this->dbImgCat->fetchAll();
            return $res->toArray();
        }catch(Exception $e){
            throw new Exception('图片类别查找失败');
        }
    }
}
?>