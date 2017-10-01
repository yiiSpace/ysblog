<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 7:32
 */

namespace yiiunit\extensions\monkey\parser;


use monkey\ast\ExpressionStatement;
use monkey\ast\Identifier;
use monkey\ast\IntegerLiteral;
use monkey\ast\ReturnStatement;
use monkey\ast\Statement;
use monkey\ast\LetStatement;
use monkey\lexer\Lexer;
use monkey\parser\Parser;
use yiiunit\extensions\monkey\TestCase;

// use PHPUnit\Framework\TestCase ;

/**
 * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertEquals
 * 所有的assertXxx 方法 都可以添加最后一个message 消息参数！
 * Class ParserTest
 * @package yiiunit\extensions\monkey\parser
 */
class ParserTest extends TestCase
{

    public function testLetStatements()
    {
        $input = <<<IN
let x = 5;
let y = 10;
let foobar = 838383;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->assertNotNull($program);

        $this->assertEquals(count($program->Statements), 3);

        $tests = [
            ['x'],
            ['y'],
            ['foobar'],
        ];

        foreach ($tests as $i => $tt) {
            $stmt = $program->Statements[$i];
            $this->_testLetStatement($stmt, $tt[0]);
        }

    }

    public function testLetStatements2()
    {
        $input = <<<IN
let x =5;
let y = 10;
let foobar = 838383;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertNotNull($program);

        $this->assertEquals(count($program->Statements), 3);

        $tests = [
            ['x'],
            ['y'],
            ['foobar'],
        ];

        foreach ($tests as $i => $tt) {
            $stmt = $program->Statements[$i];
            $this->_testLetStatement($stmt, $tt[0]);
        }

    }

    /**
     *  测试输出相等！
     */
    public function testExpectFooActualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    protected function checkParserErrors(Parser $p)
    {
        $errors = $p->Errors();
        if (count($errors) == 0) {
            return;
        }

        // $this->assertEquals(count($errors),0);
        // $this->assertEmpty($errors ,sprintf("parser has %d errors", count($errors)));
        // print_r($errors) ;
        $this->assertCount(0, $errors, print_r($errors, true));
        foreach ($errors as $i => $error) {
            // echo '$i = '.$i , PHP_EOL;
            $this->assertEmpty($error, "parser error: {$error}");
        }

    }

    /**
     * @param Statement $s
     * @param string $name
     * @return bool
     */
    protected function _testLetStatement(Statement $s, string $name)
    {
        $this->assertEquals($s->TokenLiteral(), 'let');
        if ($s instanceof LetStatement) {
            $this->assertInstanceOf(LetStatement::class, $s);

            $this->assertEquals($s->Name->Value, $name);

            $this->assertEquals($s->Name->TokenLiteral(), $name);
        }
    }

    public function testReturnStatement()
    {
        $input = <<<IN
return 5;
return 10;
return 993322;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(3, $program->Statements
            , sprintf("program.Statements does not contain 3 statements. got=%d",
                count($program->Statements))
        );

        foreach ($program->Statements as $i => $stmt) {
            $this->assertInstanceOf(ReturnStatement::class, $stmt,
                sprintf("stmt not *ast.returnStatement. got=%s", gettype($stmt))
            );
            $this->assertEquals($stmt->TokenLiteral(), 'return',
                sprintf("returnStmt.TokenLiteral not 'return', got %s",
                    $stmt->TokenLiteral())
            );
        }

    }

    public function testIdentifierExpression()
    {
        $input = <<<IN
foobar;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );
        $ident = $stmt->Expression;
        $this->assertInstanceOf(Identifier::class,$ident,
            sprintf("stmt not Identifier. got=%s", gettype($ident))
        );

        $this->assertEquals($ident->Value, 'foobar',
            sprintf("ident.Value not %s. got=%s",
               'foobar',  $ident->Value)
        );

        $this->assertEquals($ident->TokenLiteral(), 'foobar',
            sprintf("ident.TokenLiteral not %s. got=%s",
                "foobar",  $ident->TokenLiteral())
        );
    }
    public function testIntegerExpression()
    {
        $input = <<<IN
5;
IN;

        $l = Lexer::NewLexer($input);
        $p = Parser::NewParser($l);

        $program = $p->ParseProgram();
        $this->checkParserErrors($p);

        $this->assertCount(1, $program->Statements
            , sprintf("program.Statements does not contain 1 statements. got=%d",
                count($program->Statements))
        );

        $stmt = $program->Statements[0];
        $this->assertInstanceOf(ExpressionStatement::class, $stmt,
            sprintf("stmt not ExpressionStatement. got=%s", gettype($stmt))
        );
        $literal = $stmt->Expression;
        $this->assertInstanceOf(IntegerLiteral::class,$literal,
            sprintf("stmt not Identifier. got=%s", gettype($literal))
        );

        $this->assertEquals($literal->Value, '5',
            sprintf("literal.Value not %d. got=%d",
               5,  $literal->Value)
        );
        if($literal instanceof IntegerLiteral){
            //  var_dump($literal);
            // var_dump($literal->TokenLiteral()) ;
        }

        $this->assertEquals($literal->TokenLiteral(), '5',
            sprintf("ident.TokenLiteral not %s. got=%s",
                "5",  $literal->TokenLiteral())
        );
    }

}