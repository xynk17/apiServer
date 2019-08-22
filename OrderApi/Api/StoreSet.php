<?php
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class Api_StoreSet extends PhalApi_Api {

    public function getRules() {
        return array(
            'index' => array(
                'username' 	=> array('name' => 'username', 'default' => 'PHPer', ),
                'store_id' 	=> array('name' => 'store_id', 'default' => 'PHPer', ),
            ),
        );
    }

    /**
     * 默认接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function index() {
//        return array(
//            'title' => 'Hello Worlddemo!',
//            'content' => T('Hi {name}, welcome to use PhalApi!', array('name' => $this->username)),
//            'version' => PHALAPI_VERSION,
//            'time' => $_SERVER['REQUEST_TIME'],
//        );

//$sql="select * from User ";
//$params = array();
//$rs= DI()->notorm->User->queryAll($sql,$params);
//return $rs;

//        $sql="update User set userName = 'OK4' where uid = 1 ";
//        $params = array();
//        $rs= DI()->notorm->dual->queryAll($sql,$params);
//        return $rs;

        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=StoreSet.index&store_id=3
        //http://118.27.37.30:90/orderapi/?service=StoreSet.index&store_id=3

        $params = array(':store_id' => $this->store_id);
        $sql="select lvl_id as id,lvl_name as name from pan_storeset where store_id = :store_id and ice_suger=1";
        $ice_rs= DI()->notorm->dual->queryAll($sql,$params);

        $sql="select lvl_id as id,lvl_name as name from pan_storeset where store_id = :store_id and ice_suger=2";
        $suger_rs= DI()->notorm->dual->queryAll($sql,$params);

        $sql="select option_id as id,option_name as name,option_money as money,bar_code as bar_code from pan_options where store_id = :store_id";
        $option_rs= DI()->notorm->dual->queryAll($sql,$params);

        return array(
            'ice' => $ice_rs,
            'suger' => $suger_rs,
            'option' => $option_rs,
        );


    }
}
