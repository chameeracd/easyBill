<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $item_id
 * @property string $rate
 * @property integer $qty
 * @property boolean $hh
 * @property string $total
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Item $item
 * @property Order $order
 */
class OrderItem extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_id', 'item_id', 'qty'], 'required'],
            [['order_id', 'item_id', 'qty', 'created_at', 'updated_at'], 'integer'],
            [['total', 'rate'], 'number'],
            [['hh'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'rate' => Yii::t('app', 'Rate'),
            'qty' => Yii::t('app', 'Qty'),
            'hh' => Yii::t('app', 'Happy Hour'),
            'total' => Yii::t('app', 'Total'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem() {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder() {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

}
