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
                //TODO
                
            //取得上传的图片的名字，图片临时存放在temp目录下
            $img=$this->getRequest()->getParam('img');
            $this->view->img=$img;
            //显示表单
            $form=new Admin_Form_ImgSet($img);
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
            $smt=$request->getParam('smtSetBtn');
            if($request->isPost()&&isset($smt)){
                if($form->isValid($request->getPost())){
                    $svImgupload=new Admin_Service_Imgupload();
                    $svImgupload->upload($form->getValues());
                    $fbmsg['type']='alert-success';
                    $fbmsg['msg']='图片添加成功';
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

