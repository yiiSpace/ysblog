<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 10:25
 */
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
                <li class="tab col s3"><a href="#test1">Blog</a></li>
                <!--
                <li class="tab col s3"><a class="active" href="#test2">Test 2</a></li>
                <li class="tab col s3 disabled"><a href="#test3">Disabled Tab</a></li>
                -->
                <li class="tab col s3"><a href="#test4">收藏</a></li>
                <li class="tab col s3"><a href="#test4">评论</a></li>
                <li class="tab col s3"><a href="#test4">就是 Module Name</a></li>
            </ul>
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
