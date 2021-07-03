<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Управление отзывами';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1>Manage Posts</h1>

<?php
Pjax::begin();
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title'
            ],
            [
                'attribute' => 'text',
            ],
            [
                'attribute' => 'rating',
            ],
            [
                'attribute' => 'city.name',
                'label' => 'Город',
                'value' => function ($model) {
                    return $model->city->name ?: 'Все города';
                }
            ],
            [
                'attribute' => 'img',
                'format' => 'html',
                'value' => function($model) {
                    if($model->img) {
                        return Html::img('@web/'.$model->img.'', ['class' => 'review-img']);
                    }
                    else {
                        return '';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return \yii\helpers\Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-pjax' => 'w0',
                                'data-method' => 'post'
                            ]
                        );
                    }
                ]
            ]
        ],
    ]
);
Pjax::end();
?>