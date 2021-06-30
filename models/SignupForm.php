<?php


namespace app\models;


use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $fio;
    public $email;
    public $phone;
    public $password;
    public $passwordRepeat;
    public $code;

    public function rules()
    {
        return [
            [['fio', 'email', 'phone', 'password', 'passwordRepeat', 'code'], 'required'],
            ['email', 'unique', 'targetClass' => User::class],
            ['email', 'email'],
            ['phone', 'unique', 'targetClass' => User::class],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
            ['code', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'code' => 'Введите число с картинки'
        ];
    }
}