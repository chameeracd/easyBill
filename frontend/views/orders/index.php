<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Alert::widget() ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'table',
            [
                'label' => 'In-house',
                'attribute' => 'inhouse',
                'value' => function ($model) {
                    return ($model->inhouse) ? 'Yes' : 'No';
                },
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return ($model->status == 'OPEN') ? '<h4><span class="label label-success">Open</span></h4>' : '<h4><span class="label label-default">Closed</span></h4>';
                },
            ],
            'opened_at',
            'closed_at',
            'total',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {view}'],
        ],
    ]);
    ?>

</div>
