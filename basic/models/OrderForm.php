<?php

namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
    public $promo_code;
    public $delivery;
    public $email;

    public function rules()
    {
        return [
            [['promo_code', 'delivery', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'promo_code' => 'Промокод',
            'delivery' => 'Доставка',
            'email' => 'Email',
        ];
    }
}
