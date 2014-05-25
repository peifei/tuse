<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $clImg=new Admin_Model_Class_Img();
        $todayImg=$clImg->getDateImg();
        $this->view->todayImg=$todayImg;
    }


}

