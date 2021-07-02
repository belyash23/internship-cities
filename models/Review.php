<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int|null $id_city
 * @property string $title
 * @property string $text
 * @property int $rating
 * @property string|null $img
 * @property int $id_author
 * @property string $date_create
 */
class Review extends \yii\db\ActiveRecord
{
    public $imgFile;
    public $cityName;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_city', 'rating', 'id_author'], 'integer'],
            [['title', 'text', 'rating'], 'required'],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            [['date_create'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['text', 'img'], 'string', 'max' => 255],
            ['imgFile', 'file', 'extensions' => 'png, jpg, jpeg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_city' => 'Id City',
            'title' => 'Название',
            'text' => 'Текст',
            'rating' => 'Рейтинг',
            'img' => 'Фото',
            'id_author' => 'Id Author',
            'date_create' => 'Date Create',
            'imgFile' => 'Фото'
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'id_city']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_author']);
    }

    public function uploadImg()
    {
        $extension = $this->imgFile->extension;
        $path = 'uploads';
        $name = self::generateFileName($path, $extension);
        $fullPath = '/' . $path . '/' . $name . '.' . $extension;
        if ($this->imgFile->saveAs('.' . $fullPath)) {
            $this->img = $fullPath;
            $this->imgFile = null;
            return true;
        } else {
            return false;
        }
    }

    public static function generateFileName($path, $extension)
    {
        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = './' . $path . '/' . $name . '.' . $extension;
        } while (file_exists($file));

        return $name;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->id_author === null) {
                $this->id_author = Yii::$app->user->id;
                $this->date_create = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
