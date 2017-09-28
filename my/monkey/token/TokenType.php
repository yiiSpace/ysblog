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
}

