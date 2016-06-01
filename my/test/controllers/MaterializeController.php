<?php

namespace my\test\controllers;

/**
 * 如果嫌插件不够多 github上再搜搜 ，
 * 这个也可以弄进来：
 *  - https://github.com/makroxyz/yii2-materializecss
 *  - https://github.com/wiisoft/yii2-materialize
 *
 * Class MaterializeController
 * @package my\test\controllers
 */
class MaterializeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionComponents()
    {
        return $this->render('components');
    }

}
