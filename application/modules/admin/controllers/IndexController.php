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
        
        $request=$this->getRequest();
        $pageNum=$request->getParam('pageNum');
        $clImg=new Admin_Model_Class_Img();
        $selecter=$clImg->getImgListSelecter();
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


}

