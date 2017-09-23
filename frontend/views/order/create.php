<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(['action' => Url::to(['order/create'])]); ?>

    <?= $form->field($model, 'table')->hiddenInput()->label('Table: ' . $model->table) ?>
    <?= $form->field($model, 'inhouse')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Open Table'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>