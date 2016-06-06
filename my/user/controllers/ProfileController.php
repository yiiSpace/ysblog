<?php

namespace my\user\controllers;

use my\user\models\search\UserSearch;
use Yii ;

/**
 * Class ProfileController
 * @package my\user\controllers
 */
class ProfileController extends \yii\web\Controller
{
    /**
     * @return string
     */
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
