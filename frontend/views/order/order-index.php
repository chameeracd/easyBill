<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $this yii\web\View */
$this->title = 'Edit Order';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Tables'), 'url' => ['manage-table/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Process Order'), 'url' => ['order/process', 'id' => $order_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Alert::widget() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item.name',
            'rate',
            'qty',
            'hh',
             'total',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>

</div>
