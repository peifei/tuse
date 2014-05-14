<?php

class Admin_BookController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function initAction(){
        $form=new Admin_Form_BookInit();
        $this->view->form=$form;
        $clTmpbook=new Admin_Model_Class_TmpBook();
        $tmpImgs=$clTmpbook->getTmpImgs();
        $this->view->tmpImgs=$tmpImgs;
    }


}



