<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:05
 */

namespace monkey\ast;


use monkey\token\Token;

class Identifier implements Expression
{
    /**
     * @var Token
     */
    public $Token  ;
    /**
     * @var string
     */
    public $Value ;

    public function expressionNode()
    {
        // TODO: Implement expressionNode() method.
    }

    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }
}