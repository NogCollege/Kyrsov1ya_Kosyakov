<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Promotion extends ActiveRecord
{
    public static function tableName()
    {
        return 'promotions';
    }

    public function rules()
    {
        return [
            [['name', 'description', 'image_url', 'start_date', 'end_date', 'price', 'promotion_type', 'cat'], 'required'],
            [['description'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['price'], 'number'],
            [['name', 'image_url', 'promotion_type', 'cat'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image_url' => 'Image URL',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'price' => 'Price',
            'promotion_type' => 'Promotion Type',
            'cat' => 'Category', // Добавленное поле cat
        ];
    }
}
