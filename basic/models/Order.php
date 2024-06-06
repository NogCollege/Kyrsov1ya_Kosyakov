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

    public $delivery_method;
    public $customer_name;
    public $customer_email;
    public $address;
    public $total;
    public $promocode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * Applies a promo code to the order.
     * @param string $promocode
     */
    public function applyPromocode($promocode)
    {
        $promoCodeModel = PromoCode::findOne(['code' => $promocode]);
        if ($promoCodeModel) {
            if ($promoCodeModel->isActive()) {
                $this->total -= $this->total * ($promoCodeModel->discount / 100);
            } else {
                $this->addError('promocode', 'Промокод не активен');
            }
        } else {
            $this->addError('promocode', 'Неверный промокод');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_name', 'customer_email', 'address', 'delivery_method'], 'required'],
            [['customer_email'], 'email'],
            [['customer_name', 'address', 'promocode'], 'string', 'max' => 255],
            ['promocode', 'validatePromocode'],
        ];
    }

    /**
     * Validates the promo code.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePromocode($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            $promoCodeModel = PromoCode::findOne(['code' => $this->$attribute]);
            if (!$promoCodeModel) {
                $this->addError($attribute, 'Неверный промокод');
            } elseif (!$promoCodeModel->isActive()) {
                $this->addError($attribute, 'Промокод не активен');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_name' => 'Имя заказчика',
            'customer_email' => 'Электронная почта',
            'address' => 'Адрес',
            'promocode' => 'Промокод',
            'delivery_method' => 'Тип доставки',
            'total' => 'Общая сумма',
        ];
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($value)
    {
        $this->total = $value;
    }
}


