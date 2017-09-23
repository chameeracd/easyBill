<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderItem */

$this->title = 'Edit Order Item';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Tables'), 'url' => ['manage-table/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Process Order'), 'url' => ['order/process', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Edit Order'), 'url' => ['order/edit', 'order_id' => $model->order_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
