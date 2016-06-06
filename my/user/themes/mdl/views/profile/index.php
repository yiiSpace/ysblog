<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use my\user\helpers\Timezone;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var my\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Home');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-home-index">


    <?php
    $nav = Yii::$app->request->get('nav','blog') ;
    $profileHub =  new \my\user\components\ProfileHub() ;
    // 手动注册
    $profileHub->profileViews['comment'] = \my\comment\widgets\profile\UserProfile::className() ;
           echo $profileHub->process($nav) ;
    ?>

    <!--    <h1>--><? //= Html::encode($this->title) ?><!--</h1>-->


</div>