<?php

/**
 * 默认接口服务类
 *
 * @author:
 */
header("Access-Control-Allow-Origin:*");

header('Access-Control-Allow-Methods:POST');

header('Access-Control-Allow-Headers:x-requested-with, content-type');
class Api_OrderDetial extends PhalApi_Api
{

    public function getRules()
    {
        return array(
            'index' => array(
                'store_id' => array('name' => 'store_id', 'default' => 'PHPer',),
                'order_id' => array('name' => 'order_id', 'default' => 'PHPer',),
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
    public function index()
    {
        //http://localhost:8888/phalapirrelease/Public/Orderapi/?service=OrderDetial.index&store_id=3&order_id=21
        //http://118.27.37.30:90/orderapi/?service=OrderDetial.index&store_id=3&order_id=21
        $result = array();
        $result["money_sum"] = 0;
        //$result["goods"] = array();
        $result_goodslist = array();
        $params = array(':order_id' => $this->order_id);
        $sql = "select note from imss_cjdc_order where id = :order_id";
        $order_rs = DI()->notorm->dual->queryAll($sql, $params);
        $note = $order_rs["0"]["note"];
        $note_objs = json_decode($note);

        foreach ($note_objs as $goods) {
            //var_dump($goods);
            $temp_goods = array();
            $size_char = "";
            $icehot_char = "";
            $ice_char = "";
            $suger_char = "";
            $money_char = "";
            $params = array(':goods_id' => $goods->goods_id);
            $sql = "select name,logo,money as s_money,money2 as m_money,dn_money as L_money from imss_cjdc_goods where id = :goods_id";
            $goods_rs = DI()->notorm->dual->queryAll($sql, $params);
            //var_dump($goods_rs);

            switch ($goods->size) {
                case 1:
                    $size_char = "Sサイズ";
                    $money_char = $goods_rs[0]["s_money"];
                    break;
                case 2:
                    $size_char = "Mサイズ";
                    $money_char = $goods_rs[0]["m_money"];
                    break;
                case 3:
                    $size_char = "サイズ";
                    $money_char = $goods_rs[0]["l_money"];
                    break;
            }

            switch ($goods->hot_ice) {
                case "ice":
                    $icehot_char = "アイス";
                    break;
                case "hot":
                    $icehot_char = "ホット";
                    break;

            }

            if ($goods->hot_ice == 'ice') {
                $params = array(':store_id' => $this->store_id, ':lvl_id' => $goods->ice);
                $sql = "select lvl_name from pan_storeset where store_id = :store_id and ice_suger=1 and lvl_id = :lvl_id";
                $ice_rs = DI()->notorm->dual->queryAll($sql, $params);
                $ice_char = $ice_rs[0]["lvl_name"];
            }

            $params = array(':store_id' => $this->store_id, ':lvl_id' => $goods->suger);
            $sql = "select lvl_name from pan_storeset where store_id = :store_id and ice_suger=2 and lvl_id = :lvl_id";
            $suger_rs = DI()->notorm->dual->queryAll($sql, $params);
            $suger_char = $suger_rs[0]["lvl_name"];


            $temp_goods["logo"] = $goods_rs[0]["logo"];
            if ($goods->hot_ice == 'ice') {
                $temp_goods["name"] = $goods_rs[0]["name"] . " (" . $size_char . ")" . " " . $icehot_char . " " . "氷：" . $ice_char." 甘さ：".$suger_char;
            } else {
                $temp_goods["name"] = $goods_rs[0]["name"] . " (" . $size_char . ")" . " " . $icehot_char . " " ." 甘さ：".$suger_char;
            }

            $temp_goods["money"] = $money_char;
            $result["money_sum"] = $result["money_sum"]+$money_char;
            $params = array(':store_id' => $this->store_id, ':goods_id' => $goods->goods_id,':size_lvl' => $goods->size,':ice_hot' => $goods->hot_ice,':ice_lvl' => $goods->ice,':suger_lvl' => $goods->suger);
            $sql = "select bar_code from pan_goodsbar where store_id = :store_id and goods_id = :goods_id and size_lvl = :size_lvl and ice_hot= :ice_hot and ice_lvl=:ice_lvl and suger_lvl = :suger_lvl";
            $barcode_rs = DI()->notorm->dual->queryAll($sql, $params);
            $barcode_char = $barcode_rs[0]["bar_code"];
            $temp_goods["bar_code"] = $barcode_char;

            array_push($result_goodslist, $temp_goods);
            /*オプション追加*/
            foreach (json_decode($goods->option) as $option_obj) {

                $temp_options = array();
                $params = array(':store_id' => $this->store_id, ':option_id' => $option_obj);
                $sql = "select option_name,option_money,bar_code from pan_options where store_id = :store_id and option_id=:option_id";
                $option_rs = DI()->notorm->dual->queryAll($sql, $params);

                $temp_options["logo"] = "";
                $temp_options["name"] =$option_rs[0]["option_name"];
                $temp_options["money"] = $option_rs[0]["option_money"];
                $temp_options["bar_code"] = $option_rs[0]["bar_code"];

                $result["money_sum"] = $result["money_sum"]+$temp_options["money"];

                array_push($result_goodslist, $temp_options);
            }
        }

        $result["goods"] = $result_goodslist;

//
//        $note = $not_rs["0"]["note"];
//        $obj = json_decode($note);
//
////select name,logo,money as s_money,money2 as m_money,dn_money as L_money from imss_cjdc_goods where id = 2
//
//        $options = json_decode($obj[0]->option);


        return $result;

    }

    public function jsonDecode()
    {
        // 将JSON编码的字符串分配给PHP变量
        $json = '{"Peter":65,"Harry":80,"John":78,"Clark":90}';
        // 将JSON数据解码为PHP关联数组

        $arr = json_decode($json, true);
        // Access values from the associative array
        echo $arr["Peter"];  // Output: 65
        echo $arr["Harry"];  // Output: 80
        echo $arr["John"];   // Output: 78
        echo $arr["Clark"];  // Output: 90

        // 将JSON数据解码为PHP对象
        $obj = json_decode($json);

        // 返回对象的访问值
        echo $obj->Peter;   // Output: 65
        echo $obj->Harry;   // Output: 80
        echo $obj->John;    // Output: 78
        echo $obj->Clark;   // Output: 90

        return $arr;
    }


}
