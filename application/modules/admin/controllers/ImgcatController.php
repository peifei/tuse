<?php

class Admin_ImgcatController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addcatAction()
    {
        $form=new Admin_Form_Cat();
        $this->view->form=$form;
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
                $clImgcat=new Admin_Model_Class_ImgCat();
                $clImgcat->addNewCat($form->getValues());
            }
        }
    }

    public function addcatdetailAction()
    {
        $form=new Admin_Form_CatDetail();
        $this->view->form=$form;
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
                $clImgcatDetail=new Admin_Model_Class_ImgCatDetail();
                $clImgcatDetail->addNewCatDetail($form->getValues());
            }
        }
    }


}







