<?php
class Admin_Service_Pdf
{
    private $pdf;
    private $pageStyle;//a4(595:842)
    public function __construct($pageStyle=Zend_Pdf_Page::SIZE_A4){
        $this->pdf=new Zend_Pdf();
        $this->pageStyle=$pageStyle;
    }
    
    
    
    public function addImages(Array $imgPaths){
        $pages=array();
        foreach ($imgPaths as $imgPath){
            $pages[]=$this->addImage($imgPath);
        }
        $this->pdf->pages=$pages;
        return $this->pdf;
    }
    
    public function addImage($imgPath){
        $image = Zend_Pdf_Image::imageWithPath(PUBLIC_PATH.'/images/resources/'.$imgPath);
        $page=new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        $width=$image->getPixelWidth();
        $height=$image->getPixelHeight();
        //595-40=555;842-40=802
        if(Zend_Pdf_Page::SIZE_A4==$this->pageStyle){
            if($width>$height){
                $scalWidth=555;
                $scalHeiht=intval(555*$height/$width);
                $x1=20;
                $y1=(842-$scalHeiht)/2;
                $x2=575;
                $y2=$y1+$scalHeiht;
            }
            if($height>$width){
                if((802/555)<($width/$height)){
                    $scalWidth=intval(802*$width/$height);
                    $scalHeiht=802;
                    $x1=(595-$scalWidth)/2;
                    $y1=20;
                    $x2=$x1+$scalWidth;
                    $y2=822;
                }else{
                    $scalWidth=555;
                    $scalHeiht=intval(555*$height/$width);
                    $x1=20;
                    $y1=(842-$scalHeiht)/2;
                    $x2=575;
                    $y2=$y1+$scalHeiht;
                }
            }
        }
        
        if(Zend_Pdf_Page::SIZE_A4_LANDSCAPE==$this->pageStyle){
            if($width<$height){
                $scalWidth=intval(555*$width/$height);
                $scalHeiht=555;
                $x1=(842-$scalWidth)/2;
                $y1=20;
                $x2=$x1+$scalWidth;
                $y2=575;
            }
            if($height<$width){
                if((802/555)>($width/$height)){
                    $scalWidth=intval(555*$width/$height);
                    $scalHeiht=555;
                    $x1=(842-$scalWidth)/2;
                    $y1=20;
                    $x2=$x1+$scalWidth;
                    $y2=575;
                }else{
                    $scalWidth=802;
                    $scalHeiht=intval(802*$height/$width);
                    $x1=20;
                    $y1=(595-$scalHeiht)/2;
                    $x2=822;
                    $y2=$y1+$scalHeiht;
                }
            }
        }
        
        $page->drawImage($image, $x1, $y1, $x2, $y2);
        return $page;
    }
    
    
}
?>