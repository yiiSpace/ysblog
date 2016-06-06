<?php

namespace my\test\backend;

use common\components\ActionsDetectable;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * test module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'my\test\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $app = \Yii::$app;
        // 技巧来自yii2-debug 模块
        // $app->getView()->on(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        $app->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderToolbar']);
    }

    /**
     * Renders mini-toolbar at the end of page body.
     *
     * @param \yii\base\Event $event
     */
    public function renderToolbar($event)
    {
        if (\Yii::$app->getRequest()->getIsAjax()) {
            return;
        }
        $actions = ActionsDetectable::detectActions4Module($this);

        echo Nav::widget([
            'items' => $actions,
            'options' => ['class' => 'nav-pills'], // set this to nav-tab to get tab-styled navigation
        ]);
        // ! 可以用正则替换 插入内容
    }
}
