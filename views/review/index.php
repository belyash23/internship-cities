<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget(
        [
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_review',
            'viewParams' => ['authorsReviews' => $authorsReviews]
        ]
    ) ?>

    <?php
    Modal::begin(
        [
            'header' => '<h2 class="text-center modal-header"></h2>',
            'toggleButton' => [
                'label' => 'click me',
                'id' => 'open-modal',
                'hidden' => 'true'
            ],
            'options' => [
                'id' => 'choose-city-modal'
            ],
            'closeButton' => ['id' => 'close-modal']
        ]
    );
    echo Html::tag('p', '', ['class' => 'modal-email']);
    echo Html::tag('p', '', ['class' => 'modal-phone']);
    echo Html::a('Все отзывы автора', ['review/index', 'id' => 123], ['class' => 'modal-link']);
    Modal::end();
    $this->registerJs("
        $('.show-author-data').click(function() {
            const id = $(this).data().authorId;
            $.ajax('get-author-data', {
                type: 'get',
                dataType: 'json',
                data: {
                    id: id
                }
            }).done(response => {
                $('.modal-email').text('Email: ' + response.email);
                $('.modal-phone').text('Телефон: ' + response.phone);
                $('.modal-header').text(response.fio);
                $('#open-modal').click();
                const href = $('.modal-link').attr('href');
                hrefArr = href.split('?');
                $('.modal-link').attr('href', hrefArr[0] + '?' + 'id=' + id);
                
            })
        });
    ");
    ?>


</div>
