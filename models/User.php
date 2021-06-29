<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $date_create
 * @property string $password
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'email', 'phone', 'date_create', 'password'], 'required'],
            [['date_create'], 'safe'],
            [['fio', 'email', 'phone', 'password'], 'string', 'max' => 255],
            [['password'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'email' => 'Email',
            'phone' => 'Phone',
            'date_create' => 'Date Create',
            'password' => 'Password',
        ];
    }
}
