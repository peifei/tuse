<?php

class Admin_BookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $clBook=new Admin_Model_Class_Book();
        $this->view->bookList=$clBook->getBookList();
    }
    
    public function initAction(){
        $form=new Admin_Form_BookInit();
        $this->view->form=$form;
        $clTmpbook=new Admin_Model_Class_TmpBook();
        $clBook=new Admin_Model_Class_Book();
        $tmpImgs=$clTmpbook->getTmpImgs();
        $this->view->tmpImgs=$tmpImgs;
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
                $clBook->initBook($form->getValues());
                echo 'success';
            }
        }
    }


}



