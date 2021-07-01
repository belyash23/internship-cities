<?php

use yii\helpers\Html;

?>
<h5><?= $title ?></h5>
<ul>
    <li><?php
        echo Html::a('Создать новый отзыв', array('review/create')); ?></li>
    <li><?php
        echo Html::a('Управление отзывами', array('review/admin')); ?></li>
    <li><?php
        echo Html::a('Выход', array('site/logout'), ['data' => ['method' => 'post']]); ?></li>
</ul>