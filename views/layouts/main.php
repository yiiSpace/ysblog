<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

if (isset($this->blocks['sidebar'])) {
    $this->beginContent(__DIR__ . '/column2.php');
} else {
    $this->beginContent(__DIR__ . '/_main.php');
}
?>
<?php echo $content ?>

<?php $this->endContent() ?>