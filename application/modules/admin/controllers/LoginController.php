<?php
/**
 * 管理员登录
 * @author fxcm
 *
 */
class Admin_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->layout()->setLayout('admine');
        $form=new Admin_Form_UserLogin();
        $request=$this->getRequest();
        $captcha=$form->getElement('captcha');
        $session=new Zend_Session_Namespace('captchaContainer');
        $session->captcha=$captcha;
        if($request->isPost()){
        	if($form->isValid($request->getPost())){
        		$email=$request->getParam('userName');
        		$password=$request->getParam('userPassword');
        		$auth=new Admin_Service_Auth();
        		if ($auth->userAuthenTication($email, $password)){
        			$this->_redirect(SITE_BASE_URL.'/admin/');
        		}else{
        			$this->view->authErrorMessage="用户名或密码错误";
        		}
        	}
        }
        
        $this->view->form=$form;
        
    }
    
    public function refreshCaptchaAction(){
        $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
        //从session中取得以前保存的captcha对象
        $session=new Zend_Session_Namespace('captchaContainer');
        $capacha=$session->captcha->getCaptcha();
        //调用captcha对象中的generate()方法,重新生成id和word
        $capacha->generate();
        //返回新的id给前台
        echo $capacha->getId();
    }
    
    public function logoutAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect(SITE_BASE_URL.'/admin/login/');
    }


}

