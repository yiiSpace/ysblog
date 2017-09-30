<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:12
 */

namespace monkey\parser;


use monkey\ast\Identifier;
use monkey\ast\LetStatement;
use monkey\ast\Program;
use monkey\ast\Statement;
use monkey\lexer\Lexer;
use monkey\token\Token;
use monkey\token\TokenType;

class Parser
{
    /**
     * @var Lexer
     */
    public $L;

    /**
     * @var Token
     */
    protected $curToken;

    /**
     * @var Token
     */
    protected $peekToken;

    /**
     * @param Lexer $l
     * @return Parser
     */
    public static function NewParser(Lexer $l): Parser
    {
        $p = new static();

        $p->L = $l;

        $p->nextToken();
        $p->nextToken();

        return $p;
    }

    /**
     *
     */
    protected function nextToken()
    {
        $this->curToken = $this->peekToken;
        $this->peekToken = $this->L->NextToken();

    }

    /**
     * @return Program
     */
    public function ParseProgram(): Program
    {
        $program = new Program();
        $program->Statements = [];

        for (; $this->curToken->Type != TokenType::EOF;) {
            $stmt = $this->parseStatement();
            if ($stmt) {
                // array_push($program->Statements,$stmt) ;
                   $program->Statements[] = $stmt ;
            }
            $this->nextToken() ;
        }
        return $program ;
    }

    /**
     * @return Statement
     */
    protected function parseStatement():Statement{
        switch ($this->curToken->Type){
            case TokenType::LET :
                return $this->parseLetStatement() ;
            default:
                return null ;
        }
    }

    /**
     * @return LetStatement
     */
    protected function parseLetStatement() :LetStatement{
        $stmt = new LetStatement();
        $stmt->Token = $this->curToken ;

        if(! $this->expectPeek(TokenType::IDENT)){
            return null ;
        }



        $stmt->Name = new Identifier() ;
        $stmt->Name->Token = $this->curToken ;
        $stmt->Name->Value = $this->curToken->Literal ;

        if(!$this->expectPeek(TokenType::ASSIGN)){
            return null ;
        }

        for(; !$this->curTokenIs(TokenType::SEMICOLON) ;){
            $this->nextToken() ;
        }
        // var_dump($stmt) ; die(__METHOD__) ;
        return $stmt ;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function curTokenIs($tokenType) :bool {
        return $this->curToken->Type == $tokenType ;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function peekTokenIs($tokenType):bool {
        return $this->peekToken->Type == $tokenType ;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function expectPeek($tokenType) : bool {
        if ($this->peekTokenIs($tokenType)){
            $this->nextToken() ;
            return true ;
        }

        return false ;
    }
}