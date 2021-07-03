<?php

use yii\helpers\Html;

?>
<h5><?= $title ?></h5>
<ul>
    <li><?php
        echo Html::a('Регистрация', array('site/signup')); ?></li>
    <li><?php
        echo Html::a('Вход', array('site/login')); ?></li>
    <li><?php
        echo Html::a('Отзывы', array('review/index')); ?></li>
</ul>