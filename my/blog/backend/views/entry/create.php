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

    <?= Html::a('上传图片',['image-upload']) ?>
    <?php $form =  $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php
    echo \my\admin\widgets\AdminView::begin()
        ->setTemplate('{index} {create} ')
        ->setTabItem('create',
        [
            'label' => 'Create',
            'content' => $form,
            'active' => true
        ]
    )->run();
    ?>

</div>
