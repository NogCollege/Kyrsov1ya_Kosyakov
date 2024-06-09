<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['user_id', 'customer_name', 'customer_email', 'address', 'delivery_method', 'phone_number', ], 'required'],
            [['user_id'], 'integer'],
            [['customer_name', 'customer_email', 'address', 'promocode', 'delivery_method', 'phone_number'], 'string', 'max' => 255],
            [['delivery_method'], 'in', 'range' => ['address', 'pickup']],
            [['customer_email'], 'email'],
            ['promocode', 'validatePromocode'],
        ];
    }


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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'customer_name' => 'Customer Name',
            'customer_email' => 'Customer Email',
            'address' => 'Address',
            'promocode' => 'Promocode',
            'delivery_method' => 'Delivery Method',
            'phone_number' => 'Phone Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Проверяем, аутентифицирован ли пользователь
                if (Yii::$app->user->isGuest) {
                    throw new \yii\base\InvalidConfigException('Для оформления заказа необходимо войти в аккаунт.');
                }
                $this->user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

}

    /**
     * Sets the total amount of the order.
     * @param float $value
     */


    /**
     * @inheritdoc
     */
