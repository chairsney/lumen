<?php


namespace App\Helpers;

class CurlHelper
{
    private static $timeout = 555;
    private static $params_format = 'json';//必须是json或者是array
    /*
     * curl模拟post请求云顶数据
     * 传入json
     * 返回array
     * */
    public function yd_curl_post($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }


    /**
     *curl
     *1 $url    地址
     *2 $params 传入数据 --默认json格式
     *3 $method 方法 --默认POST
     *4 $config['header'] 头部数据
     *  $config['params_format'] params数据格式
     *  $config['cookies']
     *  $config['timeout']
     *  $config['accept'] --默认是json，其他则赋值0
     *  $config['content-type'] --默认是json，其他则赋值如Content-Type: application/x-www-form-urlencoded
     *  $config['authorization']--例如$config['authorization'] = 'Authorization: Bearer '.$this->access_token;
     *
     */
    public static function curl(
        $url,
        $params,
        $method = 'POST',
        $config = []
    )
    {
        //header设置
        if (!isset($config['header'])) {
            $header = [];
        } else {
            $header = $config['header'];
        }

        //超时设置
        if (!isset($config['timeout'])) {
            $timeout = self::$timeout;

        } else {
            $timeout = $config['timeout'];
        }

        //cookies设置
        if (!isset($config['cookies'])) {
            $cookies = [];
        } else {
            $cookies = $config['cookies'];
        }

        //params格式设置
        if (!isset($config['params_format'])) {
            $params_format = self::$params_format;
        }

        //header设置accept,content-type,Authorization
        if (!isset($config['accept'])) {
            $header[] = 'Accept: application/json';
        }
        if (!isset($config['content-type'])) {
            $header[] = 'Content-Type: application/json';
        }else{
            $header[] = $config['content-type'];
        }
        if (isset($config['authorization'])){
            $header[] = $config['authorization'];
        }


        // POST 提交方式的传入 $set_params 必须是字符串形式
        $opts = array(
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => 1,
            //CURLOPT_COOKIE => $cookie,
            CURLOPT_HTTPHEADER => $header,

        );

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                if ($params_format == 'json') {
                    $params = json_decode($params, true);
                }
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'X-WWW-FORM-URLENCODED':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                if ($params_format == 'json') {
                    $params = json_decode($params, true);
                }
                $opts[CURLOPT_POSTFIELDS] = http_build_query($params);
                break;
            case 'DELETE':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_HTTPHEADER] = array("X-HTTP-Method-Override: DELETE");
                $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'PUT':
                $opts[CURLOPT_URL] = $url;
                //$opts[CURLOPT_POST] = 0;
                $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        LogHelper::info('curl访问方式为'.$opts[CURLOPT_CUSTOMREQUEST].'访问地址为'.$opts[CURLOPT_URL],[]);
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);

        if ($errno > 0) {
            $err = [
                'code' => 0,
                'message' => "[curl]请求出错，错误码：".$errno."。" . $error,
                'data' => [],
            ];
            $err = json_encode($err);
            return $err;
        } else {
            return $data;
        }
    }

}