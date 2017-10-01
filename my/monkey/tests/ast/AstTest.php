<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/1
 * Time: 14:09
 */

namespace yiiunit\extensions\monkey\ast;


use monkey\ast\Identifier;
use monkey\ast\LetStatement;
use monkey\ast\Program;
use monkey\token\Token;
use monkey\token\TokenType;
use yiiunit\extensions\monkey\TestCase;

class AstTest extends TestCase
{
    public function testString()
    {
        $program = new Program() ;
        $statements = [] ;
        $letStatement = new LetStatement() ;

        $token = new Token() ;
        $token->Type = TokenType::LET ;
        $token->Literal = 'let';

        $ident = new Identifier() ;
        $ident->Token = '' ;

    }

}