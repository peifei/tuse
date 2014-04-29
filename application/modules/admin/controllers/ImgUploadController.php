<?php

class Admin_ImgUploadController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        try{
            $msg=$this->_helper->flashMessenger->getMessages('fbmsg');
            if(count($msg)>0){
                $this->view->fbmsg=$msg[0];
            }
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
        }catch (Exception $e){
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->view->fbmsg=$fbmsg;
        }
    }
    
    public function completeAction(){
        try{
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
        }catch (Exception $e){
            $fbmsg['type']='alert-danger';
            $fbmsg['msg']=$e->getMessage();
            $this->_helper->flashMessenger->addMessage($fbmsg,'fbmsg');
            $this->redirect(SITE_BASE_URL.'/admin/img-upload/');
        }
    }


}



