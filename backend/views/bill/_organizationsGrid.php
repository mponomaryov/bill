<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
?>

<?php Pjax::begin(['enablePushState' => false]) ?>

    <div class="error hidden text-danger">Organization is not selected</div>

    <?= GridView::widget([
        'id' => 'organizations-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\RadioButtonColumn',
                //'name' => 'payer_id',
                'radioOptions' => function ($model) {
                    return [
                        'value' => $model['id'],
                    ];
                },
            ],

            'name',
            'address',
            'itn',
            'iec',

        ],
    ]) ?>

<?php Pjax::end() ?>
