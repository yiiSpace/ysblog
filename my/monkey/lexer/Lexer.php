<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 11:54
 */

namespace monkey\lexer;


use monkey\token\Token;
use monkey\token\TokenType;
use yii\base\Exception;

class Lexer
{

    /**
     *
     * @param string $input
     * @return Lexer
     */
    public static function NewLexer($input = '')
    {
        $lexer = new Lexer();
        $lexer->input = $input;

        $lexer->readChar();

        return $lexer;
    }

    /**
     * @var string
     */
    protected $input = '';
    /**
     * current position in input (points to current char)
     * @var int
     */
    protected $position = 0;

    /**
     * current reading position in input (after current char)
     * @var int
     */
    protected $readPosition = 0;
    /**
     * current char under examination
     *
     * @var int|byte  php没有byte
     *   - ord()  函数返回字符串第一个字符的 ASCII 值
     *   - chr()  函数从指定的 ASCII 值返回字符。 这个函数正好和ord相反
     */
    protected $ch = 0;

    /**
     * @TODO 目前只支持 ASCII 字符
     */
    protected function readChar()
    {
        // mb_substr()
        if ($this->readPosition >= strlen($this->input)) {
            // 0, which is the ASCII code for the "NUL"
            $this->ch = 0;

            // die('over：'.$this->ch);
        } else {
            $this->ch = $this->input[$this->readPosition]; // 需要做 ord() ???
        }

        $this->position = $this->readPosition;
        $this->readPosition += 1;
    }

    public function NextToken(): Token
    {
        /** @var Token $tok */
        $tok = null;
        // print_r($this->ch ." -------------------") ;
        // switch case  有个致命的问题 比较使用的是 == :  if( 0 == 'anything'){  die("oh ! no!!!");  }
        /**
         * 改写结构：
         * $mixed = 0;
         * switch(TRUE){
         * case (NULL===$mixed): //blah break;
         * case (0   ===$mixed): //etc. break;
         * }
         */
        switch ($this->ch) {
            case '=':
                $tok = $this->newToken(TokenType::ASSIGN, $this->ch);
                break;
            case ';':
                $tok = $this->newToken(TokenType::SEMICOLON, $this->ch);
                break;

            case '(':
                $tok = $this->newToken(TokenType::LPAREN, $this->ch);
                break;

            case ')':
                $tok = $this->newToken(TokenType::RPAREN, $this->ch);
                break;

            case ',':
                $tok = $this->newToken(TokenType::COMMA, $this->ch);
                break;

            case '+':
                $tok = $this->newToken(TokenType::PLUS, $this->ch);
                break;

            case '{':
                $tok = $this->newToken(TokenType::LBRACE, $this->ch);
                break;

            case '}':
                $tok = $this->newToken(TokenType::RBRACE, $this->ch);
                break;

            case 0 : // 永远也匹配不上
                // default:
                $tok = $this->newToken(TokenType::EOF, "");
                break;
        }
        $this->readChar();
        return $tok;

    }

    /**
     * @param string $tokenType
     * @param int $ch
     * @return Token
     */
    protected function newToken(string $tokenType, $ch): Token
    {
        $tok = new Token();
        $tok->Type = $tokenType;
        $tok->Literal = $ch;  // TODO 这里要做字节到字符的转换

        if ($ch == '0') {
            // die(__METHOD__) ;
            throw  new Exception("hiiiii");
        }
        return $tok;
    }

}