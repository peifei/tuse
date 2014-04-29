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


}

