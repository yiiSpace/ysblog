<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/5
 * Time: 22:18
 */

namespace my\test\controllers\admin;


use yii\web\Controller;

/**
 * Class HelloController
 * @package my\test\controllers\admin
 */
class HelloController extends Controller
{
    public function actionIndex()
    {
        return __METHOD__ ;
    }
}