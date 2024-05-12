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
            'category',
            'description',
            'ves',
            'kalorii',
        ];
    }
    public static function tableName()
    {
        return 'TOVAR';
    }

}