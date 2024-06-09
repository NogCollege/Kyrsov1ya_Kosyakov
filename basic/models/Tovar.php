<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tovar extends ActiveRecord
{
    public static function tableName()
    {
        return 'tovar';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'description', 'image_url', 'cat', 'ves'], 'required'],
            [['ves','price'], 'number'],
            [['name'], 'string'],
            [['description', 'image_url','cat'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'price' => 'Цена',
            'description' => 'Минимальное Описание',
            'image_url' => 'URL изображения',
            'cat' => 'Категория',
            'ves' => 'Вес',
        ];
    }

}
