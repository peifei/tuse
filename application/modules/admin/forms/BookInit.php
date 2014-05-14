<?php

class Admin_Form_BookInit extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $title=new Zend_Form_Element_Text('title');
        $title->setLabel('图书标题');
        $title->setAttribs(array('class'=>'form-control'));
        $desc=new Zend_Form_Element_Textarea('desc');
        $desc->setLabel('摘要');
        $desc->setAttribs(array('class'=>'form-control','rows'=>'5'));
        $smtBtn=new Zend_Form_Element_Submit('smtBtn');
        $smtBtn->setLabel('生成pdf');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary'));
        $this->addElements(array($title,$desc,$smtBtn));
    }


}

