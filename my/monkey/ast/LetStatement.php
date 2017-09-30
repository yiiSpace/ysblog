<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:03
 */

namespace monkey\ast;


use monkey\token\Token;

class LetStatement implements Statement
{

    /**
     * @var Token
     */
    public $Token ;

    /**
     * @var Identifier
     */
    public $Name  ;

    /**
     * @var Expression
     */
    public $Value  ;

    public function TokenLiteral(): string
    {
        return $this->Token->Literal ;
    }

    public function statementNode()
    {
        // TODO: Implement statementNode() method.
    }
}