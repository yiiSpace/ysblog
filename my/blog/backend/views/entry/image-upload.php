<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\blog\common\models\Entry */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="entry-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'create-form',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>

    <?= $form->field($model, 'file')->fileInput([

    ])?>

    <div class="form-group">
        <?= Html::submitButton('Create' , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
