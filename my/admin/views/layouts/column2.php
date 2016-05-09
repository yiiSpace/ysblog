<?php
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent(  '@app/views/layouts/_main.php')
?>
<?= \yii\bootstrap\Nav::widget([

    'items' => [
        [
            'label' => 'Home',
            'url' => ['site/index'],
            'linkOptions' => [],
        ],

        [
            'label' => '模块',
            'items' =>  // \playground\core\frontend\components\NavManager::getModuleNavItems(),
                [
                    ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">博客</li>',
                    ['label' => '博客管理', 'url' =>['/admin/blog/entry']],
                ]
        ],

    ],
    'options' => ['class' => 'nav-pills'], // set this to nav-tab to get tab-styled navigation
]) ?>

    <div class="row">
        <div class="col-md-9">
            <h1>{% block content_title %}{% endblock %}</h1>
            <?= $content ?>
        </div>
        <div class="col-md-3">
            <!--            The block tags are used to indicate overrideable areas of the page.-->
            {% block sidebar %}
            <!--            <ul class="well nav nav-stacked">    <li><a href="#">Sidebar item</a></li>             </ul>-->
            {% endblock %}
            <?= $this->blocks['sidebar'] ?>
        </div>
    </div>

<?php $this->endContent() ?>