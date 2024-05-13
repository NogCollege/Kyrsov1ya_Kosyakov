<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tovar extends ActiveRecord
{
    public function attributes()
    {
        return [
            'id',
            'name',
            'price',
            'image_url',
            'cat',
            'description',
            'ves',
            'kal',
        ];
    }
    public static function tableName()
    {
        return 'TOVAR';
    }

}
