<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>

<ul class="well nav nav-stacked">
    <li>
<!--        注意这里当前控制器是不存在的 所以url的生成要用绝对路由 不能适用男相对路由 （前面必须带斜杠）-->
        <?= Html::a(Html::encode('管理'),['/admin/blog/entry/create']) ?>
    </li>
</ul>
