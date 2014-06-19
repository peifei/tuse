<?php

class BookController extends Zend_Controller_Action
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
    
    public function detailAction(){
        $this->_helper->layout()->setLayout('sidelayout');
        $bid=$this->getRequest()->getParam('bid');
        if(!preg_match('/^\d+$/', $bid)){
            throw new Exception('书目错误');
        }
        $clBook=new Admin_Model_Class_Book();
        $bookInfo=$clBook->getBookInfo($bid);
        
        $this->view->bookInfo=$bookInfo;
    }
}

