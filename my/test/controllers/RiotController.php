<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/1
 * Time: 15:53
 */

namespace my\test\controllers;


use yii\web\Controller;

class RiotController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}