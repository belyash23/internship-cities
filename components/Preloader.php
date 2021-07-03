<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Preloader extends Widget
{
    public $title;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('preloader');
    }
}