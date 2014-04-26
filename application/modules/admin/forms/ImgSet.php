<?php

class Admin_Form_ImgSet extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $imgText=new Zend_Form_Element_Text('text');
        $imgText->setLabel('请输入图片的描述性文字');
        $imgText->setAttribs(array('class'=>'form-control'));
        $imgDate=new Zend_Form_Element_Text('show_date');
        $imgDate->setLabel('设置图片展示日期');
        $imgDate->setAttribs(array('class'=>'form-control'));
        $imgCats=new Zend_Form_Element_Hidden('cats');
        $imgCats->setDecorators(array('ViewHelper'));
        $imgCats->setValue('');
        $smtBtn=new Zend_Form_Element_Submit('smtBtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary'));
        $smtBtn->setDecorators(array(
                                     array('HtmlTag',array('tag'=>'div','class'=>'catInfo')),
                                     'ViewHelper'
                                ));
        $this->addElements(array($imgText,$imgDate,$imgCats,$smtBtn));
                
    }


}

