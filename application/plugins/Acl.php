<?php
/**
 * 权限控制
 * @author fxcm
 *
 */
class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    private $acl;
    public function preDispatch (Zend_Controller_Request_Abstract $request)
    {
        $acl = $this->getAcl();
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $userInfo = $auth->getIdentity();
            $userRole = $userInfo->type;
            //if (is_null($userRole)) {
            if('admin'!=$userRole){
                $userRole = 'guest';
            }
        } else {
            $userRole = 'guest';
        }
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        if('admin'==$moduleName&&'login'!=$controllerName){
            $privilageName='adminR';
        }else{
            $privilageName='guestR';
        }
        if (!$acl->isAllowed($userRole, $privilageName)) {
            
            $request->setModuleName('admin');
            $request->setControllerName('login');
            $request->setActionName('index');
        }
    }
    public function getAcl ()
    {
        $this->acl = new Zend_Acl();
        $this->setRole();
        $this->setResource();
        $this->setPrivilege();
        return $this->acl;
    }
    /**
     * 设置用户角色
     */
    public function setRole ()
    {
        $this->acl->addRole(new Zend_Acl_Role('guest'));
        $this->acl->addRole(new Zend_Acl_Role('admin'), 'guest');
    }
    /**
     * 设置可访问资源
     */
    public function setResource ()
    {
        $this->acl->addResource(new Zend_Acl_Resource('guestR'));
        $this->acl->addResource(new Zend_Acl_Resource('adminR'));
    }
    /**
     * 设置访问权限
     */
    public function setPrivilege ()
    {
        $this->acl->allow('guest', array('guestR'));
        $this->acl->allow('admin',array('adminR'));
    }
}
