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

            <?php
            /**
             *  modify the entry detail template to hide the Edit and Delete links from
             * all users except the entry's author.
             */
            if ($model->user_id == Yii::$app->user->id): ?>
        <h4>Actions</h4>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif ?>

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

        <hr/>
        <?php \my\comment\assets\CommentAsset::register($this) ?>
        <?= \my\comment\widgets\CommentForm::widget([
            'entity_id' => $model->primaryKey,
        ]); ?>
        <?php \common\widgets\JsBlock::begin() ?>
        <script>
            $(function () {
                Comments.setCommentListUrl('<?= \yii\helpers\Url::to(['/api/comment/comment']) ?>');
                Comments.load(<?= $model->primaryKey ?>);
                Comments.bindHandler();
            });
        </script>
        <?php \common\widgets\JsBlock::end() ?>
    </div>

<?php $this->beginBlock('sidebar') ?>
    <ul class="well nav nav-list">
        <li><h4>Tags</h4></li>
        <?php foreach ($model->tags as $tag): ?>
            <li>
                <?= Html::a($tag->title, ['tag/detail',
                        // 'slug' => ( $tag->slug ? $tag->title : $tag->slug
                        'slug' => $tag->title]
                ) ?>
            </li>
        <?php endforeach ?>
    </ul>
    <p>Published <?= Yii::$app->formatter->asDatetime($model->created_at) ?></p>
<?php $this->endBlock() ?>