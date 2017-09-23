<?php

namespace frontend\controllers;

use backend\models\Setting;
use yii\filters\AccessControl;

class ManageTableController extends \yii\web\Controller {

    /**
     * @inheritdoc
     */
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

    public function actionIndex() {
        $tables = Setting::find()
                ->where(['key' => 'tables'])
                ->one();
        return $this->render('index', ['tables' => $tables->value]);
    }

}
