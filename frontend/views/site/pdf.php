<?php

/* @var $this yii\web\View */
/* @var $model \frontend\models\forms\RequisitesForm */

use yii\helpers\StringHelper;

use frontend\helpers\PriceHelper;

$this->title = '';

$dummyPrice = 999;
$totalPrice = $model->quantity * $dummyPrice;
?>
<div style="width: 800px">
<table class="table">
    <caption class="table__caption table__caption_align_center">счет № xxx от 14.12.2111</caption>
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
<?php foreach (['Плательщик', 'Получатель'] as $title): ?>
    <p>
        <?= $title ?>: <?= $model->name ?>, ИНН
        <?= implode('/', array_filter([$model->itn, $model->iec])) ?>,
        <?= $model->address ?>
    </p>
<?php endforeach ?>
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
            <td class="table__cell">
                <?= $model->quantity ?>
            </td>
            <td class="table__cell">шт.</td>
            <td class="table__cell">
                <?= $dummyPrice ?>
            </td>
            <td class="table__cell">
                <?= $totalPrice ?>
            </td>
        </tr>
        <tr>
            <td class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right"
                colspan="5"
            >
                Итого:
            </td>
            <td class="table__cell"><?= $totalPrice ?></td>
        </tr>
        <tr>
            <td class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right"
                colspan="5"
            >
                В том числе НДС (20%):
            </td>
            <td class="table__cell"><?= $totalPrice * 0.2 ?></td>
        </tr>
        <tr>
            <td class="table__cell
                       table__cell_border_none
                       table__cell_text-align_right"
                colspan="5"
            >
                    Всего к оплате:
            </td>
            <td class="table__cell"><?= $totalPrice ?></td>
        </tr>
    </tbody>
</table>
<p>
    Всего наименований 1, на сумму <?= $totalPrice ?>
</p>
<p>
    <b><?= StringHelper::mb_ucfirst(PriceHelper::price2Str($totalPrice)) ?></b>
</p>
<div>
    <p>Индивидуальный предприниматель:</p>
    <p>Пупкин В.В.</p>
    <img src="stamp.png">
</div>
</div>
