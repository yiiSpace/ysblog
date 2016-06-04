<?php

namespace my\user\controllers;

use my\user\models\search\UserSearch;
use Yii ;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();

        $request = Yii::$app->request;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
