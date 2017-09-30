<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/30
 * Time: 7:32
 */

namespace yiiunit\extensions\monkey\parser;


 use monkey\ast\Statement;
 use monkey\ast\LetStatement;
 use monkey\lexer\Lexer;
 use monkey\parser\Parser;
 use yiiunit\extensions\monkey\TestCase;

// use PHPUnit\Framework\TestCase ;

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
        $p = Parser::NewParser($l) ;

        $program = $p->ParseProgram() ;
        $this->assertNotNull($program);

        $this->assertEquals(count($program->Statements),3);

        $tests = [
          ['x'],
          ['y'],
          ['foobar'],
        ];

        foreach ($tests as $i=>$tt){
            $stmt = $program->Statements[$i] ;
            $this->_testLetStatement($stmt,$tt[0]);
        }

    }

    /**
     * @param Statement $s
     * @param string $name
     * @return bool
     */
    protected function _testLetStatement(Statement $s , string $name) {
        $this->assertEquals($s->TokenLiteral(),'let');
        if($s instanceof LetStatement){
            $this->assertInstanceOf(LetStatement::class,$s);

            $this->assertEquals($s->Name->Value,$name);

            $this->assertEquals($s->Name->TokenLiteral(),$name);
        }
    }
}