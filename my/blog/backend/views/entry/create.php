<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model my\blog\common\models\Entry */

$this->title = 'Create Entry';
$this->params['breadcrumbs'][] = ['label' => 'Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
