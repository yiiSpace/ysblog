<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 14:37
 */

namespace tests\codeception\unit\common\rest;


class UtilTest extends  \yii\codeception\TestCase
{

    protected function safeOp($op)
    {
        return \common\rest\Util::safeFilterOperator($op) ;
    }
    public function testSafeFilterOperator()
    {

        /*
        $this->specify('should eq ', function ()  {
             // expect('eq  ==>  == ',$this->safeOp('eq'))->equals('=');
             expect('eq  ==>  == ','=')->equals('=');
        });
        *
         *
         */
        expect('eq  ==>  == ',$this->safeOp('eq'))->equals('=');
        // expect('eq  ==>  == ',$this->safeOp('eq'))->equals('==');
    }
}