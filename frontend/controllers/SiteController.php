<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;

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
     * Displays requisites form or PDF document
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'index';

        $model = new RequisitesForm();

        if ($model->load(Yii::$app->request->post())) {
            try {
                $bill = $model->createBill();
            } catch (\Exception $e) {
                throw new ServerErrorHttpException();
            }

            if ($bill) {
                Yii::$app->response->format = 'pdf';

                return $this->render('pdf', [
                    'model' => $bill
                ]);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
