
<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel my\blog\common\models\EntrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entries';
$this->params['breadcrumbs'][] = $this->title;
// TODO 临时看下分页效果
$dataProvider->pagination->setPageSize(1) ;
?>
<div class="entry-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        },
    ]) ?>
</div>

<?php $this->beginBlock('sidebar') ?>

<form class="form-inline well" method="get" role="form">
    <div class="input-group">
        <input class="form-control input-xs" name="q"
               placeholder="Search..." value="<?= Yii::$app->request->get('q','') ?>" />
<span class="input-group-btn">
<button class="btn btn-default" type="submit">Go</button>
</span>
    </div>
</form>

<?php $this->endBlock() ?>