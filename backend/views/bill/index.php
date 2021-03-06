<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ButtonDropdown;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ButtonDropdown::widget([
            'label' => 'Create Bill',
            'options' => ['class' => 'btn btn-success'],
            'dropdown' => [
                'items' => [
                    [
                        'label' => 'With saved organization',
                        'url' => 'create',
                    ],
                    [
                        'label' => 'With new organization',
                        'url' => 'create-new',
                    ],
                ],
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bill_number:billNumber',
            'payerName',
            'payerItn',
            'payerIec',
            [
                'attribute' => 'created_at',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'type' => DatePicker::TYPE_RANGE,
                    'readonly' => true,
                    'separator' => '-',
                    'attribute' => 'startDate',
                    'attribute2' => 'endDate',
                    'options' => ['style' => 'width: 100px'],
                    'options2' => ['style' => 'width: 100px'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'keepEmptyValues' => true,
                        'todayHighlight' => true,
                        'orientation' => 'left bottom',
                    ],
                ]),
            ],

            [
                'class' => 'backend\components\ActionColumn',
                'template' => '{view} {pdf} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
