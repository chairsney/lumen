<?php
/**
 *Author：LUCAS
 *DateTime:2021/5/29 11:44
 *Description:
 */

namespace App\Helpers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * 日志类
 */
class LogHelper
{
    private static $channel = 'api_logs';//默认放在storage/logs/api_logs目录下的api.log

    /**
     * 生成日志。默认不设置channel，若设置channel则脱离配置规则。
     * Author:LUCAS
     * DateTime:2021/6/4 9:45
     * @param string $title
     * @param array $content
     * @param string $file
     * @param int $level
     * @param string $channel
     * @throws \Exception
     */
    public static function log($title, $content, $file='api', $level=Logger::INFO, $channel='')
    {
        #配置channel信息
        if (empty($channel)) {
            $channel = self::$channel;
            if (env('LOG_CHANNEL_IS_DATE')){
                $channel = $channel.'_'.date('Ymd'); //开启日期模式
            }
        }

        #配置文件名
        if (env('LOG_FILE_IS_DATE')){
            $file = $file.'_'.date('Ymd');//开启日期模式
        }

        #生成日志
        $log = new Logger($channel);
        $log->pushHandler(new StreamHandler(storage_path('logs/' . $channel . '/'. $file . '.log'), 0));
        if ($level === Logger::INFO) {
            $log->info($title, $content);
        } elseif ($level === Logger::ERROR) {
            $log->error($title, $content);
        }

    }

    /**
     * Author:LUCAS
     * DateTime:2021/6/4 9:49
     * @param string $title
     * @param array $content
     * @param string $file
     * @param string $channel
     * @throws \Exception
     */
    public static function info($title, $content=[], $file='info',$channel='')
    {
        self::log($title, $content, $file, Logger::INFO, $channel) ;
    }

    /**
     * Author:LUCAS
     * DateTime:2021/6/4 9:49
     * @param string $title
     * @param array $content
     * @param string $file
     * @param string $channel
     * @throws \Exception
     */
    public static function error($title, $content=[], $file='error',$channel='')
    {
        self::log($title, $content, $file, Logger::ERROR, $channel);
    }
}