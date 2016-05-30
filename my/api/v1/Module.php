<?php

namespace my\api\v1;

use Yii;

class Module extends \my\api\Module
{
    public $controllerNamespace = 'my\api\v1\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->user->identityClass = 'frontend\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
