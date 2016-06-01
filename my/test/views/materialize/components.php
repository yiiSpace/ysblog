<?php
/* @var $this yii\web\View */


\macgyer\yii2materializecss\assets\MaterializeAsset::register($this);
?>

<?= \macgyer\yii2materializecss\widgets\Button::widget() ?>

<?php \macgyer\yii2materializecss\widgets\Modal::begin() ?>

      hello   here

<?php \macgyer\yii2materializecss\widgets\Modal::end() ?>


<?php \macgyer\yii2materializecss\widgets\Chip::begin() ?>

hi as Tag
<i class="material-icons">close</i>

<?php \macgyer\yii2materializecss\widgets\Chip::end() ?>



 <div class="dropdown">
         <a href="#" data-toggle="dropdown" class="dropdown-toggle">Label <b class="caret"></b></a>
         <?php
             echo \macgyer\yii2materializecss\widgets\Dropdown::widget([
              'items' => [
                  ['label' => 'DropdownA', 'url' => '/'],
                  ['label' => 'DropdownB', 'url' => '#'],
              ],
          ]);
      ?>
 </div>
