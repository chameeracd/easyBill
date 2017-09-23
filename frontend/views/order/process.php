<?php

use yii\helpers\Html;
use backend\models\Order;

/* @var $this yii\web\View */
$this->title = 'Process Order';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Tables'), 'url' => ['manage-table/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manage-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container-fluid">

        <?= $this->render('_bill_table', ['orderItems' => $orderItems, 'id' => $id]); ?>

        <div class="form-group">
            <?php
            $order = Order::findOne($id);
            if ($order->status == 'OPEN') {
                echo Html::a(Yii::t('app', 'Edit'), ['order/edit', 'order_id' => $id], ['class' => 'btn btn-success']);
                echo '&nbsp;';
                echo Html::a(Yii::t('app', 'Close & Print'), ['order/print', 'id' => $id], ['class' => 'btn btn-danger']);
            } else {
                echo Html::a(Yii::t('app', 'Print'), ['order/print', 'id' => $id], ['class' => 'btn btn-danger']);
            }
            ?>
        </div>
    </div>
</div>