<?php
/**
 * 布局模板选择插件
 * 根据不同的模块名称自动设置相应的布局模板
 * @author peifei
 *
 */
class Application_Plugin_LayoutSelecter extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $moduleName=$request->getModuleName();
        if('default'!=$moduleName){
            $layout=Zend_Layout::getMvcInstance();
            $layout->setLayout($moduleName);
        }
    }

}
?>