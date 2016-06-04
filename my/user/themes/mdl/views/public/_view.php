<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var my\user\models\User $model
 * // $model, $key, $index, $widget
 */

?>
<?php
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
]);
?>
<div class="col s12 m8">
    <div class="card card small">
        <div class="card-image">
            <img src="<?= \my\user\helpers\Defaults::getAvatarUrl() ?>" width="150" height="150">
            <span class="card-title">Card Title</span>
        </div>
        <div class="card-content">
            <p>
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
                I am a very simple card. I am good at containing small bits of information.
                I am convenient because I require little markup to use effectively.
            </p>

        </div>
        <div class="card-action">
            <?= Html::a($model->username,['/user/profile/index','id'=>$model->primaryKey]) ?>
            <a href="#">This is a link</a>
        </div>
    </div>
</div>
