<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var my\user\models\User $model
 * // $model, $key, $index, $widget
 */

?>
<?=
/*
  \cebe\gravatar\Gravatar::widget([
      'email' => $model->email,
      'size' => 128,
      'defaultImage' => 'monsterid',
  //  'secure' => false, // will be autodetected
      'rating' => 'r',
      'options'=>[
          'alt'=>'Gravatar image',
          'title'=>'Gravatar image',
      ]
])
*/
\common\widgets\Gravatar::widget([
      'email'=>'malyshev.php@gmail.com',
      'size'=>80,
      'defaultImage'=>'http://www.amsn-project.net/images/download-linux.png',
      'secure'=>false,
      'rating'=>'r',
      'emailHashed'=>false,
      'htmlOptions'=>array(
          'alt'=>'Gravatar image',
          'title'=>'Gravatar image',
      )
])

?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'role_id',
        'status',
        'email:email',
        'username',
        'profile.full_name',
        'password',
        'auth_key',
        'access_token',
        'logged_in_ip',
        'logged_in_at',
        'created_ip',
        'created_at',
        'updated_at',
    ],
]) ?>
<p>
<hr style="color: #00a65a;border: #6cabff double 2px">
</p>
