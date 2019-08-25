<?php
/**
 * 默认接口服务类
 *
 * @author:
 */
header("Access-Control-Allow-Origin:*");

header('Access-Control-Allow-Methods:POST');

header('Access-Control-Allow-Headers:x-requested-with, content-type');

class Api_GoodsBarcode extends PhalApi_Api
{

    public function getRules()
    {
        return array(
            'getGoodsBarcodes' => array(
                'store_id' => array('name' => 'store_id', 'default' => '',),
                'goods_id' => array('name' => 'goods_id', 'default' => '',),
                'bar_code' => array('name' => 'bar_code', 'default' => '',)
            ),
            'createGoodsBarcode' => array(
                'store_id'  => array('name' => 'store_id', 'default' => '',),
                'goods_id'  => array('name' => 'goods_id', 'default' => '',),
                'size_lvl'  => array('name' => 'size_lvl', 'default' => '',),
                'ice_hot'   => array('name' => 'ice_hot', 'default' => '',),
                'ice_lvl'   => array('name' => 'ice_lvl', 'default' => '',),
                'suger_lvl' => array('name' => 'suger_lvl', 'default' => '',),
                'bar_code'  => array('name' => 'bar_code', 'default' => '',)
            ),
            'deleteGoodsBarcode' => array(
                'id' => array('name' => 'id', 'default' => '',)
            ),
            'updateGoodsBarcode' => array(
                'id' => array('name' => 'id', 'default' => '',),
                'store_id'  => array('name' => 'store_id', 'default' => '',),
                'goods_id'  => array('name' => 'goods_id', 'default' => '',),
                'size_lvl'  => array('name' => 'size_lvl', 'default' => '',),
                'ice_hot'   => array('name' => 'ice_hot', 'default' => '',),
                'ice_lvl'   => array('name' => 'ice_lvl', 'default' => '',),
                'suger_lvl' => array('name' => 'suger_lvl', 'default' => '',),
                'bar_code'  => array('name' => 'bar_code', 'default' => '',)
            )
        );
    }

    /**
     * goodsBarcode取得接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function getGoodsBarcodes()
    {

        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=GoodsBarcode.getGoodsBarcodes
        $sql = "select aa.id,aa.store_id,bb.name as store_name,aa.goods_id,cc.name as goods_name,aa.size_lvl,aa.ice_hot,aa.ice_lvl,aa.suger_lvl,aa.bar_code  from pan_goodsbar aa  left join imss_cjdc_store bb on aa.store_id = bb.id left join imss_cjdc_goods cc on aa.goods_id = cc.id where 1=1";

        if ($this->store_id != '') {
            $sql = $sql . " and aa.store_id = :store_id";
        }

        if ($this->goods_id!= '') {
            $sql = $sql . " and aa.goods_id = :goods_id";
        }

        if ($this->bar_code != '') {
            $this->bar_code = '%' . $this->bar_code . '%';
            $sql = $sql . " and aa.bar_code like :bar_code";
        }

        $params = array(':store_id' => $this->store_id, ':goods_id' => $this->goods_id, ':bar_code' => $this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);

        return $option_rs_rs;

    }

    /**
     * goodsBarcode创建接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function createGoodsBarcode()
    {
        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=GoodsBarcode.createGoodsBarcode
        $sql = "insert into pan_goodsbar (store_id,goods_id,size_lvl,ice_hot,ice_lvl,suger_lvl,bar_code) values (:store_id,:goods_id,:size_lvl,:ice_hot,:ice_lvl,:suger_lvl,:bar_code)";
        $params = array(':store_id' => $this->store_id, ':goods_id' => $this->goods_id, ':size_lvl' => $this->size_lvl, ':ice_hot' => $this->ice_hot, ':ice_lvl' => $this->ice_lvl, ':suger_lvl' => $this->suger_lvl,':bar_code' => $this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);

        return $option_rs_rs;

    }

    /**
     * goodsBarcode删除接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function deleteGoodsBarcode()
    {
        $sql = "delete from pan_goodsbar where id in(" . $this->id . ")";
        $params = null;
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);

        return $option_rs_rs;

    }

    /**
     * goodsBarcode更新接口服务
     * @return string title 标题
     * @return string content 内容
     * @return string version 版本，格式：X.X.X
     * @return int time 当前时间戳
     */
    public function updateGoodsBarcode()
    {
        $sql = "update pan_goodsbar set store_id=:store_id,goods_id=:goods_id,size_lvl=:size_lvl,ice_hot=:ice_hot,ice_lvl=:ice_lvl,suger_lvl=:suger_lvl,bar_code=:bar_code where id = :id";
        $params = array(':id' => $this->id,':store_id' => $this->store_id,':goods_id'=>$this->goods_id,':size_lvl'=>$this->size_lvl,':ice_hot'=>$this->ice_hot,':ice_lvl'=>$this->ice_lvl,':suger_lvl'=>$this->suger_lvl,':bar_code'=>$this->bar_code);
        $option_rs_rs = DI()->notorm->dual->queryAll($sql, $params);

        return $option_rs_rs;
    }

}
