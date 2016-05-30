<?php

namespace my\api;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        Yii::$app->user->identityClass = 'frontend\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;

        Yii::$app->request->parsers['application/json'] =  'yii\web\JsonParser';
    }
}
