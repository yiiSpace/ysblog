<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/3
 * Time: 12:06
 */

namespace my\test\controllers;


use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use yii\web\Controller;

/**
 * 测试反射功能
 *
 *  早期的zend 库 也有反射扩展的！
 *
 * 以下库也是关于反射的
 * -  https://github.com/Speicher210/Reflection
 * -  https://github.com/nette/reflection
 * -  https://github.com/Andrewsville/PHP-Token-Reflection  此库 如果当 yii2-doc 不能用时底层可以考虑用它搞
 * -  https://github.com/phpDocumentor/Reflection
 * Class ReflectionController
 * @package my\test\controllers
 * --------------------------------------------
 *                  普庵咒
 *        滴滴刀 滴滴刀 茄茄 茄茄茄  :)
 * --------------------------------------------
 */
class ReflectionController extends Controller
{

    /**
     *
     */
    public function actionBetterReflection()
    {
        $reflector = new ClassReflector(new AggregateSourceLocator([
            // new SingleFileSourceLocator(__DIR__ . '/assets/MyClass.php'),
            new SingleFileSourceLocator(__FILE__),
        ]));

        $classes =  $reflector->getAllClasses() ;

        foreach($classes as $class)
        {
            echo 'class: ', $class->getName(), ' ', PHP_EOL ;
            /*
            $methods = $class->getMethods() ;
            foreach($methods as $method){
                echo 'method :', $method->getName(), PHP_EOL ;
            }
            */

        }
    }
}