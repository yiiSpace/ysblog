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
use monkey\ast\InfixExpression;
use monkey\ast\IntegerLiteral;
use monkey\ast\LetStatement;
use monkey\ast\PrefixExpression;
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
     * 优先级表
     *
     * @var array
     */
    protected static $precedences = [
        TokenType::EQ => self::EQUALS,
        TokenType::NOT_EQ => self::EQUALS,
        TokenType::LT => self:: LESSGREATER,
        TokenType::GT => self::LESSGREATER,
        TokenType::PLUS => self::SUM,
        TokenType::MINUS => self::SUM,
        TokenType::SLASH => self::PRODUCT,
        TokenType::ASTERISK => self::PRODUCT,
    ];

    /**
     * @return int
     */
    protected function peekPrecedence(): int
    {
        $p = self::$precedences[$this->peekToken->Type] ?? self::LOWEST;
        return $p;
    }

    /**
     * @return int
     */
    protected function curPrecedence(): int
    {
        return self::$precedences[$this->curToken->Type] ?? self::LOWEST;
    }

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
     * @param string $tokenType
     */
    protected function noPrefixParseFnError($tokenType)
    {
        $msg = sprintf("no prefix parse function for %s found", $tokenType);
        $this->errors[] = $msg;
    }

    /**
     * @param Lexer $l
     * @return Parser
     */
    public static function NewParser(Lexer $l): Parser
    {
        $p = new static();
        $p->L = $l;

        $p->registerPrefix(TokenType::IDENT, [$p, 'parseIdentifier']);
        $p->registerPrefix(TokenType::INT, [$p, 'parseIntegerLiteral']);

        $p->registerPrefix(TokenType::BANG, [$p, 'parsePrefixExpression']);
        $p->registerPrefix(TokenType::MINUS, [$p, 'parsePrefixExpression']);

        $p->registerInfix(TokenType::PLUS, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::MINUS, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::SLASH, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::ASTERISK, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::EQ, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::NOT_EQ, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::LT, [$p, 'parseInfixExpression']);
        $p->registerInfix(TokenType::GT, [$p, 'parseInfixExpression']);



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
     * @return Expression
     */
    public function parseIntegerLiteral()
    {
        // var_dump($this->curToken->Literal) ;
        $lit = IntegerLiteral::CreateWith([
            'Token' => $this->curToken,
        ]);
        try {
            $value = intval($this->curToken->Literal);
            // die("v: ".$value);
        } catch (\Exception $ex) {
            $msg = sprintf("could not parse %s as integer", $this->curToken->Literal);
            $this->errors[] = $msg;
            return null;
        }

        $lit->Value = $value;
        return $lit;
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
     * @return Expression|null
     */
    protected function parseExpression($precedence) // :?Expression
    {
        /**
         * php7 新增三元运算符
         *  $prefix = ... ?? false  等价:
         * $prefix = isset($$this->prefixParseFns[$this->curToken->Type]) ? $this->prefixParseFns[$this->curToken->Type] : false;
         */
        $prefix = $this->prefixParseFns[$this->curToken->Type] ?? false;

        if (empty($prefix)) {
            $this->noPrefixParseFnError($this->curToken->Type);
            return null;
        }
        $leftExp = call_user_func($prefix); // $prefix() ;

        while (
            !$this->peekTokenIs(TokenType::SEMICOLON)
            && $precedence < $this->peekPrecedence()
        ) {
            $infix = $this->infixParseFns[$this->peekToken->Type] ?? null ;
            if($infix == null){
                return $leftExp ;
            }

            $this->nextToken() ;

            $leftExp = call_user_func($infix,$leftExp);
        }
        return $leftExp;
    }

    /**
     * @return Expression
     */
    public function parsePrefixExpression()/*:Expression*/
    {
        $expression = PrefixExpression::CreateWith([
            'Token' => $this->curToken,
            'Operator' => $this->curToken->Literal,
        ]);

        $this->nextToken();

        $expression->Right = $this->parseExpression(static::PREFIX);

        return $expression;
    }

    /**
     * @param Expression $left
     * @return Expression
     */
    protected function parseInfixExpression(Expression $left) //:Expression
    {
        $expression = InfixExpression::CreateWith([
            'Token' => $this->curToken,
            'Operator' => $this->curToken->Literal,
            'Left' => $left,
        ]);

        $precedence = $this->curPrecedence();
        $this->nextToken();
        $expression->Right = $this->parseExpression($precedence);

        return $expression;
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