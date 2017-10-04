<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:58
 */

namespace monkey\evaluator;


use monkey\ast\ExpressionStatement;
use monkey\ast\IntegerLiteral;
use monkey\ast\Node;
use monkey\ast\Program;
use monkey\object\Integer;
use monkey\object\Object;

class Evaluator
{

    /**
     * @param Node $node
     * @return Object
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


        }
        return null;
    }

    public static function evalStatements($stmts = []): Object
    {
        /** @var Object $result */
        $result = null;

        foreach ($stmts as $stmt) {
            $result = static::DoEval($stmt);
        }

        return $result;
    }
}