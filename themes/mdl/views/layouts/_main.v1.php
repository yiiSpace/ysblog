<?php

/* @var $this \yii\web\View */
/* @var $content string */

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Nav;
use macgyer\yii2materializecss\widgets\NavBar;
use macgyer\yii2materializecss\widgets\Breadcrumbs;
use macgyer\yii2materializecss\widgets\Alert;

use app\assets\AppAsset;

// 禁用bootstrap 的css 注意位置 要发生在 注册asset之前
\Yii::$container->set( /*'yii\bootstrap\BootstrapAsset'*/ \yii\bootstrap\BootstrapAsset::className(), [
    'css'=>[],
]);

// AppAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style type="text/css">

    </style>

</head>
<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'fixed' => true,
        'wrapperOptions' => [
            'class' => 'container'
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],

        ['label' => 'members', 'url' => ['/user/public/index']],
        ['label' => 'User', 'url' => ['/user']],
        ['label' => 'ADMIN', 'url' => ['/admin']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/user/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
    } else {
        // $menuItems[]  =  ['label' => '用户中心', 'url' => ['/user/center']];

        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-flat']
            )
            . Html::endForm()
            . '</li>';

        // 此处如果使用插件机制 那么用事件即可 因为 layout上面的页面渲染 比较靠后
        $userName = Yii::$app->user->identity->username ;
        // 用户中心的 url 别名候选：  user/hub  user/dashboard  user/home user/center
        $userCenterUrl = \yii\helpers\Url::to(['/user/home']) ;
        $ddl = <<<DDL
     <li>
     <a data-activates="dropdown1" href="#!" class="dropdown-button">
          {$userName}<i class="material-icons right">arrow_drop_down</i>
     </a>
     <ul class="dropdown-content" id="dropdown1"
         style="width: 143px; position: absolute; top: 0px; left: 638.483px; opacity: 1; display: none;">
          <li><a href="{$userCenterUrl}">用户中心</a></li>
          <li><a href="#!">two</a></li>
          <li class="divider"></li>
          <li><a href="#!">three</a></li>
        </ul>
     </li>
DDL;
         $menuItems[] = $ddl ;

    }

    echo Nav::widget([
        'options' => ['class' => 'right'],
        'items' => $menuItems,
    ]);
   ?>
     <?php
    NavBar::end();
    ?>
</header>


<main class="content">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <!--    <div class="container">-->
    <div class="container">

        <?= Alert::widget() ?>

        <?= $content ?>
    </div>
</main>

<footer class="footer page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>

                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer
                    content.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">





        </div>
        <div class ="row">
            <div class="left">
                基于：<?= Html::a('mdl','http://materializecss.com') ?>
            </div>

            &copy; My Company <?= date('Y') ?>
            <?= Yii::powered() ?>


        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
