<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\forms\RequisitesForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Requisites';
?>
<div style="width: 800px">
<table class="table">
    <caption class="table__caption">счет № xxx от 14.12.2111</caption>
    <tbody>
        <tr>
            <td class="table__cell table__cell_width_quarter">ИНН 772160030650</td>
            <td class="table__cell table__cell_width_quarter">КПП</td>
            <td class="table__cell" rowspan="2">СЧ №</td>
            <td class="table__cell" rowspan="2">40802810808270000232</td>
        </tr>
        <tr>
            <td class="table__cell" colspan="2">
                Получатель
                <br>
                ИП Пупкин Василий Васильевич
            </td>
        </tr>
        <tr>
            <td class="table__cell" colspan="2" rowspan="2">
                Банк получателя
                <br>
                Филиал "Бизнес онлайн" Публичного акционерного общества "Ханты-Мансийский банк Открытие"
            </td>
            <td class="table__cell">БИК</td>
            <td class="table__cell table__cell_bottom-border_none">044583999</td>
        </tr>
        <tr>
            <td class="table__cell">СЧ №</td>
            <td class="table__cell table__cell_top-border_none">301001810600000000999</td>
        </tr>
    </tbody>
</table>
<hr>

<?php
$formId = 'requisites-form';
$form = ActiveForm::begin(['id' => $formId]);
?>
    <fieldset class="fieldset">
        <legend>Заполните данные плательщика:</legend>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'maxlength' => 255]) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'itn')->textInput(['maxlength' => 12]) ?>

        <?= $form->field($model, 'iec')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'currentAccount')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bankName')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'correspondingAccount')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bic')->textInput(['maxlength' => true]) ?>

    </fieldset>
<?php ActiveForm::end(); ?>

<table class="table">
    <thead>
        <tr>
            <th class="table__cell">№</th>
            <th class="table__cell">Наименование товара, работ, услуг</th>
            <th class="table__cell">Кол-во</th>
            <th class="table__cell">Ед.</th>
            <th class="table__cell">Цена</th>
            <th class="table__cell">Сумма</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="table__cell">1</td>
            <td class="table__cell">Элефантус вульгарис</td>
            <td class="table__cell">1</td>
            <td class="table__cell">шт.</td>
            <td class="table__cell" colspan="2">
                <?= $form->field($model, 'quantity')->textInput(['type' => 'number', 'value' => 1, 'min' => 1, 'form' => $formId])->label(false) ?>
            </td>
        </tr>
    </tbody>
</table>
<hr>
<div>
    <p>Индивидуальный предприниматель:</p>
    <p>Пупкин В.В.</p>
    <img src="stamp.png">
</div>
<div>
    <?= Html::submitButton('Сохранить и скачать', ['class' => 'btn btn-primary', 'name' => 'save-button', 'form' => $formId]) ?>
</div>
</div>
