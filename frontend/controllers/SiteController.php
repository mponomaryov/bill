<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;

use frontend\models\forms\BillForm;

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
     * Displays bill form or PDF document
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new BillForm();

        $app = Yii::$app;

        if ($model->load($app->request->post())) {
            try {
                $bill = $model->save();
            } catch (\Exception $e) {
                throw new ServerErrorHttpException();
            }

            if ($bill) {
                $app->response->format = 'pdf';
                $app->layoutPath = '@common/views/layouts';
                $this->viewPath = '@common/views/pdf';

                return $this->render('index', [
                    'model' => $bill,
                ]);
            }
        }

        $this->layout = 'index';

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
