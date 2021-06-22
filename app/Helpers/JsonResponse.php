<?php
namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

/**
 * API统一返回json格式
 * Author:LUCAS
 * DateTime:2021/5/18 11:22
 * Trait JsonResponse
 * @package App\Helpers
 */
trait JsonResponse
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


    /**
     * 成功返回，默认code为1
     * Author:LUCAS
     * DateTime:2021/5/18 11:23
     * @param $data
     * @param string $message
     * @return mixed
     */
    public function success($data, $message = "success"){
        $this->setCode(config('code.success'));
        return $this->res($data,$message);
    }

    /**
     * 失败返回
     * Author:LUCAS
     * DateTime:2021/5/18 11:23
     * @param $message
     * @param string $code
     * @return mixed
     */
    public function failed($message, $code = ''){
        if (empty($code)){
            $this->setCode(config('code.fail'));
        }
        return $this->res([],$message,$code);
    }
    

    /**
     * 通用返回数据
     * Author:LUCAS
     * DateTime:2021/5/18 11:24
     * @param array $data
     * @param string $message
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json($res);

    }

    #未public的方法返回数组
    /**
     * Author:LUCAS
     * DateTime:2021/5/27 10:53
     * @param array $data
     * @param string $message
     * @param null $code
     * @return array
     */
    public function arr(array $data, $message = "",$code = null){
        if ($code){
            $this->setCode($code);
        }
        if (!empty($message)){
            $this->message = $message;
        }
        $arr = [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $data,
        ];

        return $arr;
    }

    /**
     * Author:LUCAS
     * DateTime:2021/5/27 10:53
     * @param $data
     * @param string $message
     * @return array
     */
    public function successToArray($data, $message = "success"){
        $this->setCode(config('code.success'));
        return $this->arr($data,$message);
    }

    /**
     * Author:LUCAS
     * DateTime:2021/5/27 10:53
     * @param $message
     * @param string $code
     * @return array
     */
    public function failedToArray($message, $code = ''){
        if (empty($code)){
            $this->setCode(config('code.fail'));
        }
        return $this->arr([],$message,$code);
    }

}
