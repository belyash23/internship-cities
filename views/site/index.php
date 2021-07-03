<?php

/* @var $this yii\web\View */

use app\models\City;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Выберите город</h1>
    </div>

    <div class="body-content">

        <?php
        $form = ActiveForm::begin(
            [
                'action' => ['site/choose-city'],
                'options' => [
                    'class' => 'col-md-4 col-md-offset-4'
                ]
            ]
        ); ?>
        <div class="form-group">
            <?php
            $cities = array_values(City::find()->select('name')->asArray()->orderBy('name')->all());
            $source = [];
            foreach ($cities as $city) {
                $source [] = $city['name'];
            }
            echo AutoComplete::widget(
                [
                    'model' => $model,
                    'attribute' => 'city',
                    'options' => [
                        'id' => 'choosecity-city',
                        'class' => 'form-control',
                        'required' => 'true'
                    ],
                    'clientOptions' => [
                        'source' => $source
                    ],
                ]
            );
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Выбрать', ['class' => 'btn btn-success col-md-4 col-md-offset-4']) ?>
        </div>
        <?php
        ActiveForm::end(); ?>

    </div>
    <?php
    if (isset($model->city)) {
        Modal::begin(
            [
                'header' => '<h2 class="text-center">' . $model->city . ' ваш город?</h2>',
                'toggleButton' => [
                    'label' => 'click me',
                    'id' => 'open-modal',
                    'hidden' => 'true'
                ],
                'options' => [
                    'id' => 'choose-city-modal'
                ],
                'closeButton' => ['id' => 'close-modal', 'hidden' => 'true']
            ]
        );
        echo Html::a('Да', ['site/choose-city', 'city' => $model->city], ['class' => 'btn btn-primary']);
        echo Html::button('Нет', ['id' => 'modal-no', 'class' => 'btn btn-primary pull-right']);
        Modal::end();
        $this->registerJs("
            $('#open-modal').click();
            $('#modal-no').click(() => $('#close-modal').click());
        ");
    }
    ?>
</div>
