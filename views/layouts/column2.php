<?php
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent(__DIR__.'/_main.php')
?>


    <div class="row">
        <div class="col-md-9">
            <h1>{% block content_title %}{% endblock %}</h1>
            <?= $content ?>
        </div>
        <div class="col-md-3">
            {% block sidebar %}
            <ul class="well nav nav-stacked">
                <li><a href="#">Sidebar item</a></li>
            </ul>
            {% endblock %}
            <?= $this->blocks['sidebar'] ?>
        </div>
    </div>

<?php $this->endContent() ?>