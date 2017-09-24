<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Item;
use backend\models\Category;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(['action' => Url::to(['order/add-item'])]); ?>
    <div class="form-group field-orderitem-cat">
        <label class="control-label" for="category_id">Category</label>
        <?=
        Select2::widget([
            'name' => 'category_id',
            'data' => ArrayHelper::map(Category::find()->all(), 'id',
                function($cat) {
                    return $cat['id'] . ' : ' . $cat['name'];
                }
            ),
            'pluginOptions' => [
                'allowClear' => true
            ],
            'options' => [
                'placeholder' => '-- please select --',
                'onchange' => '$("#order_item_' . $model->order_id . '").select2("val", "");'
                . '$.post( "' . Url::to(['/order/category-item']) . '?id="+$(this).val(), function( data ) {
                    $( "select#order_item_' . $model->order_id . '" ).html( data );
                });'
            ],
        ]);
        ?>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'order_id')->hiddenInput()->label(false) ?>

    <?=
    $form->field($model, 'item_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Item::find()->all(), 'id',
            function($item) {
                return $item['id'] . ' : ' . $item['name'];
            }
        ),
        'options' => [
	    'id' => 'order_item_' . $model->order_id,
            'placeholder' => '-- please select --'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ])->label('Item')
    ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
