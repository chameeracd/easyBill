<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form about `backend\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['item_id', 'qty', 'created_at', 'updated_at'], 'integer'],
            [['discount', 'rate', 'total'], 'number'],
            [['item.name'], 'safe'],
        ];
    }
    
    public function attributes() {
        return array_merge(parent::attributes(), ['item.name']);
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = OrderItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['item' => function($query) {
            $query->from(['item' => 'item']);
        }]);

        $dataProvider->sort->attributes['item.name'] = [
            'asc' => ['item.name' => SORT_ASC],
            'desc' => ['item.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'item_id' => $this->item_id,
            'qty' => $this->qty,
            'discount' => $this->discount,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['LIKE', 'item.name', $this->getAttribute('item.name')]);

        return $dataProvider;
    }

}
