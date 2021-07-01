<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $date_create
 * @property string $password
 * @property string $confirmation_token
 * @property string $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_WAIT = 0;
    const STATUS_CONFIRMED = 1;

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
            [['fio', 'email', 'phone', 'password'], 'required'],
            ['confirmation_token', 'safe'],
            [['fio', 'email', 'phone', 'password', 'confirmation_token'], 'string', 'max' => 255],
            [['password'], 'unique'],
            ['status', 'in', 'range' => [self::STATUS_WAIT, self::STATUS_CONFIRMED]],
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

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->status === null) {
                $this->status = self::STATUS_WAIT;
                $this->date_create = time();
            }

            return true;
        } else {
            return false;
        }
    }
}
