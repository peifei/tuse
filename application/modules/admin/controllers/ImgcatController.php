<?php

class Admin_ImgcatController extends Zend_Controller_Action
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
        $clImgCatDetail=new Admin_Model_Class_ImgCatDetail();
        $catDetails=$clImgCatDetail->getCatDetails();
        $this->view->catDetails=$catDetails;
        $clImgCat=new Admin_Model_Class_ImgCat();
        $cats=$clImgCat->getCats();
        $this->view->cats=$cats;
    }

    public function addcatAction()
    {
        try{
            $msg=$this->_helper->flashMessenger->getMessages('fbmsg');
            if(count($msg)>0){
                $this->view->fbmsg=$msg[0];
            }
            $form=new Admin_Form_Cat();
            $this->view->form=$form;
            $request=$this->getRequest();
            if($request->isPost()){
                if($form->isValid($request->getPost())){
                    $clImgcat=new Admin_Model_Class_ImgCat();
                    $clImgcat->addNewCat($form->getValues());
                    $fbmsg['type']='alert-success';
                    $fbmsg['msg']='类别添加成功';
                    $this->view->fbmsg=$fbmsg;
                }
            }
        }catch(Exception $e){
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->view->fbmsg=$fbmsg;

        }
    }

    public function addcatdetailAction()
    {
        try{
            $msg=$this->_helper->flashMessenger->getMessages('fbmsg');
            if(count($msg)>0){
                $this->view->fbmsg=$msg[0];
            }
            $form=new Admin_Form_CatDetail();
            $this->view->form=$form;
            $request=$this->getRequest();
            if($request->isPost()){
                if($form->isValid($request->getPost())){
                    $clImgcatDetail=new Admin_Model_Class_ImgCatDetail();
                    $clImgcatDetail->addNewCatDetail($form->getValues());
                    $fbmsg['type']='alert-success';
                    $fbmsg['msg']='类别明细添加成功';
                    $this->view->fbmsg=$fbmsg;
                }
            }
        }catch (Exception $e){
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->view->fbmsg=$fbmsg;
        }
    }

}







