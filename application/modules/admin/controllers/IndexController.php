<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $msg=$this->_helper->flashMessenger->getMessages('fbmsg');
        if(count($msg)>0){
            $this->view->fbmsg=$msg[0];
        }
        
        //取得所有主分类
        $clImgCat=new Admin_Model_Class_ImgCat();
        $cats=$clImgCat->getCats();
        $this->view->cats=$cats;
        //取得所有明细分类
        $clImgCatDetail=new Admin_Model_Class_ImgCatDetail();
        $catDetails=$clImgCatDetail->getCatDetails();
        $this->view->catDetails=$catDetails;
        
        //取得临时图书图片集
        $clImg=new Admin_Model_Class_Img();
        $tmpBookImgs=$clImg->getTmpBookImgs('desc');
        if(count($tmpBookImgs)>0){
            $this->view->tmpBookImgs=$tmpBookImgs;
        }
        
        
        $request=$this->getRequest();
        $pageNum=$request->getParam('pageNum');
        $cats=$request->getParam('cats');
        $selecter=$clImg->getImgListSelecter($cats);
        $adapter = new Zend_Paginator_Adapter_DbSelect($selecter);
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage(24);
		$paginator->setCurrentPageNumber($pageNum);
		$this->view->paginator = $paginator;
    }
    
    public function deleteAction(){
        try{
            $id=$this->getRequest()->getParam('id');
            if(preg_match('/^\d+$/', $id)){
                $clImg=new Admin_Model_Class_Img();
                $clImg->deleteImg($id);
                $fbmsg=array();
                $fbmsg['type']='alert-success';
                $fbmsg['msg']='图片删除成功';
                $this->_helper->flashMessenger->addMessage($fbmsg,'fbmsg');
                $this->redirect(SITE_BASE_URL.'/admin/');
            }else{
                throw new Exception('参数不合法');
            }
        }catch (Exception $e){
            $fbmsg=array();
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->_helper->flashMessenger->addMessage($fbmsg,'fbmsg');
            $this->redirect(SITE_BASE_URL.'/admin/');
        }
    }
    
    public function editAction(){
        try{
            $id=$this->getRequest()->getParam('id');
            if(preg_match('/^\d+$/', $id)){
                
            $clImg=new Admin_Model_Class_Img();
            $imgInfo=$clImg->getImgInfoById($id);
              
            $this->view->img=$imgInfo['path'];
            //显示表单
            $form=new Admin_Form_ImgSet($imgInfo['path']);
            $form->prepareFormForUpdate($imgInfo);
            $this->view->form=$form;
            //取得所有主分类
            $clImgCat=new Admin_Model_Class_ImgCat();
            $cats=$clImgCat->getCats();
            $this->view->cats=$cats;
            //取得所有明细分类
            $clImgCatDetail=new Admin_Model_Class_ImgCatDetail();
            $catDetails=$clImgCatDetail->getCatDetails();
            $this->view->catDetails=$catDetails;
            
            $request=$this->getRequest();
            if($request->isPost()){
                if($form->isValid($request->getPost())){
                    $clImg->updateImg($form->getValues());
                    $fbmsg['type']='alert-success';
                    $fbmsg['msg']='图片更新成功';
                    $this->_helper->flashMessenger->addMessage($fbmsg,'fbmsg');
                    $this->redirect(SITE_BASE_URL.'/admin/');
                }
            }
            }else{
                throw new Exception('参数不合法');
            }
        }catch (Exception $e){
            $fbmsg=array();
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->_helper->flashMessenger->addMessage($fbmsg,'fbmsg');
            $this->redirect(SITE_BASE_URL.'/admin/');
        }
    }
    
    public function addToBookAction(){

            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $imgId=$this->getRequest()->getParam('id');
            $clTmpBook=new Admin_Model_Class_TmpBook();
            //插入图片到临时书筐中，并返回原石图片信息
            $imgInfo=$clTmpBook->addNewImg($imgId);
            echo json_encode($imgInfo);
    }


}

