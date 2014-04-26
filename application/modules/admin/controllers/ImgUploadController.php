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
        //取得上传的图片的名字，图片临时存放在temp目录下
        $img=$this->getRequest()->getParam('img');
        $this->view->img=$img;
        //显示表单
        $form=new Admin_Form_ImgSet();
        $this->view->form=$form;
        //取得所有主分类
        $clImgCat=new Admin_Model_Class_ImgCat();
        $cats=$clImgCat->getCats();
        $this->view->cats=$cats;
        //取得所有明细分类
        $clImgCatDetail=new Admin_Model_Class_ImgCatDetail();
        $catDetails=$clImgCatDetail->getCatDetails();
        $this->view->catDetails=$catDetails;
        
    }


}



