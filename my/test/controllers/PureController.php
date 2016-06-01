<?php

namespace my\test\controllers;

class PureController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
