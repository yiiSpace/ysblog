<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/8
 * Time: 23:05
 */

namespace app\commands;


use yii\console\Controller;
use yii\helpers\Console;

class AppController extends Controller
{
    public function actionSetup()
    {
        Console::output("App setup begin ");
        // $this->runAction('set-writable', ['interactive' => $this->interactive]);

       // \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
       // \Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);

        Console::output("App setup done !");
    }
}