<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class UserMenu extends Widget
{
    public $title;

    public function init()
    {
        if (Yii::$app->user->isGuest) {
            $this->title = 'Гость';
        } else {
            $this->title = Html::encode(Yii::$app->user->identity->fio);
        }
        parent::init();
    }

    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render(
                'userMenuGuest',
                [
                    'title' => $this->title
                ]
            );
        } else {
            return $this->render(
                'userMenu',
                [
                    'title' => $this->title
                ]
            );
        }
    }
}