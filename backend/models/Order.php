<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $table
 * @property string $opened_at
 * @property string $closed_at
 * @property string $status
 * @property string $total
 * @property boolean $inhouse
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrderItem[] $orderItems
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
    public function rules()
    {
        return [
            [['table'], 'required'],
            [['table', 'created_at', 'updated_at'], 'integer'],
            [['opened_at', 'closed_at', 'inhouse'], 'safe'],
            [['total'], 'number'],
            [['status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table' => Yii::t('app', 'Table'),
            'opened_at' => Yii::t('app', 'Opened At'),
            'closed_at' => Yii::t('app', 'Closed At'),
            'status' => Yii::t('app', 'Status'),
            'total' => Yii::t('app', 'Total'),
            'inhouse' => Yii::t('app', 'Inhouse'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }
}
