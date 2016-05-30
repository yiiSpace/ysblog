<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model my\blog\common\models\Entry */

$this->title = 'Update Entry: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entry-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php
    echo \my\admin\widgets\AdminView::begin()
        ->setTemplate('{index} {create} {update} {view} {delete} ')
        ->setModel($model)
        ->setTabItem('update',
            [
                'label' => 'Update',
                'content' => $form,
                'active' => true
            ]
        )->run();
    ?>
</div>
