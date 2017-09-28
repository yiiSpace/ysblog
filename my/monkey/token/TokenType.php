<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 8:43
 */

namespace monkey\token;

class TokenType
{
    const ILLEGAL = "ILLEGAL";
    const EOF = "EOF";
    //  Identifiers +literals;
    const IDENT = "IDENT"; // add, foobar, x, y, ...;
    const INT = "INT";// 1343456;
    //  Operators;
    const ASSIGN = "=";
    const PLUS = "+";
    const MINUS = "-";
    const BANG = "!";
    const ASTERISK = "*";
    const SLASH = "/";
    const LT = "<";
    const GT = ">";
    //  Delimiters;
    const COMMA = ",";
    const SEMICOLON = ";";
    const LPAREN = "(";
    const RPAREN = ")";
    const LBRACE = "{";
    const RBRACE = "}";
    //  Keywords;
    const FUNCTION = "FUNCTION";
    const LET = "LET";
    const TRUE = "TRUE";
    const FALSE = "FALSE";
    const IF = "IF";
    const ELSE = "ELSE";
    const RETURN = "RETURN";

    /**
     * @var array
     */
    protected static $keywords = [
        'fn' => self::FUNCTION,
        'let' => self::LET,
        "true" => TRUE,
        "false" => self:: FALSE,
        "if" => self::IF,
        "else" => self::ELSE,
        "return" => self:: RETURN,
    ];

    /**
     * @param string $ident
     * @return string
     */
    public static function LookupIdent(string $ident): string
    {
        if (isset(static::$keywords[$ident])) {
            return static::$keywords[$ident];
        }
        return static::IDENT;
    }
}

