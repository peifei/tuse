<?php

class Admin_Form_Cat extends Zend_Form
{

    public function init()
    {
        $name =new Zend_Form_Element_Text('name');
        $name->setLabel('请输入类别名称');
        $name->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('stringTrim')
             ->addValidator('NotEmpty',true)
             ->addValidator('StringLength',true, array(0,20,'utf-8'));
        $name->setAttribs(array('class'=>'form-control'));
        $smtBtn=new Zend_Form_Element_Submit('smtbtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary col-sm-4'));
        $this->addElements(array($name,$smtBtn));
    }


}

