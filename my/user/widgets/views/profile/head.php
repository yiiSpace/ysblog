<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 10:25
 */

$nav = Yii::$app->request->get('nav', 'blog');
$printActiveClass = function ($route) use ($nav) {
    return (\yii\helpers\StringHelper::startsWith($nav,$route)) ? 'active': '' ;
};
?>

<div class=" card-panel purple lighten-5">
    <div class="row">
        <div class="col s8">

            <div class="row valign-wrapper">
                <div class="col s3">
                    <img src="<?= \my\user\helpers\Defaults::getAvatarUrl() ?>" alt=""
                         class="circle responsive-img">
                    <!-- notice the "circle" class -->
                </div>
                <div class="col s7">
              <span class="black-text">
                This is a square image. Add the "circle" class to it to make it appear circular.
                  如果写了很多呢 会排列在啥地方
              </span>
                </div>
            </div>

        </div>
        <div class="col s4 right-align">
            action 区 上下文相关的 比如登陆时（自己呢 还是其他人） 跟未登录时
        </div>
    </div>

    <div class="divider"></div>


    <div class="row">
        <div class="col s12">
            <ul class="tabs purple lighten-5">
                <li class="tab col s3">
                    <a href="<?= \yii\helpers\Url::to(['', 'nav' => 'blog']) ?>" class="<?= $printActiveClass('blog') ?>">Blog</a>
                </li>
                <!--
                <li class="tab col s3"><a class="active" href="#test2">Test 2</a></li>
                <li class="tab col s3 disabled"><a href="#test3">Disabled Tab</a></li>
                -->
                <li class="tab col s3"><a href="#test4">收藏</a></li>
                <li class="tab col s3">
                    <a href="<?= \yii\helpers\Url::to(['', 'nav' => 'comment']) ?>" class="<?= $printActiveClass('comment') ?>">评论</a>
                </li>
                <li class="tab col s3"><a href="#test4">就是 Module Name</a></li>
            </ul>
            <?php \common\widgets\JsBlock::begin() ?>
            <script>
                $(function () {
                    // 原来的tab 把跳转功能给屏蔽了？
                    $(document).on('click', 'ul.tabs a', function (e) {
                        // alert($(this).attr('href'))  ;
                        window.location.href = $(this).attr('href');
                    });

                });
            </script>
            <?php \common\widgets\JsBlock::end() ?>
        </div>
    </div>

    <!--
    <div class="card  ">
        <div class="card-action">
            <a href="#">This is a link</a>
            <a href="#">This is a link</a>
        </div>
    </div>
    -->
    <!--
    <div class="row">
        <div class="col s3">
            <div class="section">
                This div is 3-columns wide
            </div>
        </div>
    </div>
    -->
</div>


