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
        $catinfo=new Zend_Form_Element_Note('catinfo');
        $catinfo->setValue('<div class="catInfo"></div>');
        $catinfo->setDecorators(array('ViewHelper'));
        $smtBtn=new Zend_Form_Element_Submit('smtSetBtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary'));
        $smtBtn->setDecorators(array('ViewHelper'));
        $this->addElements(array($imgText,$imgDate,$imgCats,$imgName,$catinfo,$smtBtn));
                
    }
    
    public function prepareFormForUpdate($data){
        $this->setAction('');
        if(!empty($data['text'])){
            $etext=$this->getElement('text');
            $etext->setValue($data['text']);
        }
        
        if(!empty($data['show_date'])){
            $edate=$this->getElement('show_date');
            $edate->setValue($data['show_date']);
        }
        
        if(!empty($data['cats'])){
            $ecats=$this->getElement('cats');
            $ecats->setValue($data['cats']);
        }
        
        if(!empty($data['catinfo'])){
            $ecatinfo=$this->getElement('catinfo');
            $html='<div class="catInfo">';
            foreach ($data['catinfo'] as $key=>$value){
                $html.='<span id="'.$key.'">'.$value.'</span>';
            }
            $html.='</div>';
            $ecatinfo->setValue($html);
        }
        $imgId=new Zend_Form_Element_Hidden('img_id');
        $imgId->setValue($data['id']);
        $imgId->setDecorators(array('ViewHelper'));
        $this->addElement($imgId);
    }


}

