<?php
namespace App\Traits;
/**
 * 返回array格式
 * Author:LUCAS
 * DateTime:2021/5/18 11:25
 * Trait ArrayTrait
 * @package App\Traits
 */
trait ArrayTrait
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
}

