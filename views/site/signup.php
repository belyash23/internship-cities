<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

?>

<?php
$form = ActiveForm::begin() ?>
<?php
echo $form->field($model, 'fio')->textInput();
echo $form->field($model, 'email')->input('email');
echo $form->field($model, 'phone')->textInput();
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'passwordRepeat')->passwordInput();
echo $form->field($model, 'code')->widget(Captcha::class);
?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php
ActiveForm::end(); ?>