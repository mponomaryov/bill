<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\forms\RequisitesForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'index';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $model = new RequisitesForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $bill = $model->createBill();

            if ($bill) {
                Yii::$app->response->format = 'pdf';
                return $this->render('pdf', ['model' => $bill]);
            }

            throw new \yii\web\ServerErrorHttpException;
        }

        return $this->render('requisitesForm', ['model' => $model]);
    }
}
