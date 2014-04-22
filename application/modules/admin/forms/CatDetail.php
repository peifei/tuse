<?php

class Admin_Form_CatDetail extends Zend_Form
{

    public function init()
    {
        $name =new Zend_Form_Element_Text('name');
        $name->setLabel('请输入类别明细');
        $name->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('stringTrim')
             ->addValidator('NotEmpty',true)
             ->addValidator('StringLength',true, array(0,20,'utf-8'));
        $name->setAttribs(array('class'=>'form-control'));
        
        $catId=new Zend_Form_Element_Select('cat_id');
        $catId->setLabel('请选择该明细所属类别');
        $catId->setMultiOptions($this->getCatsArry());
        $catId->setAttribs(array('class'=>'form-control'));
        
        
        $smtBtn=new Zend_Form_Element_Submit('smtbtn');
        $smtBtn->setLabel('提交');
        $smtBtn->setAttribs(array('class'=>'btn btn-primary col-sm-4'));
        $this->addElements(array($name,$catId,$smtBtn));
    }
    
    private function getCatsArry(){
        $clImgcat=new Admin_Model_Class_ImgCat();
        $cats=$clImgcat->getCats();
        $catsArr=array();
        foreach ($cats as $cat){
            $catsArr[$cat['id']]=$cat['name'];
        }
        return $catsArr;
        
    }


}

