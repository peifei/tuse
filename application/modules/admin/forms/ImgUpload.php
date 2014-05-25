<?php

class Admin_Form_ImgUpload extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $img=new Zend_Form_Element_File('img');
        $img->setLabel('请选择要上传的图片')
            ->setRequired(true)
            ->setDestination(PUBLIC_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);
        $img->addValidator('Count', false, 2);
        $img->addValidator('Size', false, 1024000);
        $img->addValidator('Extension', false, 'jpg,png,gif');
        $smtBtn=new Zend_Form_Element_Submit('smtBtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary'));
        
        $this->addElements(array($img,$smtBtn));
        
    }


}

