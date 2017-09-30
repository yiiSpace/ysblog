<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 14:56
 */

namespace monkey\ast;

/**
 * Class Program
 * @package monkey\ast
 */
class Program implements Node
{
    /**
     * @var array|Node[]|Statement[]
     */
    public $Statements = [];

    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        if(count($this->Statements) >0 ){
            return $this->Statements[0]->TokenLiteral() ;
        }
        return '' ;
    }
}