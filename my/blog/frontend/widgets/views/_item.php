<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model my\blog\common\models\Entry */
/**
 * $model, $key, $index, $widget
 */

?>
<div class="divider"></div>
<div class="section">
    <h5><?= Html::a( Html::encode($model->title),['/blog/entry/view', 'id' => $model->primaryKey],['target'=>'_blank'] ) ?></h5>

    <p><?= $model->getTease() ?></p>

    <div class="article_manage right-align">
        <span class="link_postdate"><?= Yii::$app->formatter->asDatetime( $model->created_at ) ;?></span>


                                <span title="阅读次数" class="link_view">
                                    <a title="阅读次数"
                                       href="<?= \yii\helpers\Url::to(['/blog/entry/view', 'id' => $model->primaryKey]) ?>">阅读</a>(8853)</span>
                                <span title="评论次数" class="link_comments">
                                    <a onclick=""
                                       title="评论次数"
                                       href="/yanghua_kobe/article/details/51533957#comments">
                                        评论</a>(0
                                    )</span>

    </div>
</div>