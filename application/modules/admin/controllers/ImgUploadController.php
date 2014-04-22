<?php

class Admin_ImgUploadController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form=new Admin_Form_ImgUpload();
        $this->view->form=$form;
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($request->getPost())){
                $form->getValue('img');
            }
        }
    }


}



