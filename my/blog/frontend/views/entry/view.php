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
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
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

    </div>

<?php $this->beginBlock('sidebar') ?>
    <ul class="well nav nav-list">
        <li><h4>Tags</h4></li>
        <?php foreach ($model->tags as $tag): ?>
            <li>
                <?= Html::a($tag->title, ['tag/detail', 'slug' => $tag->slug]) ?>
            </li>
        <?php endforeach ?>
    </ul>
    <p>Published <?= Yii::$app->formatter->asDatetime($model->created_at) ?></p>
<?php $this->endBlock() ?>