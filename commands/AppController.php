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

/**
 * 程序管理入口
 *
 * Class AppController
 * @package app\commands
 */
class AppController extends Controller
{
    /**
     * 应用启动
     * ++ ------------------------------------------------------------------------ ++
     *                      **  此处可以作为入口 命令中心来执行一系列命令 **
     * ++ ------------------------------------------------------------------------ ++
     */
    public function actionSetup()
    {
        Console::output("App setup begin ");
        // $this->runAction('set-writable', ['interactive' => $this->interactive]);
        // TODO 此处可以运行不同的命令 这些命令可以通过bootstrap过程挂接进来 然后统一运行 这样各个模块的启动任务都可以完成了
        \Yii::$app->runAction('migrate/up', [
            'interactive' => $this->interactive,
            'migrationPath'=>'@my/blog/migrations',
        ]);
       // \Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);

        Console::output("App setup done !");
    }

    /**
     * 应用销毁 基本可以看做setup的逆操作
     */
    public function actionDestroy()
    {
        if(! $this->confirm('are you true you want destroy this app ?' )){
            $this->stdout('so dangerous ^_^ ! xia si bao bao le  ') ;
            return  ;
        }

        Console::output("App Destroy begin ");
        // $this->runAction('set-writable', ['interactive' => $this->interactive]);

        \Yii::$app->runAction('migrate/down', [
            'interactive' => $this->interactive,
            'migrationPath'=>'@my/blog/migrations',
        ]);
        // \Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);

        Console::output("App Destroy done !");
    }
}