<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promotion;

class PromotionSearch extends Promotion
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description', 'image_url', 'start_date', 'end_date', 'promotion_type', 'cat'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Promotion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'promotion_type', $this->promotion_type])
            ->andFilterWhere(['like', 'cat', $this->cat]);

        return $dataProvider;
    }
}
