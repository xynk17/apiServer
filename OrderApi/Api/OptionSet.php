<?php
/**
 * 默认接口服务类
 *
 * @author:
 */
header("Access-Control-Allow-Origin:*");

header('Access-Control-Allow-Methods:POST');

header('Access-Control-Allow-Headers:x-requested-with, content-type');

class Api_OptionSet extends PhalApi_Api
{

    public function getRules()
    {
        return array(
            'getOptions' => array(
                'store_id' => array('name' => 'store_id', 'default' => '',),
                'bar_code' => array('name' => 'bar_code', 'default' => '',)
            ),
            'createOption' => array(
                'store_id' => array('name' => 'store_id', 'default' => '',),
                'option_id' => array('name' => 'option_id', 'default' => '',),
                'option_name' => array('name' => 'option_name', 'default' => '',),
                'option_money' => array('name' => 'option_money', 'default' => '',),
                'bar_code' => array('name' => 'bar_code', 'default' => '',)
            ),
            'deleteOption' => array(
                'id' => array('name' => 'id', 'default' => '',)
            ),

            'updateOption' => array(
                'id' => array('name' => 'id', 'default' => '',),
                'store_id' => array('name' => 'store_id', 'default' => '',),
                'option_id' => array('name' => 'option_id', 'default' => '',),
                'option_name' => array('name' => 'option_name', 'default' => '',),
                'option_money' => array('name' => 'option_money', 'default' => '',),
                'bar_code' => array('name' => 'bar_code', 'default' => '',)
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
    public function getOptions()
    {

        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=OptionSet.getAllOptions&bar_code=234

        $sql = "select aa.id ,aa.store_id,bb.name as store_name ,aa.option_id ,aa.option_name,aa.option_money,aa.bar_code from pan_options aa left join imss_cjdc_store bb on aa.store_id = bb.id where 1=1";


        if ($this->store_id != '') {
            $sql = $sql . " and aa.store_id = :store_id";
        }

        if ($this->bar_code != '') {
            $this->bar_code = '%' . $this->bar_code . '%';
            $sql = $sql . " and aa.bar_code like :bar_code";
        }


        $params = array(':store_id' => $this->store_id, ':bar_code' => $this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);


        return $option_rs_rs;

    }

    /**
     * option创建接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function createOption()
    {
        $sql = "insert into pan_options (store_id,option_id,option_name,option_money,bar_code) values (:store_id,:option_id,:option_name,:option_money,:bar_code)";
        $params = array(':store_id' => $this->store_id, ':option_id' => $this->option_id, ':option_name' => $this->option_name, ':option_money' => $this->option_money, ':bar_code' => $this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);


        return $option_rs_rs;

    }

    /**
     * option删除接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function deleteOption()
    {
        $sql = "delete from pan_options where id in(" . $this->id . ")";
        $params = null;
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);


        return $option_rs_rs;

    }
    /**
     * option更新接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function updateOption()
    {
        $sql = "update pan_options set store_id = :store_id,option_id=:option_id,option_name=:option_name,option_money=:option_money,bar_code=:bar_code where id = :id";
        $params = array(':id' => $this->id,':store_id' => $this->store_id, ':option_id' => $this->option_id, ':option_name' => $this->option_name, ':option_money' => $this->option_money, ':bar_code' => $this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);

        return $option_rs_rs;

    }
}
