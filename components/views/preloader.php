<?php

use yii\helpers\Html;

?>

<?= Html::img('https://msn.michelin.ru/images/spinner.gif', ['width' => '50px', 'hidden' => 'true', 'class' => 'preloader']) ?>

<?php
$this->registerJs("
        if(!window.registered) {
            $(document).on('pjax:send', () => {
                window.registered = true;
                $('.preloader').show();
            });
            $(document).on('pjax:complete', () => {
                $('.preloader').hide();
            });
        }
    ");
?>
