<?php

class Admin_Model_DbTable_TmpBook extends Zend_Db_Table_Abstract
{

    protected $_name = 'tmp_book';

    public function getImgNum(){
        $res=$this->_db->query('select count(*) as cnt from tmp_book')->fetch();
        return $res['cnt'];
    }
}

