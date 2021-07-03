<?php

use \yii\helpers\Html;

?>
<div class="review">
    <div class="title">
        <?php
        echo Html::encode($model->title); ?>
    </div>
    <div class="city">
        <?php
        if ($authorsReviews) {
            $city = $model->city->name ?: 'Все города';
            echo $city;
        }
            ?>
    </div>
    <div class="text">
        <?php
        echo Html::encode($model->text); ?>
    </div>

    <div class="author">
        <?php
        if(!$authorsReviews) {
            if (Yii::$app->user->isGuest) {
                echo 'Автор: ' . $model->user->fio;
            } else {
                echo Html::tag(
                    'p',
                    'Автор: ' . $model->user->fio,
                    ['class' => 'show-author-data text-primary', 'role' => 'button', 'data-author-id' => $model->user->id]
                );
            }
        }
        ?>
    </div>
</div>
<br>