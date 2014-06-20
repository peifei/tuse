<?php
/**
 * 用户登录表单
 * @author fxcm
 *
 */
class Admin_Form_UserLogin extends Zend_Form
{

    public function init()
    {
        $userName=new Zend_Form_Element_Text('userName');
        $userName->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('StringLength',true,array(0,50,'utf-8'))
                ->setAttribs(array('class'=>'form-control','placeholder'=>"请输入登录邮箱"));
        $userName->removeDecorator('Label');
        $userPassword=new Zend_Form_Element_Password('userPassword');
        $userPassword->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->addValidator('StringLength',true,array(0,50,'utf-8'))
                    ->setAttribs(array('class'=>'form-control','placeholder'=>"请输入密码"));
        $userPassword->removeDecorator('Label');
        $captcha=new Zend_Form_Element_Captcha('captcha',array('captcha'=>array(
            'capthca'=>'Image',
    		'font'=>'SIMHEI.TTF',
            'width'=>'180',
            'fontSize' => 24,
            'height'=>'35',
            'wordlen'=>'4',
            'dotNoiseLevel'=>'10',
            'lineNoiseLevel'=>'2',
            'imgUrl'=>SITE_BASE_URL.'/images/captcha/',
            'imgAlt'=>'点击刷新验证码',
            //'messages'=>array('badCaptcha'=>'验证码错误')
        )));
        $captcha->removeDecorator('Label')->setAttrib('class', 'form-control');
        $submit=new Zend_Form_Element_Submit('submit');
        $submit->setLabel('登陆')->setAttribs(array('class'=>'btn btn-primary','id'=>'loginBtn'));
        $submit->removeDecorator('DtDdWrapper')->addDecorators(array(array('HtmlTag',array('tag'=>'dd'))));
        $this->addElements(array($userName,$userPassword,$captcha,$submit));
    }


}

