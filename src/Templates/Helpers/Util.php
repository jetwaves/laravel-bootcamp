<?php

namespace App\Helpers;

use Exception;

class Util
{

    /**
     * make Validator Error Message Readable
     *
     * */
    public static function getValidatorErrorMessage($validator)
    {
        $messages = $validator->errors();
        $msgArr = $messages->all();
        $arr = [];
        foreach ($msgArr as $k => $v) {
            $arr[] = $v;
        }
        $ret = implode(",", $arr);
        return $ret;
    }


    /**
     * generate random string of 6 digits
     *
     * @param int    $len
     * @param string $format
     * @return string
     */
    public static function randStr($len = 6, $format = 'ALL')
    {
        switch ($format) {
            case 'ALL':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
            case 'CHAR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
                break;
            case 'NUMBER':
                $chars = '0123456789';
                break;
            default :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
        }
        mt_srand((double)microtime() * 1000000 * getmypid());
        $randStr = "";
        while (strlen($randStr) < $len)
            $randStr .= substr($chars, (mt_rand() % strlen($chars)), 1);
        return $randStr;
    }

    public static function timestampToYmd($timeStamp)
    {
        return date('Y-m-d H:i:s', $timeStamp);
    }

    public static function uecho($msg, $crlf = false)
    {
        echo iconv('utf-8', 'GBK', $msg);
        if ($crlf) echo "\r\n";
    }

    public static function uprint_r($msg, $crlf = false)
    {
        echo iconv('utf-8', 'GBK', print_r($msg, true));
        if ($crlf) echo "\r\n";
    }


    public static function checkInputData($obj, $rules, $errMsg = [])
    {
        $validator = app('validator')->make($obj, $rules, $errMsg);
        if ($validator->fails()) throw new Exception(self::getValidatorErrorMessage($validator));
    }


    //  从Exception的 $e 对象获取异常内容 默认按照.env EXCEPTION_NEED_TRACE_DETAIL 的配置，否则用 0 1 控制是否需要 trace 详情
    public static function getExceptionMessage($e, $needTraceDetail = 2)
    {
        $needTraceDetailEnv = intval(env('EXCEPTION_NEED_TRACE_DETAIL'));
        if ($needTraceDetailEnv == 3) {
            return $e->getMessage() . "\r\n File: " . $e->getFile() . "\r\n Line: " . $e->getLine();
        }
        if ($needTraceDetail == 2) {
            $needTraceDetail = intval(env('EXCEPTION_NEED_TRACE_DETAIL'));
        }
        if ($needTraceDetail != 0) {
            $msg = $e->getMessage() . "\r\n File: " . $e->getFile() . "\r\n Line: " . $e->getLine() . "\r\n Trace :" . $e->getTraceAsString();
        } else {
            $msg = $e->getMessage() . "\r\n File: " . $e->getFile() . "\r\n Line: " . $e->getLine();
        }
        return $msg;
    }


}