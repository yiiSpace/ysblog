<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/29
 * Time: 15:12
 */

namespace monkey\parser;


use monkey\ast\Expression;
use monkey\ast\ExpressionStatement;
use monkey\ast\Identifier;
use monkey\ast\LetStatement;
use monkey\ast\Program;
use monkey\ast\ReturnStatement;
use monkey\ast\Statement;
use monkey\lexer\Lexer;
use monkey\token\Token;
use monkey\token\TokenType;

class Parser
{

    const LOWEST = 1;
    const EQUALS = 2;  // ==
    const LESSGREATER = 3; // > or <
    const SUM = 4; // +
    const PRODUCT = 5; // *
    const PREFIX = 6; // -X or !X
    const CALL = 7; // myFunction(X)


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
     * @var array|string[]
     */
    protected $errors = [];

    /**
     * type (
     * prefixParseFn func() ast.Expression
     * infixParseFn func(ast.Expression) ast.Expression
     * )
     */
    /**
     * map[token.TokenType]prefixParseFn
     *
     * @var array
     */
    protected $prefixParseFns = [];
    /**
     * map[token.TokenType]infixParseFn
     *
     * @var array
     */
    protected $infixParseFns = [];

    /**
     * @param $tokenType
     * @param $fn
     */
    protected function registerPrefix($tokenType, $fn)
    {
        $this->prefixParseFns[$tokenType] = $fn;
    }

    protected function registerInfix($tokenType, $fn)
    {
        $this->infixParseFns[$tokenType] = $fn;
    }

    /**
     * @param Lexer $l
     * @return Parser
     */
    public static function NewParser(Lexer $l): Parser
    {
        $p = new static();
        $p->L = $l;

        $p->registerPrefix(TokenType::IDENT, [$p,'parseIdentifier']);

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
                $program->Statements[] = $stmt;
            }
            $this->nextToken();
        }
        return $program;
    }

    /**
     * @return Statement|null
     */
    protected function parseStatement() /* :?Statement */
    {
        switch ($this->curToken->Type) {
            case TokenType::LET :
                return $this->parseLetStatement();
            case TokenType::RETURN :
                return $this->parseReturnStatement();
            default:
                return $this->parseExpressionStatement();
        }
    }

    /**
     * @return Expression
     */
    protected function parseIdentifier()
    {
        return Identifier::CreateWith([
            'Token' => $this->curToken,
            'Value' => $this->curToken->Literal,
        ]);
    }

    /**
     * @return LetStatement|null
     */
    protected function parseLetStatement()
    {
        $stmt = new LetStatement();
        $stmt->Token = $this->curToken;

        if (!$this->expectPeek(TokenType::IDENT)) {
            return null;
        }


        $stmt->Name = new Identifier();
        $stmt->Name->Token = $this->curToken;
        $stmt->Name->Value = $this->curToken->Literal;

        if (!$this->expectPeek(TokenType::ASSIGN)) {
            return null;
        }

        for (; !$this->curTokenIs(TokenType::SEMICOLON);) {
            $this->nextToken();
        }
        // var_dump($stmt) ; die(__METHOD__) ;
        return $stmt;
    }

    /**
     * @return ReturnStatement
     */
    protected function parseReturnStatement() /*:?RetrunStatement */
    {
        $stmt = new ReturnStatement();
        $stmt->Token = $this->curToken;

        $this->nextToken();

        for (; !$this->curTokenIs(TokenType::SEMICOLON);) {
            $this->nextToken();
        }
        return $stmt;
    }

    /**
     * @return ExpressionStatement
     */
    public function parseExpressionStatement() /* :ExpressionStatement */
    {
        $stmt = ExpressionStatement::CreateWith([
            'Token' => $this->curToken,
        ]);

        $stmt->Expression = $this->parseExpression(static::LOWEST);

        if ($this->peekTokenIs(TokenType::SEMICOLON)) {
            $this->nextToken();
        }
        return $stmt;
    }

    /**
     * @param int $precedence
     * @return Expression
     */
    protected function parseExpression($precedence)
    {
        $prefix = $this->prefixParseFns[$this->curToken->Type];
        if (empty($prefix)) {
            return null;
        }
        $leftExp = call_user_func($prefix); // $prefix() ;
        return $leftExp;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function curTokenIs($tokenType): bool
    {
        return $this->curToken->Type == $tokenType;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function peekTokenIs($tokenType): bool
    {
        return $this->peekToken->Type == $tokenType;
    }

    /**
     * @param $tokenType
     * @return bool
     */
    protected function expectPeek($tokenType): bool
    {
        if ($this->peekTokenIs($tokenType)) {
            $this->nextToken();
            return true;
        }

        $this->peekError($tokenType);
        return false;
    }

    /**
     * @return array|string[]
     */
    public function Errors()
    {
        return $this->errors;
    }

    /**
     * @param $tokenType
     */
    protected function peekError($tokenType)
    {
        $msg = sprintf("expected next token to be %s, got %s instead",
            $tokenType, $this->peekToken->Type);
        $this->errors[] = $msg;
    }
}