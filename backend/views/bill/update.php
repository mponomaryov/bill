<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Bill */

$billNumber = Yii::$app->formatter->asBillNumber($model->bill_number);

$this->title = 'Update Bill: ' . $billNumber;
$this->params['breadcrumbs'][] = ['label' => 'Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $billNumber,
    'url' => ['view', 'id' => $model->id]
];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bill-update">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?php $form = ActiveForm::begin() ?>

        <div class="form-group">
            <label class="contol-label">Товар</label>
            <?= Html::dropDownList('', null, \common\models\Item::find()
                ->select(['name', 'id'])
                ->indexBy('id')
                ->column(), ['class' => 'form-control', 'disabled' => true]
            ) ?>
        </div>

        <?= $form->field($quantityModel, 'quantity')->textInput([
            'type' => 'number',
            'min' => 1,
        ])->label('Количество') ?>

        <div class="form-group">
            <?= Html::submitButton('Save', [
                'class' => 'btn btn-success',
            ])?>
        </div>

    <?php ActiveForm::end() ?>

</div>
