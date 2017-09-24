<?php
use backend\models\Order;
use backend\models\Setting;
use yii\helpers\Html;
?>

<div class="bill">
    <div class="row">
        <!-- <div class="col-xs-2 text-left">
            <?= Html::img('/images/logo2.png',['width' => '90px']) ?>
        </div> -->
        <div class="col-xs-12 text-center">
            <h5>Sea Food Restaurant</h5>
            <h6>Mirissa</h6>
            <!-- <h6>+94 41 22 51 699</h6> -->
        </div>
    </div>
    <?php $order = Order::findOne($id); ?>
    <div class="row text-right">
        <div class="col-xs-2">
            <p>
                <strong>
                    Invoice# : <?= $id ?>
                </strong>
            </p>
        </div>
        <div class="col-xs-4 col-xs-offset-4">
            <strong>
                Date : <?= date("Y-m-d", strtotime($order->opened_at)) ?>
            </strong>
        </div>
    </div>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th><strong><?= Yii::t('app', 'Qty') ?></strong></th>
                <th><strong><?= Yii::t('app', 'Item') ?></strong></th>
                <!--<th><strong><?= Yii::t('app', 'Dis:') . '(%)' ?></strong></th>-->
                <th><strong><?= Yii::t('app', 'Rate') ?></strong></th>
                <th><strong><?= Yii::t('app', 'Price') ?></strong></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total = 0;
            foreach ($orderItems as $orderItem) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                $hh = ($orderItem->hh) ? ' <span class="badge">H:H</span>' : '';
                echo '<td>' . $orderItem->qty . '</td>';
                echo '<td>' . $orderItem->item->name . $hh . '</td>';
    //            echo '<td class="text-right">' . $orderItem->discount . '</td>';
                echo '<td class="text-right">' . number_format($orderItem->rate, 2, '.', ',') . '</td>';
                echo '<td class="text-right">' . number_format($orderItem->total, 2, '.', ',') . '</td>';
                echo '</tr>';
                $i++;
                $total += $orderItem->total;
            }

            $serviceCharge = Setting::find()
                            ->where(['key' => 'service_charge'])
                            ->one()->value;
            $inhouseDis = 0;
            if ($order->inhouse) {
                $inhouseDis = Setting::find()
                                ->where(['key' => 'inhouse_discount'])
                                ->one()->value;
            }
            ?>
        </tbody>
    </table>
    <div class="row text-right">
        <div class="col-xs-3 col-xs-offset-5">
            <p>
                <strong>
                    <?= Yii::t('app', 'Sub Total') ?> : <br>
                    <?= Yii::t('app', 'In-House Dis') . " $inhouseDis%" ?> : <br>
                    <?= Yii::t('app', 'Service Charge') ." $serviceCharge%" ?> : <br>
                    <?= Yii::t('app', 'Total') ?> : <br>
                </strong>
            </p>
        </div>
        <div class="col-xs-2">
            <strong>
                Rs. <?= number_format($total, 2, '.', ',') ?> <br>
                <?php $discount = ($inhouseDis > 0) ? $total * (double) ($inhouseDis / 100) : 0; ?>
                (Rs. <?= number_format($discount, 2, '.', ',') ?>) <br>
                <?php $service = $total * (double) ($serviceCharge / 100) ?>
                Rs. <?= number_format($service, 2, '.', ',') ?> <br>
                Rs. <?= number_format($total + $service - $discount, 2, '.', ',') ?> <br>
            </strong>
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row text-right">
        <div class="col-xs-4 col-xs-offset-8">
            <p>
                <strong>
                    ---------------------------<br/>
                    Signature
                </strong>
            </p>
        </div>
    </div>
</div>