<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class PromoCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_code';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Checks if the promo code is active.
     */
    public function isActive()
    {
        return $this->active == 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'discount', 'active'], 'required'],
            [['discount'], 'number'],
            [['active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'discount' => 'Discount',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

