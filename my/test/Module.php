<?php

namespace my\test;

use common\components\ActionsDetectable;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
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
        /**
         * echo Html::beginTag('ul');
         * <ul class="nav nav-pills">
         * <li role="presentation" class="active"><a href="#">Home</a></li>
         * <li role="presentation"><a href="#">Profile</a></li>
         * <li role="presentation"><a href="#">Messages</a></li>
         * </ul>
         *
         * foreach($actions  as $controllerActions){
         * echo  Html::tag('li',Html::a($controllerActions['label'],$controllerActions['url'])) ;
         * }
         * echo Html::endTag('ul');
         * */
    }
}
