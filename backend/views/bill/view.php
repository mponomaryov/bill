<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Bill */

$this->title = Yii::$app->formatter->asBillNumber($model->bill_number);
$this->params['breadcrumbs'][] = ['label' => 'Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-lg-6">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'bill_number:billNumber',
                    'created_at:date',
                ],
            ]) ?>

        </div>
        <div class="col-lg-6">

            <?= DetailView::widget([
                'model' => $model->payer,
                'attributes' => [
                    'name',
                    'address',
                    'itn',
                    'iec',
                ],
            ]) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getBillItems()->with('item'),
                ]),
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'item.name',
                    'item.price:money',
                    'quantity',
                    'itemTotalPrice:money',
                ],
            ]); ?>

        </div>
    </div>

</div>
