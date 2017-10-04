<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:59
 */

namespace yiiunit\extensions\monkey\evaluator;


use monkey\evaluator\Evaluator;
use monkey\object\Integer;
use monkey\object\Object;
use monkey\parser\Parser;
use yiiunit\extensions\monkey\TestCase;

class EvaluatorTest extends TestCase
{
  public function testEvalIntegerExpression()
  {
      $tests = [
        ['5',5],
        ['10',10],
      ];

      foreach ($tests as $_=>$tt){
          $evaluated = $this->_testEval($tt[0]);
          $this->_testIntegerObject($evaluated,$tt[1]) ;
      }
  }

    /**
     * @param string $input
     * @return Object
     */
  protected function _testEval($input) // :Object
  {
    $l = \monkey\lexer\Lexer::NewLexer($input) ;
    $p = Parser::NewParser($l) ;
    $program = $p->ParseProgram() ;

    return Evaluator::DoEval($program) ;
  }

    /**
     * @param Object $obj
     * @param int $expected
     * @return bool
     */
  protected function _testIntegerObject(Object $obj, $expected=0):bool
  {
      $result = $obj ;
     if(!$obj instanceof  Integer){
         $this->assertTrue(false ,
             sprintf("object is not Integer. got=%s (%s)", gettype($obj), $obj)
             );
         return false ;
     }
      if($result->Value != $expected){
          $this->assertTrue(false ,
              sprintf("object has wrong value. got=%d, want=%d",
                  $result->Value, $expected)
          );
          return false ;
      }

      return true ;
  }
}