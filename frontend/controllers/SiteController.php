<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use frontend\models\forms\RequisitesForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays requisites form
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'index';

        $model = new RequisitesForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $bill = $model->createBill();

            if ($bill) {
                Yii::$app->response->format = 'pdf';
                return $this->render('pdf', ['model' => $bill]);
            }

            throw new \yii\web\ServerErrorHttpException;
        }

        return $this->render('index', ['model' => $model]);
    }
}
