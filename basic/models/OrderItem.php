<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_item';
    }

    public function rules()
    {
        return [
            [['order_id', 'tovar_id', 'quantity', 'price'], 'required'],
            [['order_id', 'tovar_id', 'quantity'], 'integer'],
            ['price', 'number'],
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getTovar()
    {
        return $this->hasOne(Tovar::class, ['id' => 'tovar_id']);
    }
}
