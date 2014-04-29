<?php

class Admin_Form_ImgSet extends Zend_Form
{
    public $imgName=null;
    public function __construct($img){
        $this->imgName=$img;
        parent::__construct();
    }

    public function init()
    {
        $this->setAction(SITE_BASE_URL.'/admin/img-upload/complete');
        /* Form Elements & Other Definitions Here ... */
        $imgText=new Zend_Form_Element_Text('text');
        $imgText->setLabel('请输入图片的描述性文字');
        $imgText->setAttribs(array('class'=>'form-control'));
        $imgDate=new Zend_Form_Element_Text('show_date');
        $imgDate->setLabel('设置图片展示日期');
        $imgDate->setAttribs(array('class'=>'form-control'));
        $imgCats=new Zend_Form_Element_Hidden('cats');
        $imgCats->setDecorators(array('ViewHelper'));
        $imgName=new Zend_Form_Element_Hidden('img_name');
        $imgName->setValue($this->imgName);
        $imgName->setDecorators(array('ViewHelper'));
        $smtBtn=new Zend_Form_Element_Submit('smtSetBtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary'));
        $smtBtn->setDecorators(array(
                                     array('HtmlTag',array('tag'=>'div','class'=>'catInfo')),
                                     'ViewHelper'
                                ));
        $this->addElements(array($imgText,$imgDate,$imgCats,$imgName,$smtBtn));
                
    }


}

