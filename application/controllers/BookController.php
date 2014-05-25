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


}

