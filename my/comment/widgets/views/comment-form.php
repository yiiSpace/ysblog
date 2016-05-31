<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 9:15
 */
?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">
    <h4> 提交个评论呗 亲爱的！^_^</h4>
    <?php $form = ActiveForm::begin([
            'method' => 'post',
           'action' => ['/api/comment/comment/create'],
    ]); ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'entity_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

