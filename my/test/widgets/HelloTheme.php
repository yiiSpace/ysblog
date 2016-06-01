<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/1
 * Time: 18:47
 */

namespace my\test\widgets;


use yii\base\Widget;

class HelloTheme extends Widget
{

    public function run()
    {
       return $this->render('hello') ;
    }
}