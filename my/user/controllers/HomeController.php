<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/3
 * Time: 19:28
 */

namespace my\user\controllers;


use yii\web\Controller;

class HomeController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index') ;
    }

}