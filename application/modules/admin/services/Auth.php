<?php
/**
 * 用户登录验证
 */
class Admin_Service_Auth
{
    /**
     * 获取验证登录的dbAdapter
     * @param unknown_type $userType
     */
    public function getDbAuthAdapter(){
        $dbAdapter=Zend_Db_Table::getDefaultAdapter();
        $authAdaper=new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdaper->setTableName('user');
        $authAdaper->setIdentityColumn('name');
        $authAdaper->setCredentialColumn('pwd');
        $authAdaper->setCredentialTreatment("MD5(CONCAT(?,salt))");
        return $authAdaper;
    }
    /**
     * 邮箱登录验证
     * @param unknown_type $email
     * @param unknown_type $password
     * @param unknown_type $userType
     * @return boolean
     */
    public function userAuthenTication($email,$password){
        $adapter=$this->getDbAuthAdapter();
        //设置用户名和秘密
        $adapter->setIdentity($email);
        $adapter->setCredential($password);
        $auth = Zend_Auth::getInstance();
        //验证用户
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            //如果验证成功则将用户信息存入Zend_Auth对象中（session中），并返回true
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        //验证失败返回false
        return false;
    }
}
?>