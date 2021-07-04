<?php


namespace app\models;


use yii\base\Model;

class ChooseCity extends Model
{
    public $city;
    public function rules()
    {
        return [
            ['city', 'required', 'message' => 'Выберите город']
        ];
    }
    public function attributeLabels()
    {
        return [
            'city' => ''
        ];
    }
}