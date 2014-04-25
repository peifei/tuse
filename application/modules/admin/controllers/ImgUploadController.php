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
                try{
                    $img=$form->getValue('img');
                    $this->forward('complete','img-upload','admin',array('img'=>$img));
                }catch(Exception $e){
                    echo $e->getMessage();
                }
            }
        }
    }
    
    public function completeAction(){
        $img=$this->getRequest()->getParam('img');
        $this->view->img=$img;
        $form=new Admin_Form_ImgSet();
        $this->view->form=$form;
    }


}



