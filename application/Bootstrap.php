<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * 初始化模块路径
     * Enter description here ...
     */
    public function _initModulesFrontController ()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->setControllerDirectory(
        array('default' => '../application/controllers', 
        'admin' => '../application/modules/admin'));
    }
    /**
     * 初始化插件
     * Enter description here ...
     */
    public function _initPlugin ()
    {
        $front = Zend_Controller_Front::getInstance();
        //注册布局插件
        $front->registerPlugin(new Application_Plugin_LayoutSelecter());
    }
	
}

