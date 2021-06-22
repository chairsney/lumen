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
}