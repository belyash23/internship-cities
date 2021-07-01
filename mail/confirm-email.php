<?php

use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(
    [
        'site/confirm-email',
        'email' => $user->email,
        'token' => $user->confirmation_token
    ]
);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->fio) ?>,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>