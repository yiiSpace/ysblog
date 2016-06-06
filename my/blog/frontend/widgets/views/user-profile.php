<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 10:18
 */

echo $profileHead ; ?>


<div class="row">


    <div class="col s9 m8">

        <div class="card-panel">
                <span class="blue-text text-darken-2">
此区域可以放置 当前模块内的 可用导航
</span>
        </div>

        <div class="card green-wine-trans border-side-white no-margin">
            <div class="card-content">
                <h5 class="">
最新博文
                </h5>
                <hr>

                <hr style="border-top: 1px dashed rgb(238, 238, 238);">

                <?=
                 // $dataProvider->pagination->setPageSize(15) ;

                \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    /*
                    'itemView' => function ($model, $key, $index, $widget) {
                        return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                    },
                    */
                    'itemView'=>'_item' ,
                ]) ?>


</div>
</div>


</div>

<div class="col s3 m4">

    <div class="card-panel">
        <table>
            <!--
            <thead>
            <tr>
                <th data-field="id">Name</th>
                <th data-field="name">Item Name</th>
                <th data-field="price">Item Price</th>
            </tr>
            </thead>
            -->

            <tbody>

            <tr>
                <td>博文：<span class=" ">1</span></td>
                <td>收藏：<span class="">1</span></td>
                <td>评论：<span class="">1</span></td>
            </tr>

            </tbody>
        </table>
    </div>

    <div class="card blue-grey darken-1">
        <div class="card-content white-text">
            <span class="card-title">Card Title</span>

            <p>I am a very simple card. I am good at containing small bits of information.
                I am convenient because I require little markup to use effectively.</p>
        </div>
        <div class="card-action">
            <a href="#">This is a link</a>
            <a href="#">This is a link</a>

        </div>
    </div>

    <div class="card">
        <div class="card-image">
            <img src="<?= \my\user\helpers\Defaults::getAvatarUrl() ?>">
            <span class="card-title">Card Title</span>
        </div>
        <div class="card-content">
            <p>I am a very simple card. I am good at containing small bits of information.
                I am convenient because I require little markup to use effectively.</p>
        </div>
        <div class="card-action">
            <a href="#">This is a link</a>
        </div>
    </div>

    <div class="collection">
        <a href="#!" class="collection-item">Alan<span class="badge">1</span></a>
        <a href="#!" class="collection-item">Alan<span class="new badge">4</span></a>
        <a href="#!" class="collection-item">Alan</a>
        <a href="#!" class="collection-item">Alan<span class="badge">14</span></a>
    </div>

    <div class="card-panel teal">
          <span class="white-text">I am a very simple card. I am good at containing small bits of information.
          I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
          </span>
    </div>

</div>

</div>