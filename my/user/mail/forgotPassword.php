<?php

use yii\helpers\Url;

/**
 * @var string $subject
 * @var \my\user\models\User $user
 * @var \my\user\models\UserToken $userToken
 */
?>

<h3><?= $subject ?></h3>

<p><?= Yii::t("user", "Please use this link to reset your password:") ?></p>

<p><?= Url::toRoute(["/user/reset", "token" => $userToken->token], true); ?></p>
