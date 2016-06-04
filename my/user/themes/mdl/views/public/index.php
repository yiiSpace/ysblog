<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel \my\user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="user-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            /*
            'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
            },
            */
            'itemView' => '_view',
        ]) ?>
    </div>

<?php $this->beginBlock('sidebar') ?>

    <div class="search-wrapper card">

        <?= Html::beginForm([], 'get', [
            'class' => 'form-inline well',
            'role' => 'form',
        ]) ?>

        <!--<form class="form-inline well" method="get" role="form">-->
        <div class="input-group">
            <input class="form-control input-xs" name="q"
                   placeholder="Search..." value="<?= Yii::$app->request->get('q', '') ?>"/>
<span class="input-group-btn">
<button class="btn btn-default" type="submit">Go</button>
</span>
        </div>
        <!--</form>-->
        <?= Html::endForm() ?>

        <input id="search"><i class="material-icons">search</i>

        <div class="search-results"></div>
    </div>


<?php $this->endBlock() ?>