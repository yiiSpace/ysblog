<?php

namespace my\blog\frontend\controllers;

class EntryController extends \yii\web\Controller
{
    public function actionDetail()
    {
        return $this->render('detail');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
