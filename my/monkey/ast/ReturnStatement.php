<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 15:22
 */

namespace monkey\ast;


use monkey\token\Token;

class ReturnStatement implements Statement
{
    /**
     * the 'return' token
     *
     * @var Token
     */
    public $Token  ;

    /**
     * @var Expression
     */
    public $ReturnValue ;
    /**
     * @return string
     */
    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }

    public function statementNode()
    {

    }
}