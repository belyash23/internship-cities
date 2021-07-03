<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php
    Pjax::begin();
    if (Yii::$app->session->hasFlash('success')) {
        echo Html::tag('p', Yii::$app->session->getFlash('success'), ['class' => 'alert-success alert fade in']);
    }

    $form = ActiveForm::begin(
        [
            'options' => [
                'data-pjax' => true
            ]
        ]
    ); ?>

    <div class="form-group">
        <label for="review-cityname">Город</label>
        <?php
        echo AutoComplete::widget(
            [
                'model' => $model,
                'attribute' => 'cityName',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'source' => new JsExpression(
                        "function(request, response) {
                                        $.ajax('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'Authorization': 'Token " . Yii::$app->params['dadata_token'] . "'
                                            },
                                            data: JSON.stringify({
                                                query: request.term,
                                                locations: [
                                                    {
                                                        country: 'Россия'
                                                    }
                                                ]
                                            })
                                        }).done(data => {
                                            const cities = data.suggestions.map(suggestion => suggestion.data.city);
                                            const uniqueCities = [...new Set(cities)];
                                            response(uniqueCities.filter(Boolean));
                                        })
                                    }"
                    )
                ],
            ]
        );
        ?>
    </div>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'imgFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end();
    Pjax::end(); ?>

</div>
