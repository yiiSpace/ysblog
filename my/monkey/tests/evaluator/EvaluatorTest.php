<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:59
 */

namespace yiiunit\extensions\monkey\evaluator;


use monkey\evaluator\Evaluator;
use monkey\object\Boolean;
use monkey\object\Integer;
use monkey\object\Object;
use monkey\parser\Parser;
use yiiunit\extensions\monkey\TestCase;

class EvaluatorTest extends TestCase
{
    public function testEvalIntegerExpression()
    {
        $tests = [
            ["5", 5],
            ["10", 10],
            ["-5", -5],
            ["-10", -10],
            ["5 + 5 + 5 + 5 - 10", 10],
            ["2 * 2 * 2 * 2 * 2", 32],
            ["-50 + 100 + -50", 0],
            ["5 * 2 + 10", 20],
            ["5 + 2 * 10", 25],
            ["20 + 2 * -10", 0],
            ["50 / 2 * 2 + 10", 60],
            ["2 * (5 + 10)", 30],
            ["3 * 3 * 3 + 10", 37],
            ["3 * (3 * 3) + 10", 37],
            ["(5 + 10 * 2 + 15 / 3) * 2 + -10", 50],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $this->_testIntegerObject($evaluated, $tt[1]);
        }
    }

    public function testEvalBooleanExpression()
    {
        $tests = [
            ['true', true],
            ['false', false],

            ["1 < 2", true],
            ["1 > 2", false],
            ["1 < 1", false],
            ["1 > 1", false],
            ["1 == 1", true],
            ["1 != 1", false],
            ["1 == 2", false],
            ["1 != 2", true],

            ["true == true", true],
            ["false == false", true],
            ["true == false", false],
            ["true != false", true],
            ["false != true", true],
            ["(1 < 2) == true", true],
            ["(1 < 2) == false", false],
            ["(1 > 2) == true", false],
            ["(1 > 2) == false", true],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            // var_dump($evaluated) ;
            // die(__METHOD__) ;
            $this->_testBooleanObject($evaluated, $tt[1]);
        }
    }

    public function testIfElseExpression()
    {
        $tests = [
            ["if (true) { 10 }", 10],
            ["if (false) { 10 }", null],
            ["if (1) { 10 }", 10],
            ["if (1 < 2) { 10 }", 10],
            ["if (1 > 2) { 10 }", null],
            ["if (1 > 2) { 10 } else { 20 }", 20],
            ["if (1 < 2) { 10 } else { 20 }", 10],
        ];

        foreach ($tests as $_=>$tt){
            $evaluated = $this->_testEval($tt[0]);
            $integer = $tt[1];
            $type = gettype($integer);
            if($type == 'integer'){
                $this->_testIntegerObject($evaluated,$integer) ;
            }else{
                $this->_testNullObject($evaluated) ;
            }
        }
    }

    /**
     * @param \monkey\object\Object $obj
     * @return bool
     */
    protected function _testNullObject($obj) :bool {
       if($obj != Evaluator::$NULL){
           $this->assertTrue(false,
               sprintf("object is not NULL. got=%s (%s)", gettype($obj), $obj)
           );
           return false ;
       }
       return true ;
    }

    public function testBangOperator()
    {
        $tests = [
            ["!true", false],
            ["!false", true],
            ["!5", false],
            ["!!true", true],
            ["!!false", false],
            ["!!5", true],
        ];

        foreach ($tests as $_ => $tt) {
            $evaluated = $this->_testEval($tt[0]);
            $this->_testBooleanObject($evaluated, $tt[1]);
        }
    }

    /**
     * @param string $input
     * @return Object
     */
    protected function _testEval($input) // :Object
    {
        $l = \monkey\lexer\Lexer::NewLexer($input);
        $p = Parser::NewParser($l);
        $program = $p->ParseProgram();

        return Evaluator::DoEval($program);
    }

    /**
     * @param Object $obj
     * @param int $expected
     * @return bool
     */
    protected function _testIntegerObject(Object $obj, $expected = 0): bool
    {
        $result = $obj;
        if (!$obj instanceof Integer) {
            $this->assertTrue(false,
                sprintf("object is not Integer. got=%s (%s)", gettype($obj), $obj)
            );
            return false;
        }
        if ($result->Value != $expected) {
            $this->assertTrue(false,
                sprintf("object has wrong value. got=%d, want=%d",
                    $result->Value, $expected)
            );
            return false;
        }

        return true;
    }

    /**
     * @param Object $obj
     * @param int $expected
     * @return bool
     */
    protected function _testBooleanObject(Object $obj, $expected = 0): bool
    {
        $result = $obj;
        if (!$obj instanceof Boolean) {
            $this->assertTrue(false,
                sprintf("object is not Boolean. got=%s (%s)", gettype($obj), $obj)
            );
            return false;
        }
        if ($result->Value != $expected) {
            $this->assertTrue(false,
                sprintf("object has wrong value. got=%s, want=%s",
                    $result->Value, $expected)
            );
            return false;
        }

        return true;
    }
}