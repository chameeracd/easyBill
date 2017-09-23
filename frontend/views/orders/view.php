<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'table',
            'inhouse',
            'opened_at',
            'closed_at',
            'status',
            'total',
        ],
    ]) ?>

    <div class="form-group">
        <?php
            if ($model->status == 'OPEN') {
                echo Html::a(Yii::t('app', 'Edit'), ['order/edit', 'order_id' => $model->id], ['class' => 'btn btn-success']);
                echo '&nbsp;';
                echo Html::a(Yii::t('app', 'Close & Print'), ['order/print', 'id' => $model->id], ['class' => 'btn btn-danger']);
            } else {
                echo Html::a(Yii::t('app', 'Print'), ['order/print', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
        ?>
    </div>

</div>
