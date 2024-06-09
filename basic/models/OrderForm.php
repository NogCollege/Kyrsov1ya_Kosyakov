<?php

namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
    public $customer_name;
    public $address;
    public $promocode;
    public $delivery_method;
    public $customer_email;

    public function rules()
    {
        return [
            [['customer_name', 'address', 'delivery_method', 'customer_email'], 'required'],
            [['customer_name', 'address', 'promocode', 'customer_email'], 'string', 'max' => 255],
            [['delivery_method'], 'in', 'range' => ['address', 'pickup']],
            [['customer_email'], 'email'],
        ];
    }
}


