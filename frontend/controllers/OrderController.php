<?php

namespace frontend\controllers;

use Yii;
use backend\models\Order;
use backend\models\Item;
use backend\models\OrderItem;
use frontend\models\OrderItemSearch;
use backend\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use yii\helpers\Html;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ]
        ];
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'manage table' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Order();
        $model->status = 'OPEN';
        $model->opened_at = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'icon' => 'fa fa-users',
                'message' => Yii::t('app', "Order '{$model->id}' Opened in the table '{$model->table}' , inhouse : '{$model->inhouse}'"),
                'title' => Yii::t('app', Html::encode('Table Opened!'))
            ]);
            return $this->redirect(['manage-table/index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Process a Order model.
     * If creation is successful, the browser will be redirected to the 'manage table' page.
     * @param integer $id
     * @return mixed
     */
    public function actionProcess($id) {
        $orderItems = OrderItem::find()
                ->where(['order_id' => $id])
                ->all();
        return $this->render('process', ['orderItems' => $orderItems, 'id' => $id]);
    }

    public function actionPrint($id) {
        $model = $this->findModel($id);

        if ($model->status == 'OPEN') {
            $model->status = 'CLOSED';
            $model->closed_at = date("Y-m-d H:i:s");

            $order = Order::findOne($id);
            $serviceCharge = Setting::find()
                            ->where(['key' => 'service_charge'])
                            ->one()->value;
            $inhouseDis = 0;
            if ($order->inhouse) {
                $inhouseDis = Setting::find()
                                ->where(['key' => 'inhouse_discount'])
                                ->one()->value;
            }

            $total = OrderItem::find()
                    ->where('order_id = ' . $id)
                    ->sum('total');

            $discount = ($inhouseDis > 0) ? number_format(($total * (double) $inhouseDis / 100), 2, '.', '') : 0;
            $service = number_format(($total * (double) $serviceCharge / 100), 2, '.', '');
            $model->total = $total + $service - $discount;
            $model->save();
        }

        $orderItems = OrderItem::find()
                ->where(['order_id' => $id])
                ->all();

        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_bill_table', ['orderItems' => $orderItems, 'id' => $id]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => 'A5',
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '
            .bill{font-size:10px}
            .table td {font-size:10px}
            .table th {font-size:10px}
            .table thead tr th, .table tbody tr td {
               padding:2px; 
            }
            .page-top{font-size:7px;margin-bottom:2px}
            ',
            // set mPDF properties on the fly
            'options' => ['title' => 'Print::' . ' Table - ' . $model->table],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['<p class="page-top">Sea Food Restaurant</p>'],
                'SetFooter' => ['<p class="page-top">{PAGENO}</p>'],
            ]
        ]);

        $pdf->render();
        die;
    }

    public function actionCategoryItem($id) {
        if ($id) {
            $items = Item::find()
                    ->where(['category_id' => $id])
                    ->all();
        } else {
            $items = Item::find()
                    ->all();
        }
        echo "<option value=''>-- please select --</option>";
        if (count($items) > 0) {
            foreach ($items as $item) {
                echo "<option value='" . $item->id . "'>" . $item->id . " : " . $item->name . "</option>";
            }
        }
    }

    public function actionAddItem() {
        $model = new OrderItem();
        $model->load(Yii::$app->request->post());

        if ($model->order->status == 'OPEN') {
            $model->discount = 0;

            $happyHour = Setting::find()
                    ->where(['key' => 'happy_hour_discount'])
                    ->one();
            $happyHourCat = Setting::find()
                    ->where(['key' => 'happy_hour_category'])
                    ->one();
            if ($happyHour->value != '' && in_array($model->item->category_id, explode(',', $happyHourCat->value))) {
                $happyHourDay = explode('-', Setting::find()
                                ->where(['key' => 'happy_hour_day'])
                                ->one()->value);
                $happyHourNight = explode('-', Setting::find()
                                ->where(['key' => 'happy_hour_night'])
                                ->one()->value);
                $now = date('H:i');

                $dateNow = \DateTime::createFromFormat('H:i', $now);
                $dayStart = \DateTime::createFromFormat('H:i', $happyHourDay[0]);
                $dayEnd = \DateTime::createFromFormat('H:i', $happyHourDay[1]);
                $nightStart = \DateTime::createFromFormat('H:i', $happyHourNight[0]);
                $nightEnd = \DateTime::createFromFormat('H:i', $happyHourNight[1]);

                if (($dateNow > $dayStart && $dateNow < $dayEnd) || ($dateNow > $nightStart && $dateNow < $nightEnd)) {
                    $key = array_search($model->item->category_id, explode(',', $happyHourCat->value));
                    $hhDis = explode(',', $happyHour->value);
                    $model->discount = $hhDis[$key];
                }
            }

            $rate = ($model->rate) ? $model->rate : $model->item->price;
            $price = ($model->discount != 0) ? $rate - ((double) $rate * (double) $model->discount / 100) : $rate;
            $model->rate = $rate;

            $model->total = $model->qty * (double) $price;
            if ($model->save()) {
                // Yii::$app->getSession()->setFlash('success', "'{$model->item->name}' Added to the Order '{$model->order_id}'");
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'icon' => 'fa fa-users',
                    'message' => Yii::t('app', "'{$model->item->name}' Added to the Order '{$model->order_id}'"),
                    'title' => Yii::t('app', Html::encode('Item Added!'))
                ]);
                return $this->redirect(['manage-table/index']);
            } else {
                return $this->render('_add_item_form', [
                            'model' => $model,
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', [
                'type' => 'danger',
                'icon' => 'fa fa-users',
                'message' => Yii::t('app', 'Order Closed!'),
                'title' => Yii::t('app', Html::encode('Order'))
            ]);
            return $this->redirect(['manage-table/index']);
        }
    }

    /**
     * Lists all OrderItem models.
     * @return mixed
     */
    public function actionEdit($order_id) {
        $order = Order::findOne($order_id);
        if ($order->status == 'OPEN') {
            $searchModel = new OrderItemSearch();
            $searchModel->order_id = $order_id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('order-index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'order_id' => $order_id,
            ]);
        } else {
            Yii::$app->getSession()->setFlash('error', 'Order Closed!');
            return $this->redirect(['manage-table/index']);
        }
    }

    /**
     * Updates an existing OrderItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findOrderItemModel($id);
        if ($model->order->status == 'OPEN') {
            if ($model->load(Yii::$app->request->post())) {
                $rate = ($model->rate) ? $model->rate : $model->item->price;
                $price = ($model->discount != 0) ? $rate - ((double) $rate * (double) $model->discount / 100) : $rate;
                $model->rate = $rate;

                $model->total = $model->qty * (double) $price;
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', "Item '{$model->id}' Updated in the Order '{$model->order_id}'");
                    return $this->redirect(['edit', 'order_id' => $model->order_id]);
                }
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'Order Closed!');
            return $this->redirect(['manage-table/index']);
        }
    }

    /**
     * Deletes an existing OrderItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findOrderItemModel($id);
        if ($model->order->status == 'OPEN') {
            $orderId = $model->order_id;
            $model->delete();

            Yii::$app->getSession()->setFlash('success', "Item '{$model->id}' Deleted from the Order '{$model->order_id}'");
            return $this->redirect(['edit', 'order_id' => $orderId]);
        } else {
            Yii::$app->getSession()->setFlash('error', 'Order Closed!');
            return $this->redirect(['manage-table/index']);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the OrderItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrderItemModel($id) {
        if (($model = OrderItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
