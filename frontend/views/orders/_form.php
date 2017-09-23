<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Setting;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php
    $form = ActiveForm::begin();
    $tables = Setting::find()
                        ->where(['key' => 'tables'])
                        ->one()->value;
    ?>

    <?= $form->field($model, 'table')->dropDownList(array_combine(range(1, $tables),range(1, $tables))) ?>

    <?= $form->field($model, 'inhouse')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
