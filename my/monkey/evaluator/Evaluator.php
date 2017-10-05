<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:58
 */

namespace monkey\evaluator;


use monkey\ast\ExpressionStatement;
use monkey\ast\InfixExpression;
use monkey\ast\IntegerLiteral;
use monkey\ast\Node;
use monkey\ast\PrefixExpression;
use monkey\ast\Program;
use monkey\ast\Statement;
use monkey\object\Boolean;
use monkey\object\Integer;
use monkey\object\Nil;
use monkey\object\Object;
use monkey\object\ObjectType;

//use monkey\object\Object;


class Evaluator
{
    /**
     * @var Boolean
     */
    public static $TRUE;

    /**
     * @var Boolean
     */
    public static $FALSE;

    /**
     * @var Nil
     */
    public static $NULL;
    /*
    protected static function InitBooleans()
    {
        self::$TRUE = Boolean::CreateWith([
            'Value' => true,
        ]);
        self::$FALSE = Boolean::CreateWith([
            'Value' => false,
        ]);
    }
    */

    /**
     * @param Node $node
     * @return \monkey\object\Object
     */
    public static function DoEval(Node $node) // :Object
    {
        switch (true) {

            case $node instanceof Program:
                return self::evalStatements($node->Statements);

            case $node instanceof ExpressionStatement:
                return self::DoEval($node->Expression);

            case $node instanceof IntegerLiteral :
                return Integer::CreateWith([
                    'Value' => $node->Value,
                ]);

            case $node instanceof \monkey\ast\Boolean:
                /*
                return Boolean::CreateWith([
                    'Value' => $node->Value,
                ]);
                */
                return static::nativeBoolToBooleanObject($node->Value);

            case $node instanceof PrefixExpression:
                $right = static::DoEval($node->Right);
                return static::evalPrefixExpression($node->Operator, $right);

            case $node instanceof InfixExpression:
                $left = static::DoEval($node->Left);
                $right = static::DoEval($node->Right);
                return static::evalInfixExpression($node->Operator ,$left,$right) ;

        }
        return null;
    }

    /**
     * @param $input
     * @return Boolean
     */
    protected static function nativeBoolToBooleanObject($input): Boolean
    {
        if ($input) {
            return static::$TRUE;
        }
        return static::$FALSE;
    }

    /**
     * @param array|Statement[] $stmts
     * @return Object
     */
    public static function evalStatements($stmts = []) // : Object
    {
        /** @var Object $result */
        $result = null;

        foreach ($stmts as $stmt) {
            $result = static::DoEval($stmt);
        }

        return $result;
    }

    /**
     * @param string $operator
     * @param Object $right
     * @return Object|null
     */
    protected static function evalPrefixExpression($operator = '', $right) // :Object
    {
        switch ($operator) {
            case '!':
                return static::evalBangOperatorExpression($right);
            case '-':
                return static::evalMinusPrefixOperatorExpression($right);
            default:
                return self::$NULL;
        }
    }

    /**
     * @param string $operator
     * @param \monkey\object\Object $left
     * @param \monkey\object\Object $right
     * @return \monkey\object\Object
     */
    protected static function evalInfixExpression($operator='',$left,$right) // :Object
    {
        switch (true){
            case $left->Type() == ObjectType::INTEGER_OBJ && $right->Type() == ObjectType::INTEGER_OBJ:
                return static::evalIntegerInfixExpression($operator,$left,$right);

            default:
                return static::$NULL ;
        }
    }
    /**
     * @param string $operator
     * @param \monkey\object\Object $left
     * @param \monkey\object\Object $right
     * @return \monkey\object\Object
     */
    protected static function evalIntegerInfixExpression($operator='',$left,$right)
    {
        $leftVal = $left->Value ;
        $rightVal = $right->Value ;

        switch ($operator){
            case '+':
                return Integer::CreateWith(['Value'=>$leftVal + $rightVal]) ;
            case '-':
                return Integer::CreateWith(['Value'=>$leftVal - $rightVal]) ;
            case '*':
                return Integer::CreateWith(['Value'=>$leftVal * $rightVal]) ;
            case '/':
                return Integer::CreateWith(['Value'=>$leftVal / $rightVal]) ;
            default:
                return static::$NULL ;
        }
    }

    /**
     * @TODO 搞清楚php中的 ==  在左右值是对象时的行为（对比指针？）
     *
     * @param Object $right
     * @return Object
     */
    protected static function evalBangOperatorExpression(Object $right) // :Object
    {
        switch ($right) {
            case static::$TRUE:
                return static::$FALSE;
            case static::$FALSE:
                return static::$TRUE;
            case static::$NULL:
                return static::$TRUE;
            default:
                return static::$FALSE;
        }
    }

    /**
     * @param \monkey\object\Object $right
     * @return Object
     */
    protected static function evalMinusPrefixOperatorExpression($right) // :Object
    {
        if ($right->Type() != ObjectType::INTEGER_OBJ) {
            return static::$NULL;
        }
        if ($right instanceof Integer) {
            $value = $right->Value;
            return Integer::CreateWith([
                'Value' => -$value
            ]);
        }

    }
}

(function () {
    // 只实例化一次
    // if (isset(Evaluator::$TRUE)) return;

    Evaluator::$TRUE = Boolean::CreateWith([
        'Value' => true,
    ]);
    Evaluator::$FALSE = Boolean::CreateWith([
        'Value' => false,
    ]);

    Evaluator::$NULL = Nil::CreateWith();
})();

// InitBooleans();
