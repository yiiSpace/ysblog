<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/6
 * Time: 5:47
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

class Environment
{
    use CreateWith;

    /**
     * @return static
     */
    public static function NewEnvironment() // : Evironment
    {
        // @see http://php.net/manual/en/class.splobjectstorage.php
        // php中数组可以当哈希用  不过如果想提供对象做键 需要使用splObjectStorage！
        $s = [];
        return static::CreateWith([
            'store' => $s,
        ]);
    }

    /**
     *
     * @var array|\SplObjectStorage
     *          string=>Object
     */
    protected $store = [] ;

    /**
     * @param string $name
     * @return bool
     */
    public function Exists($name)
    {
        return isset($this->store[$name]) ;
    }
    /**
     * @param string $name
     * @return Object|null
     *
     */
    public function Get($name) // :Object
    {
        return $this->store[$name] ;
    }

    /**
     * @param string $name
     * @param Object $val
     * @return Object
     */
    public function Set($name='',Object $val) // :Object
    {
        $this->store[$name] = $val ;
        return $val ;
    }
}