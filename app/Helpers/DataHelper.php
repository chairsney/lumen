<?php
/**
 *Author：LUCAS
 *DateTime:2021/6/4 11:04
 *Description:
 */

namespace App\Helpers;


class DataHelper
{
    #将XML转为array
    public static function xml_to_data($xml)
    {
        if (!$xml) {
            return false;
        }
        libxml_disable_entity_loader(true); //禁止引用外部xml实体
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }

    /**
     * 二维数组排序
     * Author:LUCAS
     * DateTime:2021/5/18 11:27
     * @param $array [需要排序的二维数组]
     * @param $keys [需要排序的列名]
     * @param int $sort [SORT_ASC升序 SORT_DESC降序]
     * @return mixed
     */
    public function arraySort($array, $keys, $sort = SORT_DESC) {
        $keysValue = [];
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }
}