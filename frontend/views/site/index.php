<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Central Beach Restaurant';
?>
<div class="site-index">

    <div class="body-content">

        <div class="jumbotron">
            <h1>Central Beach Restaurant</h1>
            <?= Html::a(Yii::t('app', 'Manage Tables'), ['manage-table/index'], ['class' => 'btn btn-success']) ?>
        </div>

    </div>
</div>
