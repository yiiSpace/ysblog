<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model my\blog\common\models\Entry */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entry-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php $detailView = DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            'body:ntext',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>
    <?php
    echo \my\admin\widgets\AdminView::begin()
        ->setTemplate('{index} {create} {view}  {update} {delete} {search}')
        ->setModel($model)
       // ->setTabItem('search',Html::textInput('q'))
        ->setTabItem('view',
        [
            'label' => 'View',
            'content' => $detailView,
            'active' => true,

        ]
    )->run();
    ?>
</div>
