<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_COMPLETED = 4;

    public $promocode;
    public $delivery_method;
    public $status;

    // Добавим поля для имени и почты заказчика
    public $customer_name;
    public $customer_email;

    // Добавим поле для хранения общей суммы заказа
    public $total;

    public function applyPromocode($promocode)
    {
        if ($promocode === 'nogcollege') {
            // Применить скидку 40%
            $this->total -= $this->total * 0.4;
        }
    }

    public function rules()
    {
        return [
            [['customer_name', 'customer_email', 'promocode', 'delivery_method'], 'required'],
            ['promocode', 'validatePromocode'],
            ['customer_email', 'email'],
        ];
    }

    public function validatePromocode($attribute, $params)
    {
        if ($this->$attribute !== 'nogcollege') {
            $this->addError($attribute, 'Неверный промокод');
        }
    }

    // Геттер и сеттер для поля total
    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($value)
    {
        $this->total = $value;
    }
}
