<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <label class="control-label"><?= Yii::t('app', 'Table') . ' ' . $model->table ?></label>&nbsp;
    <label class="control-label"><?= Yii::t('app', 'Total') . ' ' . $total ?></label>
    <br/>
    <?=
    $this->render('_add_item_form', [
        'model' => $item,
    ])
    ?>
    <div class="form-group">
        <?= Html::a(Yii::t('app', 'Process'), ['order/process', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </div>

</div>
