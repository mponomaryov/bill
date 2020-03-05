<?php
namespace backend\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

use backend\components\BaseController;
use common\models\Bill;
use backend\models\forms\BillForm;
use backend\models\BillSearch;
use backend\models\OrganizationSearch;

/**
 * BillController implements the CRUD actions for Bill model.
 */
class BillController extends BaseController
{
    /**
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bill model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BillForm([
            'scenario' => BillForm::SCENARIO_EXIST_ORGANIZATION,
        ]);

        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            try {
                $bill = $model->save();
            } catch (\Exception $e) {
                throw new ServerErrorHttpException();
            }

            if ($bill) {
                return $this->redirect(['view', 'id' => $bill->id]);
            }
        }

        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search($request->queryParams);
        $dataProvider->pagination = [
            'pageSizeLimit' => false,
            'defaultPageSize' => 5,
        ];

        if ($request->isPjax) {
            return $this->renderPartial('_organizationsGrid', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'isNewOrganization' => false,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateNew()
    {
        $model = new BillForm([
            'scenario' => BillForm::SCENARIO_NEW_ORGANIZATION,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $bill = $model->save();
            } catch (\Exception $e) {
                throw new ServerErrorHttpException();
            }

            if ($bill) {
                return $this->redirect(['view', 'id' => $bill->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'isNewOrganization' => true,
        ]);
    }

    /**
     * Updates an existing Bill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Here we use a little of nails...
        $billItem = $model->billItems[0];

        $quantityModel = new DynamicModel(['quantity' => $billItem->quantity]);
        $quantityModel->addRule('quantity', 'required')
            ->addRule('quantity', 'integer');

        if ($quantityModel->load(Yii::$app->request->post()) &&
            $quantityModel->validate()) {

            $billItem->quantity = $quantityModel->quantity;
            $billItem->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'quantityModel' => $quantityModel,
        ]);
    }

    /**
     * Deletes an existing Bill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Displays an existing Bill model as PDF document.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);

        $app = Yii::$app;

        $app->response->format = 'pdf';
        $app->layoutPath = '@common/views/layouts';
        $this->viewPath = '@common/views/pdf';

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
