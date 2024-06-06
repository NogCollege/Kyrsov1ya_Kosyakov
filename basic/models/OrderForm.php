<?php

use yii\base\Model;

class OrderForm extends Model
{
    public $customer_name;
    public $address;
    public $promo_code;
    public $delivery;
    public $email;

    public function rules()
    {
        return [
            [['customer_name', 'address', 'delivery', 'email'], 'required'],
            [['customer_name', 'address', 'promo_code', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['promo_code', 'validatePromoCode'],
        ];
    }

    public function validatePromoCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $promoCode = PromoCode::findOne(['code' => $this->promo_code]);
            if (!$promoCode) {
                $this->addError($attribute, 'Недопустимый промокод');
            }
        }
    }
}

