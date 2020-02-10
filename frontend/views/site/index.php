<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\forms\RequisitesForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Requisites';
?>

<?php $this->beginBlock('table-caption'); ?>
    Счет № 00017 от <?= date('Y') ?>
<?php $this->endBlock(); ?>

<hr class="line page__block">

<?php
$formId = 'requisites-form';
$form = ActiveForm::begin([
    'id' => $formId,
    'options' => ['class' => 'form page__block'],
    'fieldClass' => 'frontend\components\ActiveField',
    'fieldConfig' => [
        'options' => ['class' => 'form__group'],
        'labelOptions' => ['class' => 'form__label form__group--area-label'],
        'inputOptions' => ['class' => 'form__input form__group--area-input'],
        'errorOptions' => ['class' => 'form__info form__group--area-info'],
        'template' => "{label}\n{input}\n{error}",
    ],
]);
?>
    <fieldset class="fieldset
                     form__fieldset
                     grid
                     grid--two-columns
                     grid--column-gap_10px">
        <legend class="fieldset__legend">
            Заполните данные плательщика:
        </legend>

        <?= $form->field($model, 'name')->textInput([
            'autofocus' => true,
            'maxlength' => 255,
        ]) ?>

        <?= $form->field($model, 'address')->textInput([
            'maxlength' => 255,
        ]) ?>

        <?= $form->field($model, 'itn')->textInput([
            'maxlength' => 12,
        ]) ?>

        <?= $form->field($model, 'iec')->textInput([
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'currentAccount')->textInput([
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'bankName')->textInput([
            'maxlength' => 255,
        ]) ?>

        <?= $form->field($model, 'correspondingAccount')->textInput([
            'maxlength' => true,
        ]) ?>

        <?= $form->field($model, 'bic')->textInput([
            'maxlength' => true,
        ]) ?>

    </fieldset>
<?php ActiveForm::end(); ?>

<table class="table page__block">
    <thead>
        <tr class="table__row
                   table__row--height_auto">
            <th class="table__cell">
                №
            </th>
            <th class="table__cell">
                Наименование товара, работ, услуг
            </th>
            <th class="table__cell">
                Кол-во
            </th>
            <th class="table__cell">
                Ед.
            </th>
            <th class="table__cell">
                Цена
            </th>
            <th class="table__cell">
                Сумма
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="table__row">
            <td class="table__cell">
                1
            </td>
            <td class="table__cell">
                Товар/работа/услуга
            </td>
            <td class="table__cell">
                1
            </td>
            <td class="table__cell">
                шт.
            </td>
            <td colspan="2" class="table__cell">
                <?= $form->field($model, 'quantity')->textInput([
                    'type' => 'number',
                    'value' => 1,
                    'min' => 1,
                    'form' => $formId,
                ])->label(false) ?>
            </td>
        </tr>
    </tbody>
</table>

<hr class="line page__block">

<div class="page__block
            grid
            grid--two-columns">
    <p>Индивидуальный предприниматель:</p>
    <p>
        Фамилия И.О.
        <?= Html::img(Yii::getAlias('@web' . '/stamp.png')) ?>
    </p>
    <div>
        <?= Html::submitButton('Сохранить и скачать', [
            'class' => 'button button--rounded',
            'name' => 'save-button',
            'form' => $formId
        ]) ?>
    </div>
</div>
