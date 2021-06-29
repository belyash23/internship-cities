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
            [['title', 'text', 'rating', 'id_author', 'date_create'], 'required'],
            [['date_create'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['text', 'img'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'text' => 'Text',
            'rating' => 'Rating',
            'img' => 'Img',
            'id_author' => 'Id Author',
            'date_create' => 'Date Create',
        ];
    }
}
