<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use backend\models\Order;
use backend\models\OrderItem;
use kartik\growl\Growl;

/* @var $this yii\web\View */
$this->title = 'Manage Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
<div class="manage-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container-fluid">
        <?php
        for ($i = 1; $i <= $tables; $i++) {
            $open = Order::find()
                    ->where(['status' => 'OPEN', 'table' => $i])
                    ->one();
            $status = 'FREE';
            $class = 'btn-default';
            $size = 'modal-sm';
            if ($open) {
                $status = 'OPEN';
                $class = 'btn-success';
                $size = 'modal-md';
            }
            if ($i % 6 == 0)
                echo '<div class="row">';
            echo '<div class="col-md-2">';
            Modal::begin([
                'options' => [
                    'tabindex' => false // important for Select2 to work properly
                ],
                'toggleButton' => [
                    'label' => "Table:$i<br/>" . $status,
                    'class' => "btn $class btn-lg btn-block"
                ],
                'size' => $size,
            ]);

            if ($open) {
                $item = new OrderItem();
                $item->order_id = $open->id;
                $total = OrderItem::find()
                        ->where('order_id = ' . $open->id)
                        ->sum('total');
                echo $this->render('/order/manage', ['model' => $open, 'item' => $item, 'total' => $total]);
            } else {
                $model = new Order();
                $model->table = $i;
                echo $this->render('/order/create', ['model' => $model]);
            }
            Modal::end();
            echo '</div>';
            if ($i % 6 == 0)
                echo '</div><br/>';
        }
        ?>
    </div>
</div>
