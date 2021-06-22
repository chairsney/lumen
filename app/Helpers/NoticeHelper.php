<?php
/**
 *Author：LUCAS
 *DateTime:2021/6/14 10:23
 *Description:通知管理：包含推送，短信，站内信
 */

namespace App\Helpers;

use App\Models\UserCode;
use App\Models\V2\Message;
use UmengClass;
class NoticeHelper
{
    private static $log_file = "message";
    private static $log_dir ="api_logs/message";

    /**
     * 推送
     * Author:LUCAS
     * DateTime:2021/6/14 10:35
     * @param $user_id
     * @param $title
     * @param $origin
     * @param $origin_value
     * @throws \Exception
     */
    public static function push($user_id,$title,$origin,$origin_value){
        $um_ios = new UmengClass("5fd47ef7dd289153391b69b7", "ru1kezbvq2fkikyfrjku7xduyks2aown");
        $um_adr = new UmengClass("5fd45a21498d9e0d4d8b2e1d", "e1gogphibhov90j50jydyq7y3uwtmfte");
        $uc = new UserCode();
        $tmp = $uc->getInfo($user_id);
        $r = false;
        if(!empty($tmp)){
            $p=array(
                'app_name'=>'雪道',
                'title'=>$title,
                'badge'=>'1',
                'production_mode'=>true,
                'ptype'=>$origin,
                'pvalue'=>$origin_value,
                'device_token'=>$tmp['client_id'],
                'tag_name'=>''
            );
            LogHelper::info("发送推送",$p,self::$log_file,self::$log_dir);
            if($tmp['mobile']==100){
                $r=$um_ios->sendIOSUnicast($p);
            }else if($tmp['mobile']==101){
                $r=$um_adr->sendAndroidBroadcast($p);
            }
            return $r;
        }
    }

    /**
     * 短信
     * Author:LUCAS
     * DateTime:2021/6/14 10:35
     * @param $mobile
     * @param $content
     * @throws \Exception
     */
    public static function sms($mobile,$content){
        $log_data = [
            'mobile'=>$mobile,
            'content'=>$content,
        ];
        LogHelper::info('发送短信：',$log_data,self::$log_file,self::$log_dir);
        $url = 'http://101.200.29.88:8082/SendMT/SendMessage?CorpID=miyuan&Pwd=genting2015&Mobile='.$mobile ."&Content=" . $content;
        $back_data = file_get_contents($url);
    }

    /**
     * 站内信
     * Author:LUCAS
     * DateTime:2021/6/14 10:35
     * @param $user_id
     * @param $title
     * @param $content
     * @param $origin
     * @param $origin_value
     * @return int
     * @throws \Exception
     */
    public static function message($user_id,$title,$content,$origin,$origin_value){
        $dated = date("Y-m-d H:i:s");
        $arr=array(
            'type'=>100,
            'user_id'=>$user_id,
            'title'=>$title,
            'content'=>$content,
            'origin'=>$origin,
            'origin_value'=>$origin_value,
            'dated'=>$dated,
            'state'=>1
        );
        LogHelper::info('发送站内信：',$arr,self::$log_file,self::$log_dir);
        $id = Message::insertGetId($arr);
        return $id;
    }
}