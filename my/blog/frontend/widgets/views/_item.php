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
    <h5><?= $model->title ?></h5>

    <p><?= $model->getTease() ?></p>

    <div class="article_manage right-align">
        <span class="link_postdate">2016-05-29 21:14</span>


                                <span title="阅读次数" class="link_view"><a title="阅读次数"
                                                                        href="/yanghua_kobe/article/details/51533957">阅读</a>(8853)</span>
                                <span title="评论次数" class="link_comments"><a
                                        onclick="_gaq.push(['_trackEvent','function', 'onclick', 'blog_articles_pinglun'])"
                                        title="评论次数"
                                        href="/yanghua_kobe/article/details/51533957#comments">评论</a>(0)</span>

    </div>
</div>