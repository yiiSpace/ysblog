<?php

use yii\helpers\Url;

/**
 * @var string $subject
 * @var \my\user\models\User $user
 * @var \my\user\models\UserToken $userToken
 */
?>

<h3><?= $subject ?></h3>

<p><?= Url::toRoute(["/user/login-callback", "token" => $userToken->token], true); ?></p>