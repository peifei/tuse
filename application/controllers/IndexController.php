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
        $this->view->img='http://127.0.0.1/tuse/public/images/resources/201405/300.jpg';
    }


}

