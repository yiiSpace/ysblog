<?php

namespace my\blog\backend;

/**
 * blog module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'my\blog\backend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->initSidebar() ;

    }

    /**
     * 添加导航
     */
    public function initSidebar()
    {
        $view  =  \Yii::$app->view ;
        $view->beginBlock('sidebar');

        echo $view->render('@my/blog/backend/views/_sidebar/sidebar');

        $view->endBlock() ;
    }
}
