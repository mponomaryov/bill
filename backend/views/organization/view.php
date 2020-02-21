<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Organization */
/* @var $dataProvider yii\data\ActiveDataProvider*/

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary'
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'address',
            'itn',
            'iec',
            'current_account',
            'bank',
            'corresponding_account',
            'bic',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bill_number:billNumber',
            'created_at:date',

            [
                'class' => 'backend\components\ActionColumn',
                'template' => '{view} {pdf} {update} {delete}',
                'controller' => 'bill',
            ],
        ],
    ]); ?>

</div>
