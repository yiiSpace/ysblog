<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel my\blog\common\models\EntrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entry-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php // Html::a('Create Entry', ['create'], ['class' => 'btn btn-success']) ?>

    <?php $gridView = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
           // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'status',
            'statusTitle',
            'tagList',
             // 'slug',
            //'body:ntext',
            'tease:ntext',
            'created_at:date',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php
      echo \my\admin\widgets\AdminView::begin()->setTemplate('{index} {create} ')->setTabItem('index',
          [
              'label' => 'list',
              'content' => $gridView,
              'active' => true
          ]
      )->run();
    ?>
</div>
