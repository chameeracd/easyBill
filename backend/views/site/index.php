<?php

use miloschuman\highcharts\Highcharts;
use backend\models\OrderItem;

/* @var $this yii\web\View */

$this->title = 'Central Beach Restaurant';
?>
<div class="site-index">

    <?php
    $dailySales = OrderItem::find()
            ->select([
                "SUM(total) AS total, FROM_UNIXTIME(`created_at`, '%d.%m.%Y') as date"
            ])
            ->groupBy(["FROM_UNIXTIME(`created_at`, '%d.%m.%Y')"])
            ->limit(30)
            ->asArray()
            ->all();
    $category = array();
    $values = array();
    foreach ($dailySales as $sale) {
        $category[] = $sale['date'];
        $values[] = (double) $sale['total'];
    }

    echo Highcharts::widget([
        'scripts' => [
            'modules/exporting',
            'themes/grid-light',
        ],
        'options' => [
            'title' => [
                'text' => 'Daily Sales',
            ],
            'xAxis' => [
                'categories' => $category,
            ],
            'series' => [
                [
                    'type' => 'column',
                    'name' => 'Sales',
                    'data' => $values,
                ],
            ],
            'credits' => ['enabled' => false],
        ]
    ]);
    ?>
</div>
