<?php
namespace App\Helpers;
/**
 * 模型统一返回array格式（程序内使用）
 * Author:LUCAS
 * DateTime:2021/5/18 11:25
 * Trait ModelResponse
 * @package App\Helpers
 */
trait ModelResponse
{

    protected $code = 1;
    protected $message = "success";
    protected $data = [];


    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }



    public function success($data, $message = "success"){
        $this->setCode(config('code.success'));
        return $this->res($data,$message);
    }

    public function failed($message, $code = ''){
        if (empty($code)){
            $this->setCode(config('code.fail'));
        }
        return $this->res([],$message,$code);
    }

    /**
     * 返回数据
     * Author:LUCAS
     * DateTime:2021/5/18 11:26
     * @param array $data
     * @param string $message
     * @param null $code
     * @return array
     */
    public function res(array $data, $message = "",$code = null){

        if ($code){
            $this->setCode($code);
        }
        if (!empty($message)){
            $this->message = $message;
        }
        $res = [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $data,
        ];

        return $res;

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

