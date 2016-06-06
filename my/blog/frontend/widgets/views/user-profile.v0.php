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

                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    /*
                    'itemView' => function ($model, $key, $index, $widget) {
                        return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                    },
                    */
                    'itemView'=>'_item' ,
                ]) ?>

                <?php for ($i = 0; $i < 15; $i++): ?>
    <div class="divider"></div>
    <div class="section">
        <h5>Section 1</h5>

        <p>Stuff</p>

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
<?php endfor; ?>

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