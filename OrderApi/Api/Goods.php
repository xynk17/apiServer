<?php
/**
 * 默认接口服务类
 *
 * @author:
 */
header("Access-Control-Allow-Origin:*");

header('Access-Control-Allow-Methods:POST');

header('Access-Control-Allow-Headers:x-requested-with, content-type');

class Api_Goods extends PhalApi_Api
{

    public function getRules()
    {
        return array(
            'getGoods' => array(
                'store_id' => array('name' => 'store_id', 'default' => '',),
                'name' => array('name' => 'name', 'default' => '',)
            ),
        );
    }

    /**
     * option取得接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function getGoods()
    {

        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=Goods.getGoods

        $sql = "select aa.id ,aa.store_id,bb.name as store_name ,aa.name from imss_cjdc_goods aa left join imss_cjdc_store bb on aa.store_id = bb.id where 1=1";


        if ($this->store_id != '') {
            $sql = $sql . " and aa.store_id = :store_id";
        }

        if ($this->name != '') {
            $this->name = '%' . $this->name . '%';
            $sql = $sql . " and aa.name like :name";
        }


        $params = array(':store_id' => $this->store_id, ':name' => $this->name);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);


        return $option_rs_rs;

    }

}
