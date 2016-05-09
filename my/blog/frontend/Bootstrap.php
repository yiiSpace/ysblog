<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/9
 * Time: 16:10
 */

namespace my\blog\frontend;


use yii\base\BootstrapInterface;
use yii\web\Application;

class Bootstrap implements  BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if($app instanceof Application){
            // 修改默认路由 程序主页变为本模块的入口列表
            $app->defaultRoute = '/blog/entry' ;
            $app->getUrlManager()->addRules([
               ''=> '/blog/entry',
              //  $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>' => $this->id . '/<controller>/<action>',
            ], false);
        }

    }

}