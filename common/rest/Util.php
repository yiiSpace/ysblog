<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 11:34
 */

namespace common\rest;
use yii\base\InvalidParamException;

/**
 * 工具类
 *
 * Class Util
 * @package common\rest
 */
class Util
{

    /**
     * 安全过滤客户端的过滤操作符
     *
     * @param string $op
     * @return string
     */
    public static function  safeFilterOperator($op='' /*, $defaultOperator = '=' */ )
    {
        $op  = trim($op) ;

        static $opMapping = [
                'eq' => '=',
                'lt' => '<',
                'lte' => '<=',
                'gt' => '>',
                'gte' => '>=',
                'neq' => '<>',
            ];
        // 如果已经是yii支持的右侧操作符 直接返回
        if(in_array($op,array_values($opMapping))){
           return $op ;
        }

        if(isset($opMapping[$op])){
            return $opMapping[$op] ;
        }
        throw new InvalidParamException("the opepator not supported !  Supported :". implode(', ' , array_keys($opMapping))) ;
    }
}