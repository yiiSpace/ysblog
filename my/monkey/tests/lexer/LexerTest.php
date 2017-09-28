<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 11:36
 */

namespace yiiunit\extensions\monkey\lexer;

use yiiunit\extensions\monkey\TestCase;

use monkey\lexer\Lexer;
use monkey\token\TokenType;


class LexerTest extends TestCase
{
    public function testNextToken()
    {
        $input = <<<IN
=+(){},;
IN;
        /**
         * expectedType token.TokenType
         * expectedLiteral string
         */
        $tests = [
            [TokenType::ASSIGN, "="],
            [TokenType::PLUS, "+"],
            [TokenType::LPAREN, "("],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::RBRACE, "}"],
            [TokenType::COMMA, ","],
            [TokenType::SEMICOLON, ";"],
            [TokenType::EOF, ""],
            [TokenType::EOF, ""],
            [TokenType::EOF, ""],
            [TokenType::EOF, ""],
        ];

        $l = Lexer::NewLexer($input);



        foreach ($tests as $i => $tt) {
            $tok = $l ->NextToken();

            print_r([
               'type'=>$tok->Type,
               'literal'=>$tok->Literal,
            ]);

            printf("%s  =>  %s \n ",$tt[0],$tt[1]) ;
             // var_dump($tok) ; // die();
             /*
            $this->assertEquals($tok->Type, $tt[0]);
            $this->assertEquals($tok->Literal, $tt[1]);
             */

            //  if($tok->Type != $tt[0]){            }
        }
    }

}