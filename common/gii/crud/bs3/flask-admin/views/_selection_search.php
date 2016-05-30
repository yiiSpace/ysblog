<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelId = Inflector::camel2id(StringHelper::basename($generator->modelClass),'_') ;

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => [''],
        'method' => 'get',
        'options'=>[
           'class'=>'form-search',
           'data-pjax' => true,
            'pjax-container' => '#pjax_<?= $modelId ?>_items',
        ],
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>

<?= "<?php " ?> \common\widgets\JsBlock::begin() ?>
<script>
    $(function(){
        // see https://github.com/defunkt/jquery-pjax
        // 代替yii1 时代的ajax提交搜索表单的做法
        $(document).on('submit', 'form[data-pjax]', function(event) {
            var pjaxContainer = $(this).attr('pjax-container');
            $.pjax.submit(event, pjaxContainer,{
                //  pushState:false,
                push:false
            });
            return false ;
        });
    })	;
</script>
<?= "<?php " ?>  \common\widgets\JsBlock::end() ?>
